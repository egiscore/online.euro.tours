<?php
if (!isset($_SERVER['SERVER_ADDR']) && isset($_SERVER['LOCAL_ADDR'])) {
    $_SERVER['SERVER_ADDR'] = $_SERVER['LOCAL_ADDR'];
}
//define('CRON_HOST', $_SERVER['SERVER_ADDR']);
//define('CRON_PORT', $_SERVER['SERVER_PORT']);

function is_private_server() {
    $ips = array();
    $tmp = explode(':', $_SERVER['HTTP_HOST']);
    $http_host = reset($tmp);
    if (ip2long($http_host) === false) { // is not ip
        $addr = gethostbyname($http_host);
    } else {
        $addr = $http_host;
    }
    $ips[] = $addr;
    foreach (array('HTTP_X_REAL_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR', 'SERVER_ADDR') as $var) {
        if (isset($_SERVER[$var]) && false !== ip2long($_SERVER[$var])) {
            $ips[] = $_SERVER[$var];
        }
    }
    foreach ($ips as $addr) {
        if (!is_private_ip($addr)) {
            return false;
        }
    }
    return true;
}

function is_private_ip($ip) {
    $long_ip = ip2long($ip);
    if (false === $long_ip) {
        return true;
    }
    if (extension_loaded('filter')) {
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return true;
        }
    } else {
        $private = array(
            '10.0.0.0' => '10.255.255.255', // single class A network
            '172.16.0.0' => '172.31.255.255', // 16 contiguous class B network
            '192.168.0.0' => '192.168.255.255', // 256 contiguous class C network
            '169.254.0.0' => '169.254.255.255', // Link-local address also refered to as Automatic Private IP Addressing
            '127.0.0.0' => '127.255.255.255' // localhost
        );
        if ($long_ip != -1) {
            foreach ($private AS $start => $end) {
                if ($long_ip >= ip2long($start) && $long_ip <= ip2long($end)) {
                    return true;
                }
            }
        }
    }
    return false;
}

function get_http_host() {
    $tmp = explode(':', $_SERVER['HTTP_HOST']);
    $http_host = reset($tmp);
    if (ip2long($http_host) === false) { // is not ip
        if (gethostbyname($http_host) == $_SERVER['SERVER_ADDR']) {
            return $_SERVER['HTTP_HOST'];
        }
    }
    if (is_private_ip($_SERVER['REMOTE_ADDR'])) {
        return $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT'];
    }
    return $_SERVER['HTTP_HOST'];
}

function soap_fault_xml() {
    return '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
      <SOAP-ENV:Body>
        <SOAP-ENV:Fault>
          <faultcode>100500</faultcode>
          <faultstring>Some error</faultstring>
        </SOAP-ENV:Fault>
      </SOAP-ENV:Body>
    </SOAP-ENV:Envelope>';
}

if (!isset($_GET['check'])) {
    ini_set('default_socket_timeout', 3);
    if (file_exists('properties.php')) {
        include 'properties.php';
    }
    function check_soap_fault() {
        if (!extension_loaded('soap')) {
            return false;
        }
        $host = (defined('CRON_HOST')) ? CRON_HOST . ':' . CRON_PORT : get_http_host();
        $client = new SoapClient(
            null, array(
                    'uri' => 'http://any-uri',
                    'location' => 'http://' . $host . $_SERVER['REQUEST_URI'] . '?check=soap_fault',
                    'trace' => 1,
                )
        );
        try {
            $client->fault();
        } catch (SoapFault $e) {
            return soap_fault_xml() == $client->__getLastResponse() && 100500 == $e->faultcode;
        } catch (Exception $e) {
            $e; //$phpcs
        }
        return false;
    }

    function client_real_ip() {
        $result = 'unknown';
        $check_url = 'http://redmine.samo.ru/requirements/online.php?url=' . base64_encode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '?check=remote_addr');
        if (false !== ($return = @file_get_contents($check_url))) {
            $result = $return;
        }
        return $result;
    }

    function caching_extension() {
        $supported_extensions = array('apcu', 'apc');
        foreach ($supported_extensions as $ext) {
            if (extension_loaded($ext)) {
                return $ext;
            }
        }
        return implode(', ', $supported_extensions);
    }

    function opcode_extension() {
        $supported_extensions = array('Zend OPcache', 'apc');
        foreach ($supported_extensions as $ext) {
            if (extension_loaded($ext)) {
                if ('apc' == $ext && extension_loaded('apcu')) {
                    continue;
                }
                return $ext;
            }
        }
        return implode(', ', $supported_extensions);
    }

    function database_extension() {
        $supported_extensions = array('mssql', 'sqlsrv', 'pdo_dblib');
        foreach ($supported_extensions as $ext) {
            if (extension_loaded($ext)) {
                if ('sqlsrv' == $ext) {
                    if (defined('hostname') && defined('username') && defined('password')) {
                        $connectionInfo = array(
                            "UID" => username,
                            "PWD" => password,
                            "APP" => "Samo-Online",
                            "MultipleActiveResultSets" => true,
                        );
                        if ($conn = @sqlsrv_connect(hostname, $connectionInfo)) {
                            if ($data = @sqlsrv_client_info($conn)) {
                                $ext = sprintf("%s (%s.v%s)", $ext, $data['DriverDllName'], $data['DriverVer']);
                                @sqlsrv_close($conn);
                            }
                        }
                    }
                }
                return $ext;
            }
        }
        return implode(', ', $supported_extensions);
    }

    function xcache_version() {
        $ext = new ReflectionExtension('xcache');
        return $ext->getVersion();
    }

    function module_installed($module) {
        static $routes = null;
        if (null == $routes) {
            $routes = array();
            if (file_exists('routes.php')) {
                include 'routes.php';
            }
        }
        if (!is_array($module)) {
            $module = array($module);
        }
        return count(array_intersect($module, array_keys($routes)));
    }

    $ini = array();
    if ($loaded = php_ini_loaded_file()) {
        $ini[] = $loaded;
    }
    if ($add = php_ini_scanned_files()) {
        $ini = array_merge($ini, explode(',' . PHP_EOL, $add));
    }

    $checks = array();

    if (version_compare(PHP_VERSION, '7.0') < 0) {
        $checks[] = array(version_compare(PHP_VERSION, '5.6') >= 0, true, '<b>PHP_VERSION</b> >= 5.6 required, actual is ' . PHP_VERSION, 'https://secure.php.net/downloads.php#v5' , 'Для работы системы требуется php версии 5.6', 'Установите PHP версии 5.6.x');
    } else {
        $checks[] = array(version_compare(PHP_VERSION, '7.0') < 0, false, '<b>PHP_VERSION</b> >= 7.x not tested', 'https://secure.php.net/downloads.php#v5', 'Работа системы c PHP 7.x не гарантируется', 'Установите PHP версии 5.6.xx');
    }


    $checks = array_merge(
        $checks, array(
            array(PHP_SAPI, true, '<b>PHP_SAPI</b> is ' . PHP_SAPI),
            array(PHP_OS, true, '<b>PHP_OS</b> is ' . PHP_OS),
            array(count($ini) > 0, false, '<b>Loaded PHP configuration</b>: ' . implode(', ', $ini)),
            array(isset($_SERVER['SERVER_SOFTWARE']), false, '<b>SERVER_SOFTWARE</b> is ' . (isset($_SERVER['HTTP_REVERSE_VIA']) ? $_SERVER['HTTP_REVERSE_VIA'] . ' => ' : '') . $_SERVER['SERVER_SOFTWARE']),
            array(session_module_name() != 'files', false, 'session.save_handler = ' . session_module_name() .'; session.save_path = ' . session_save_path(), 'http://redis.io', 'Хранилище сессионных данных', 'Сессионные данные по умолчанию хранятся в файлах на жёстком диске веб-сервера, чтобы уменьшить интенсивность дискового ввода-вывода рекомендуем установить на сервер in-memory хранилище, такое как Redis или Memcached, а так же установить и настроить соответствующее php-расширение для работы с выбранным хранилищем.'),
        )
    );
    if (!is_private_server()) {
        $real_ip = client_real_ip();
        $checks = array_merge(
            $checks, array(
                array(isset($_SERVER['REMOTE_ADDR']), false, '<b>REMOTE_ADDR</b> is ' . $_SERVER['REMOTE_ADDR']),
                array($real_ip != 'unknown', false, '<b>CLIENT REAL IP ' . ($real_ip != 'unknown' ? '(' . $_SERVER[$real_ip] . ')' : '') . ' </b> in ' . $real_ip),
            )
        );
    }

    if (extension_loaded('pdo_dblib') && !extension_loaded('mssql') && !extension_loaded('sqlsrv')) {
        $checks[] = array(false, false, 'MSSQL Extension: ' . database_extension(), ('WINNT' == PHP_OS) ? 'http://php.net/sqlsrv.installation' : 'http://php.net/mssql.installation', 'Расширение php для работы с базой данных','Работа с расширением pdo_dblib возможна в ЭКСПЕРИМЕНТАЛЬНОМ окружении, НЕ РЕКОМЕНДУЕТСЯ к использованию в рабочей среде.');
    } else {
        $checks[] = array(extension_loaded('mssql') || extension_loaded('sqlsrv'), true, 'MSSQL Extension: ' . database_extension(), ('WINNT' == PHP_OS) ? 'http://php.net/sqlsrv.installation' : 'http://php.net/mssql.installation', 'Расширение php для работы с базой данных','Установите расширение php для работы с SQLServer.');
    }

    $checks = array_merge(
        $checks, array(
            array(extension_loaded('ctype'), true, 'Ctype Extension', 'http://php.net/ctype.installation', 'Расширение для работы со строками, включено в стандартную поставку PHP по умолчанию', 'Установите расширение ctype.'),
            array(extension_loaded('simplexml'), true, 'SimpleXML Extension', 'http://php.net/simplexml.installation', 'Расширение для работы с xml, включено в стандартную поставку PHP по умолчанию', 'Установите расширение simplexml.'),
            array(extension_loaded('dom'), true, 'DOM Extension', 'http://php.net/dom.installation', 'Расширение для работы с DOM, включено в стандартную поставку PHP по умолчанию', 'Установите расширение dom.'),
            array(extension_loaded('filter'), true, 'Filter Extension', 'http://php.net/filter.installation', 'Расширение для работы со строками, включено в стандартную поставку PHP по умолчанию', 'Установите расширение filter.'),
            array(extension_loaded('iconv'), true, 'iconv extension', 'http://php.net/iconv.installation', 'Расширение для работы со строками, включено в стандартную поставку PHP по умолчанию', 'Установите расширение iconv.'),
            array(extension_loaded('mbstring'), true, 'mbstring extension', 'http://php.net/mbstring.installation', 'Расширение для работы со строками', 'Установите расширение mbstring.'),
            array(extension_loaded('json'), true, 'json extension', 'http://php.net/json.installation', 'Расширение для работы с JSON, включено в стандартную поставку PHP по умолчанию', 'Установите расширение json.'),
            array(extension_loaded('zlib'), true, 'Zlib', 'http://php.net/zlib.installation', 'Расширение для работы с архивами', 'Установите расширение zlib.'),
            array(extension_loaded('bcmath'), true, 'bcmath', 'http://ru.php.net/manual/en/bc.installation.php', 'Расширение для работы со большими числами (криптография)', 'Установите расширение bcmath.'),
            array(extension_loaded('gd'), true, 'GD', 'http://php.net/image.installation', 'Расширение для работы с изображениями', 'Установите расширение gd'),
            array(function_exists('imagecreatefromjpeg'), true, 'GD with JPEG enabled', 'http://php.net/image.installation', 'Поддержка раширением gd формата JPEG', 'При компиляции php укажите --with-jpeg-dir=Путь-к-libjpeg.'),
            array(function_exists('imagecreatefrompng'), true, 'GD with PNG enabled', 'http://php.net/image.installation', 'Поддержка раширением gd формата PNG', 'При компиляции php укажите --with-png-dir=Путь-к-libpng --with-zlib-dir=Путь-к-zlib.'),
            array(setlocale(LC_CTYPE, 'ru_RU.cp1251', 'ru_RU.CP1251', 'rus_RUS', 'ru_RU', 'rus_RUS.CP1251', 'Russian_Russia.1251') && (strtoupper('Широкая электрификация южных губерний даст мощный толчок подъёму сельского хозяйства.') == 'ШИРОКАЯ ЭЛЕКТРИФИКАЦИЯ ЮЖНЫХ ГУБЕРНИЙ ДАСТ МОЩНЫЙ ТОЛЧОК ПОДЪЁМУ СЕЛЬСКОГО ХОЗЯЙСТВА.'), true, 'ru_RU.cp1251 locale', 'http://google.ru/search?q=ru_RU.cp1251', 'Системная локаль для работы со строками в кодировке windows-1251', 'Необходимо установить системную локаль ru_RU.cp1251.'),
            array(extension_loaded('soap'), true, 'SOAP', 'http://php.net/soap.installation', 'Расширение для создания серверов и клиентов SOAP', 'Установите расширение soap.'),
            array(check_soap_fault(), true, 'the SOAP HTTP server MUST issue an HTTP 500 "Internal Server Error" response and include a SOAP message containing a SOAP Fault element.', 'http://www.w3.org/TR/2000/NOTE-SOAP-20000508/#_Toc478383529', 'SOAP-сервер сообщает об ошибках в http-ответе cо статусом 500, некорректно настроенный веб-сервер перехватывает такие ответы для того чтобы показать пользователю собственную страницу с описанием ошибки', 'Убедитесь в том, что веб-сервер не перехватывает вывод php/fastcgi.'),
            array(extension_loaded('xml'), true, 'xml', 'http://php.net/xml.installation', 'Расширение для работы с xml, включено в стандартную поставку php', 'Установите расширение xml.'),
            array(extension_loaded('mcrypt'), true, 'mcrypt', 'http://php.net/mcrypt.installation', 'Расширение для работы с криптографией', 'Установите расширение mcrypt.'),
            array(extension_loaded('openssl'), true, 'openssl', 'http://php.net/openssl.installation', 'Расширение для работы с криптографией', 'Установите расширение openssl.'),
            array(extension_loaded('curl'), module_installed('alfabank'), 'curl', 'http://php.net/curl.installation', 'Расширение для отправки http-запросов', 'Установите расширение curl.'),
            array(strlen(@file_get_contents('http://st.samo.travel/public/pict/1x1.gif')) > 0, false, 'access to http://samo.travel', 'http://samo.travel', 'Доступ к сервису samo.travel', 'Проверьте есть ли доступ с веб-сервера к внешним ресурсам.'),
            array(extension_loaded('apc') || extension_loaded('apcu'), true, 'User space caching: ' . caching_extension(), 'http://en.wikipedia.org/wiki/List_of_PHP_accelerators', 'Расширение для кеширования данных в памяти веб-сервера', 'Установите расширение APCu.'),
            array((extension_loaded('apc') && !extension_loaded('apcu')) || extension_loaded('Zend OPcache'), true, 'Opcode caching: ' . opcode_extension(), 'http://en.wikipedia.org/wiki/List_of_PHP_accelerators', '"Ускоритель" php-кода', 'Установите одно из поддерживаемых расширений: opcache, apc.'),
        )
    );

    if (version_compare(phpversion(), '5.5.0') >= 0) {
        $checks[] = array(ini_get('always_populate_raw_post_data') == -1, true, 'php.ini: always_populate_raw_post_data MUST BE -1', 'https://bugs.php.net/bug.php?id=70334', 'Для корректной работы веб-сервисов (SOAP) директива <code>always_populate_raw_post_data</code> должна быть установлена в <code>-1</code> (минус единица)', 'Установите <code>always_populate_raw_post_data</code> в -1 в php.ini.');
    }

    if (function_exists('apache_get_modules')) {
        $checks[] = array(in_array('mod_rewrite', apache_get_modules()), false, 'mod_rewrite');
        $checks[] = array(in_array('mod_expires', apache_get_modules()), false, 'mod_expires');
    }

    if (extension_loaded('apc') && !extension_loaded('apcu')) {
        $checks[] = array((bool)ini_get('apc.include_once_override') === false, true, 'php.ini: apc.include_once_override MUST BE Off', 'http://php.net/manual/apc.configuration.php#ini.apc.include-once-override');
    }
    if (extension_loaded('apc') || extension_loaded('apcu')) {
        function readable_size($bytes) {
            $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
            $factor = floor((strlen($bytes) - 1) / 3);
            return sprintf("%.0f", $bytes / pow(1024, $factor)) . @$size[$factor];
        }
        $minimal = 133169152; // 127 Mb
        $mem = extension_loaded('apcu') ? apcu_sma_info() : apc_sma_info();
        $memsize = $mem['avail_mem'];
        $checks[] = array($memsize >= $minimal, false, 'apc.shm_size: ' . readable_size($memsize) . ($memsize < $minimal ? ' (current), increase up to ' . readable_size($minimal) : ''), 'http://php.net/manual/apc.configuration.php#ini.apc.shm-size', 'Для кеширования данных в оперативной памяти веб-сервера требуется не менее ' . readable_size($minimal), 'Проверьте значение <code>apc.shm_size</code> в php.ini, проверьте доступный размер SHM операционной системы/контейнера (kernel.shmmax)');
    }
    if (extension_loaded('xcache')) {
        $checks[] = array(version_compare(xcache_version(), '3.0.0') >= 0, true, 'xcache version newer than 3.0.0', 'http://xcache.lighttpd.net/wiki/ReleaseArchive');
        $checks[] = array((bool)ini_get('xcache.admin.enable_auth') === false, true, 'php.ini: xcache.admin.enable_auth MUST BE Off', 'http://xcache.lighttpd.net/browser/trunk/mod_cacher/xc_cacher.c#L2951');
    }
    ini_set('default_charset', 'windows-1251');
    echo '
        <style>
            body {
                margin: 0;
                font-family: "Lucida Sans Unicode", Arial, sans-serif;
            }
            h2 {
                margin: 15px;
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }
            table th {
                border: 1px solid #ccc;
                padding: 7px;
                color: #333;
            }
            table td {
                border: 1px solid #ccc;
                padding: 7px;
                color: #333;
            }
            table tr {
                transition-duration: 0.3s;
            }
            table tr:hover {
                background-color: rgba(150, 150, 150, 0.2);
            }
            .fail {
                background-color: rgba(255, 0, 0, 0.4);            
            }
            .warning {
                background-color: rgba(255, 165, 0, 0.4);
            }
            .icon {
                background-repeat: no-repeat;
                background-position: center center;
                background-color: white;
            }
            .ok .icon {
                background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAADOUlEQVRYR+WWTUgUYRyHn9liPHQqKEoD10MR2hdkaEVRaWVGRTcPXSKo0CSxMvuwQ9r6EYkEidLBSwdvUVFpGom6utIWZip+ELuSfZe3Dhvqxvvurs7Mzm67tlLQnHZm33mf5/973//MKPzlQ/nLfP4LAXVvJR6R9NMLxAE/tanPdwLqThuee4W3JfNIdR5tl/QS8ymg7rLhaSyo5n5roRQ4nFlNTk0hzzUS8yUg4XcLynjcegWvn6J4ITuzjKM1V2Yk5kNAwhvOXKal7bqsXLH4Vt3rBYsXsjJKOH6rlKYi4mItIOF38s/S1nlTVq5oCOL3QgXcE+B4B0/OsSSWAupuG57a/Fw6u2qD4BYBt4BrArpc0HyedGDEXMCLgoI3ioeUhN86fYzungZz+AIY+w72txK+A3ABX8wE1H3+vm026VsTKQm/mZuD81Wj72/NrLJyAf8G9lFoLpqFi2eCUUDNsOGpyDso5ym+/ZBnhr41CEh4ee4h+nofhIZ/BftIMNzgioSXntrDYH+LnCx57R5K6lpCScyOH2iRO9y08i9gHzaHawXUTBuekpPbGR3q8E0m5lNg1ZrtXKvvMEpI+FXteLPYP4N9KDQ8IKDur8JTfCKVt8NOpqb1IYsWtq5OpbzeSatvORCyF0+m4h5xYhiOXPOFMPYJ7IPh4QGBxdk3mEhLButymJyCacP+F5PGJ6VQVTcg7YpOpfDBNRA8zuLbcK6P4OiHpgv6DWfWVSK4xcDqrEoc6evAugImJ4MlxMClK5PkHF/HXUE9GqjcLeBvIoPPLAGwDEjKqqQ9fT1Y4/1JGPMNJGPoHYu/cvcHcPRFDtdtQq3Elg2QmBBCwpBjAD72HrpfRwcPakOdxEZIXBleYgY+Dt290cONAuJc1UlsCp2ErvKXc4ObCQRLpAYnoavcOXd4KAG9RAXtaZvBmujrDnGIPnePQc8LaCr+fauZtV/gWrjX8exyVNCengZWq+82txscPX8OD5dAQFAnsXWb73KXPTbwSAR0y3HgBu3iwiPN+9z4mR0u7lBPwkjuCSSR4B/8XnxM/Ck80gS0y7HIf/IjFvBoBSJJKuoxsfwojRr+TyTwC85JXV6wz8DQAAAAAElFTkSuQmCC");
            }            
            .fail .icon {
                background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAADz0lEQVRYR6WXbWxLURjH/yvbmk5r68YMIdO7sqmtGZFNxiqIsJARgg8LIpOQEPEWFiKyeYm3CMkkFkH2ASEsZBMZUVuDCNLNbGt7ZyHe2dDZ7IWSe9rb9K733nNvnY/3Ps///7vnnHue50RBfMQ4bNY+7lWe3RkLoF8ijvaYqhMlokCSMsuOk1eNe7ZFCqFIZzCAP2nfIfw4uJUADC85gcb9u9VCKNYJAhzNNI3MNeo/WUr2o+voLsHE6HccRtPBfUohiLlSHQJwwJKanJ80/KNl5178PLlXdF2HbSlF05FSGoTfXIUOB0CSJm/dhZ7yMtlNpdu4By9PHJaCiEiHA0hw2KydGZu2offcMdquhnbddjSfPj4YgphHoGEkAADMDpv1ccaGzeirPE2FiC3ahOYzp3gIEHP1uTkA3GQJAIwEkOqwWevSizdi4MpZKkT0ivVoqSgncWpz8uzOWQDaAXzm/wIBxKQ1xfhTdZEK4e33kRhDjIYaO6RwNVovVHCzFjTnDrjQc0AIUbQWvurLVGElAZqClWitPB9mzuWGHUShyzFxVRFQe12Jh3TMvKVwXaoUNRcD4J4JZmLi8pXQPKiJCMKXvxCuq5clzaUAwiDMS5Zh6KO7qiB+586F+8Y1WXM5gHCIxYWIflqnCGJg2iy4b1ZRzWkAPMRYh83aZi5YhJiGx4oA+rNy4K6+xQGYALyVK+di5TjUhJxwafMXQNvyXJE5H9Sbng3Pndu02hH2F4SZm+fMg7btpSrzIIRpMtz3amUhpGbA/+W22dC98URkzif1jEuDx35fEiIMgO8L0mbORNyH1/9lzid3p4yHp75eFEIAwPcFTO4M6Ds+UM07vV0kxmjQU2O7ElPAPnoYBhEECJpPnw6Dt4Mq6DUkgn3yhMQxKnNCG11BR8RMnYr4Xv9XyY3vWj3YZ8+w7qlruevnr26HzVqjNpeHCHZEjNWKhD+9NG9808SCbWhA8XN3QYu3xwXgL4AxXClnsrKQ4CPdvOz4NkQL1ukkyxHsiJgpFhg1nJb06PRFgX3RxJs3AfgUAAj2E2p08uxOYUfEZExCYmy0KEFH3wDY5tbB5vznCgqYEp08u1O8I2LMaUjS6wQQX7t6wLo9UuZ8rBBCRofaETGmCRhhjCfCXzq/g217RTMXhxDRUdwRMaZUIsq2tSs1F0CkG3SZFdnm6lCdweZcgmxHxAUEdju/4ehb3I/BLceodIPOwkGE6DRyjWhodRS9nAbasjEBwPeB3a7UnJ8J7ladDGB04MG7gI7gpi1ZjADEBRK7/+d6TtP5B5SMKZunUEbDAAAAAElFTkSuQmCC");
            }
            .warning .icon {
                background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAFJUlEQVRYR+2WfUzUdRzHX7/fHXeCgsrx6BOiCAJCefIg8tDIykwNzHQzwwdmudZcubk5jXQq6WyVLtaUcjhlVqu5tHRm5dwE5NFDQEQINfEBBIEhAnnc3a/97sHRxXFHW7m2vv/d/b7f3+f1fX/en8/vI/CEl/CE4/OfBRDPbY5b46GSDsoK9uqFtam7yw4BpuEq+rcUWD8/wHdlUkhrTGamOV5FXh5HChv9ck63tP0bAG4FWbFnpybOSQ70u2+O19zqw7WiCwXJ2eVzgf7hQAxXAeHQ2uik6DDf89rXl0LRTswuituI7uuTVNe3paw5WF0ISK5CDBdAXbw1risifYHaq7cU7uosccZpeeARz5Xjpx4l7CgbDTz6JwDEHzbO2jQ1ZMKu8BdnQkUuiCpLHJMeYtZR92Ml1xpvb1n00cU9rhpyOAp4XMiK7Zm9bgXC1XzobQdRYQUwgocGaXoGJblHmZNdPlIuDldUcBVAcW5LzLGwJG1a4FQ3aDgNSiW4WVNtEMBggGnzab7WT32h7kTqroolgNEZhCsAQv5b0UmRwZrzM1+bB5ePgCSBSiLx4xREAQ4uqyLMvwsEESJXUvnlGWpvtKdk7HduSFcA1EVZsTfC5yUEjvVsgZbLoFDACCMv7UtGIULOK9VM9usGgwn8Z9DZHUDdmeLmxOzyYGeGdAYgnto4a1NwiP+u8IUzoe4EiErM11YbSPs0BYUo8cniKib79lgENxkgPI26k5XcaLy3ZYETQzoD8CjOiuvRrpiL6kEF9LRbZBYxA7ya84wZ4MPFVQT5PASjAJIJRmrQe8WgO3qWhOyyIQ05FIDi500xn4fGhmRO0mrgVgkISsydR5RA3c/yz1IRBYnd6ZeYZAaQySSQDDBxNk26dhrKG/Oe31PxpiNDOgIQ9mZMm54Y6ncldlUSNJeCXm+5vbysABn7U1EIEjvTLjFRYwOQGUygUkFgPOWHCylqaI3YkP/r1cE6pCMAVcF7sbrIF6Iix/o/go6b1uDW7VaA1QeeNadg+6JKJgwEMKtgAu8gOu+pqf2ppjb5g3ItoLcvy8EAxOPvzsoMDfX5Ijw9Eu5cspTdwNHBCrD2wHOIosTWhReZ8DgFthASCAKMf5q647U0NNx/I33fxTz7DjkYgHtxVnyvdrkWFS3Q90DW/M/ggtwHDGTmzjN74P1FFQT5dIHJbp88Hrh7oScA3Vc6ErJLPYC+gS+zBzAbb0pUQOaUlHHQfsMa3G6b/FNhpKl1jOWSY3oQFUYw2b9OVs4EmmCun7/L9ZqWvxhy4Alhb8aM6Ymho6/EroqC7juWxuJoalPKKpgsj/vlViw6mIckUIrgOZ7ywzUUNXRFbMi//NiQAwFUBVlxurCkiZG+oe7QK0vvwKPy32oTKW/7m1OQ+04nYZMNlj4w6JLAw4u2hj7qC2/VJmeXPTak7YTw7fqnFodNGXssalkIPOwYerqTU60ysWxbhKUPrL5J8Pi+IQCsmRzlTc03jdRf71yyNKfqO7ksbQAjSrYldEe/PEnprlFAvwtTlVKi6a6nxQPefYhKo/M5yM2NvnYj1d83GWZvL/YEfrcBeJduS2iPWx8KehOY7MpuMFnlSrCZ3uo1hykzn5f3C6ASKctpIH57sQbosAH4/rI57twolSJSkoO7PNE5+9rbPRfkfiagl6TbKTtKZB+02QC8gCBAprKOOcN8uevb5dLqAH4DumwA8ldGbhJqx9Z3PYKTnbK+ckuWRza5gJ/s+h/gD1M9zzASYFmcAAAAAElFTkSuQmCC");
            }
            th.status {
                width: 3%;
            }
            th.name {
                width: 30%;
            }
        </style>

        <h2>Системные требования</h2>
        <table>
            <tr>
                <th class="name">Компонент</th>
                <th>Решение проблемы</th>
                <th>Описание компонента</th>
                <th class="status">Статус</th>                
            </tr>';

    function test($result, $required, $title, $link = false, $desc = false, $help = false) {
        $status = (!$result && $required) ? 'fail' : ((!$result && !$required) ? 'warning' : 'ok');
        echo '<tr class="' . $status . '">';
        if ($status == 'fail') {
            echo '<td>' . $title . '</td>
                  <td>' . $help . (($link) ? ' Перейдите по <a href="' . $link . '" target="_blank">ссылке</a>' : '') . '</td>
                  <td>' . $desc . '</td>
                  <td class="icon">&nbsp;</td>
            ';
            return false;
        } elseif ($status == 'warning') {
            echo '<td>' . $title . '</td>
                  <td>' . $help . ($link ? ' Перейдите по <a href="' . $link . '">ссылке</a>' : '') . '</td>
                  <td>' . $desc . '</td>
                  <td class="icon">&nbsp;</td>
            ';
        } else {
            echo '<td>' . $title . '</td>
                  <td>&mdash;</td>
                  <td>' . $desc . '</td>
                  <td class="icon">&nbsp;</td>
            ';
        }
        echo '</tr>';
        return true;
    }

    $requirements = true;
    foreach ($checks as $check) {
        if (false == call_user_func_array('test', $check) && $requirements == true) {
            $requirements = false;
        }
    }
    test($requirements, true, 'Total result');
} else {
    switch ($_GET['check']) {
        case 'soap_fault':
            header('HTTP/1.1 500 SOAP Fault');
            header('Content-Type: text/xml; charset=UTF-8');
            echo soap_fault_xml();
            break;
        case 'remote_addr':
            if (!function_exists('json_encode')) {
                function json_encode($a = false) {
                    if (null === $a) {
                        return 'null';
                    }
                    if ($a === false) {
                        return 'false';
                    }
                    if ($a === true) {
                        return 'true';
                    }
                    if (is_scalar($a)) {
                        if (is_float($a)) {
                            // Always use "." for floats.
                            return floatval(str_replace(",", ".", strval($a)));
                        }

                        if (is_string($a)) {
                            $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
                            return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
                        } else {
                            return $a;
                        }
                    }
                    $isList = true;
                    $cnt = count($a);
                    for ($i = 0, reset($a); $i < $cnt; $i++, next($a)) {
                        if (key($a) !== $i) {
                            $isList = false;
                            break;
                        }
                    }
                    $result = array();
                    if ($isList) {
                        foreach ($a as $v) {
                            $result[] = json_encode($v);
                        }
                        return '[' . join(',', $result) . ']';
                    } else {
                        foreach ($a as $k => $v) {
                            $result[] = json_encode($k) . ':' . json_encode($v);
                        }
                        return '{' . join(',', $result) . '}';
                    }
                }
            }
            echo json_encode($_SERVER);
            break;
        default:
            header('HTTP/1.0 404 Not Found', true, 404);
            break;
    }
}
