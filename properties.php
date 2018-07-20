<?php

    /* Database settings */

    define('SMARTY_TEMPLATE_CHECK', true);

    define('hostname', '127.0.0.1,1433');
    define('username', 'samorepl');
    define('password', 'gv7y3O4zvj');
    define('OFFICE_SQLSERVER', '');
    define('OFFICEDB', 'EUROTOUR');
    define('BANKDB', 'INVOICESFORBANK');

    if (!get_cfg_var('date.timezone')) {
        date_default_timezone_set("Europe/Moscow");
    }

    ini_set('mssql.datetimeconvert', 0);
    ini_set('mssql.charset', 'cp1251');
    ini_set('mssql.textsize', 2147483647);
    putenv('TDSVER=8.0');

    /* Application settings */

//    define('STATEFROM', 2); // рынок (страна "отправления") для поиска наземного обслуживания  НЕ ИСПОЛЬЗОВАТЬ!!!
    define('TOWNFROMINC', 2);
    define('CURRENCYINC',1); // валюта по-умолчанию
    define('CL_REFER_REC_ON_PAGE', 10);
    define('CL_REFER_LINKS_ON_PAGE', 20);
    define('PROC_TESTPEOPLE_INTERNEL', '');  // процедура вызывается после обновления информации туриста
    define('FIO_DELIMETER', ' ');
    define('INTERNET_USER', 2); // код пользователя САМО-Тура, от имени которого работает онлайн select * from [online_tour_config] where [what] = 'INTERNET_USER'
    define('DEFAULT_DATE_FORMAT', '%d.%m.%Y');
    define('LANGS', 'rus'); //можно несколько языков rus,eng,... , по умолчанию выбирается первый
    define('COOKIE_DOMAIN', null); // домен на который устанавливаются cookie (точка в начале включает ВСЕ поддомены)
    define('ASSETS_HOST', isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null); // домен на котором доступна директория public
    define('COOKIE_EXPIRE', strtotime('+1 month'));
    define('SESSION_NAME', 'SAMO');
    define('SECURITY_CHECK_REFERER', true); // проверять ли http_referer на совпадение с http_host?, отключить там, где модули грузятся в iframe
    //define('EDOC_CHECK_TYPE', 0); // 0 - no check; 1 - check status (проверяет наличие записи в таблице monitor); 2 - check schedule
    //define('SEARCH_TOURTYPE_FILTER', 0); // удалить, если закомментарено или установлено значение 0
    //define('SEARCH_PROGRAMTYPE_FILTER', 0); // удалить, если закомментарено или установлено значение 0
    //define('SEARCH_INCOMINGPARTNER_FILTER', 0); // удалить, если закомментарено или установлено значение 0
    define('SEARCH_PAYMENTSCHEDULE',1);
    //define('ATTRIBUTE_LTAGS_HOTELTYPE', 'Hotel type');
    //define('MAP_KEY', 'AIzaSyDZBKPoj8jN9Rme6HwiVrsrmMFKqJfQtSI');
    define('PRICE_CACHE_REDIS', false);
    define('REGISTER_BY_INN', false); // Включить поле INN первичным при регистрации агентства (только для РФ)

    /* Paths */
    /* Все пути настоятельно!! рекомендуется раскрывать полностью (от корня), без лишних строковых операций. */

    $_normalize = function($path) {
        return rtrim(str_replace(array(DIRECTORY_SEPARATOR, '//'), '/', $path), '/');
    };

    define('_ROOT', $_normalize(__DIR__) . '/'); // путь к инсталяции в файловой системе
    define('WWWROOT', $_normalize(str_replace($_normalize($_SERVER['DOCUMENT_ROOT']), '/' , _ROOT)) . '/');  // URL инсталяции

    $tmp = $_normalize(dirname(__DIR__)) . '/tmp/'; // искать tmp за пределами document_root
    define('_TMP', (file_exists($tmp)) ? $tmp : _ROOT . 'tmp/'); // иначе использовать то, что осталось
    unset($tmp);

    define('TOWNSFROM_CACHE', _TMP . 'servers_cache.php');
    define('INCLUDE_PATH_CACHE', _TMP . 'classmap_cache.php');
    define('ROUTES_PATH', _ROOT . 'routes.php');
    define('SMARTY_COMPILE_DIR', _TMP . 'templates_c/'); // так можно указать точный путь к компилируемым шаблонам
    define('INTERNAL_CACHE_DIR', _TMP . 'cache.dir'); // файловый кеш должен находится в c:/srv/tmp, иначе шедулером не будет удалятся мусор
    define('INTERNAL_CACHE_DRIVER', 'auto');
    define('FPDF_FONTPATH', _ROOT . 'vendor/pdffont/'); // путь к русским шрифтам для генерации PDF-документов

    /* System settings */
    define('DEBUG',isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '212.34.54.82');
    define('APPMODE', (DEBUG) ? 'test' : 'production');

    define('SMARTY_RESOURCE_CHAR_SET', 'cp1251');

    define('LOG_TYPE', 'samo_firebug');
    define('TOOLSPROTECT', 'wpR4UM4l9D'); // Не забываем генерировать!!!
    //define('FRIENDLY_URLS', 1);

    define('SAMOGUID', '00000000-0000-0000-0000-000000000000');
    /*
    # в некоторых случаях веб-сервер стоит за прокси-сервером, и адрес пользователя передаётся в другой переменной
    $_SERVER["REMOTE_ADDR"] = ($_SERVER["REMOTE_ADDR"] == '127.0.0.1' && isset($_SERVER['HTTP_REMOTE_ADDR'])) ? $_SERVER['HTTP_REMOTE_ADDR'] : $_SERVER["REMOTE_ADDR"];

    # в случае, когда сервер имеет несколько альясов не являющимися субдоменами одного домена необходимо пользователя перенаправить на один домен (иначе возможно потеря идентификатора сессии)
    if ($_SERVER['HTTP_HOST'] != 'maindomain.tld' && $_SERVER['REQUEST_METHOD'] == 'GET') {
        header('Location: http://maindomain.tld'.$_SERVER['REQUEST_URI'],true,301);
        exit;
    }
    //*/

    function PSBANK_Users() {
        //пользователи web-сервиса
        return array(
            'samo' => 'samo',
        );
    }
    define('PSBANK_DEFAULT_OPERATION',2); //номер операционной кассы для simple_client.php

    // параметры доступа в Platron
    // ВНИМАНИЕ!!! В админке Platron'а надо настроить у магазина:
    // - [check_url]  = http://[operator.online]/modules/wspay_4/platron_client.php?check
    // - [capture_url]  = http://[operator.online]/modules/wspay_4/platron_client.php?capture
    // - [result_url] = http://[operator.online]/modules/wspay_4/platron_client.php
    // - [request_method] = POST
    define('PLATRON_MERCHANT_ID', ''); // merchant_id у магазина
    define('PLATRON_SECRET_KEY',  '');    // secret_key у магазина
    define('PLATRON_SAMO_INC', 0); // inc для платрона в INVOICESFORBANK.dbo.Bank
    define('PLATRON_SAMO_LOGIN', 'PLATRON'); // логин для платрона в INVOICESFORBANK.dbo.Bank
    define('PLATRON_PAY_URL',       'https://www.platron.ru/payment.php');        // URL страницы оплаты, куда слать пользователя
    define('PLATRON_STATUS_URL',    'https://www.platron.ru/get_status.php');
    define('PLATRON_CURRENCY',    'RUB');
    define('PLATRON_AVIA_TICKET', '0'); // Передавать транзакцию как авиабилет

    // параметры доступа в Platron для частных лиц
    // ВНИМАНИЕ!!! В админке Platron'а надо настроить у магазина:
    //[check_url]  = http://[operator.online]/modules/wspay_4/platron_client.php?b2c=1&check
    //[capture_url]  = http://[operator.online]/modules/wspay_4/platron_client.php?b2c=1&capture
    //[result_url] = http://[operator.online]/modules/wspay_4/platron_client.php?b2c=1
    //define('PLATRON_MERCHANT_ID_B2C', ''); // merchant_id у магазина
    //define('PLATRON_SECRET_KEY_B2C', '');    // secret_key у магазина



    //define('WSPAY_NULL_PASSPORT', true); //позволяем проводить оплаты с фиктивным номером паспорта используя расширенный метод

    // параметры доступа в Sberbank
    define('SBERBANK_USERNAME',     ''); // логин для доступа к Сбербанку
    define('SBERBANK_PASSWORD',     ''); // пароль для доступа к Сбербанку
    define('SBERBANK_SAMO_INC',     0);  // inc для Сбербанка в INVOICESFORBANK.dbo.Bank
    define('SBERBANK_SAMO_LOGIN',   ''); // логин для Сбербанка в INVOICESFORBANK.dbo.Bank
    define('SBERBANK_URL',          ''); // URL Сбербанка для отправки запросов, например "https://3dsec.sberbank.ru/payment/rest/"
    define('SBERBANK_PRE_AUTH',     0);  // совершать платежи с преавторизацией

    define('SBERBANK_CLIENT_LOGIN', ''); // for sberbank_client.php to pay without get param [login]
    //define('SBERBANK_CLIENT_LOG', _TMP . 'sberbank_client.log');


    // параметры доступа в Казкоммерцбанк
    // ВНИМАНИЕ!! Добавлять в InvNumbers c префиксом 0 (нуль) и min длиной 6 символов
    // это берется у Казкоммерцбанка
    define('KKB_KZ_MERCHANT_ID',        '');               // Терминал ИД в банковской Системе (пример: 12345678)
    define('KKB_KZ_MERCHANT_NAME',      '');               // Название магазина (продавца) Shop/merchant Name (пример: Test shop)
    define('KKB_KZ_MERCHANT_CERT_ID',   '');               // Серийный номер сертификата Cert Serial Number (пример: 00C182B189)
    define('KKB_KZ_PRV_PASSWORD',   '');                   // Пароль к закрытому ключу Private cert password (если его нет, то просто закомментить эту строку) (пример: 12345)
    define('KKB_KZ_PAY_URL',        '');                   // Куда посылать пост (боевой: https://epay.kkb.kz/jsp/process/logon.jsp)
    // это делаем мы
    define('KKB_KZ_PRV_FILENAME',  '');                     // Путь к закрытому ключу Private cert path (пример: _ROOT . 'data/kkb_kz/prv.pem')
    define('KKB_KZ_PUB_FILENAME',  '');                     // Путь к открытому ключу Public cert path (пример: _ROOT . 'data/kkb_kz/pub.pem')
    define('KKB_KZ_SAMO_INC',      '');                     // inc для kkb_kz в INVOICESFORBANK.dbo.Bank (пример: 16512)
    define('KKB_KZ_SAMO_LOGIN',    '');                     // Логин в системе САМО (пример: KKB_KZ)


    // Параметры доступа в Uniteller
    // Не забываем указать в настройках магазина "URL для уведомление сервера интернет-магазина об изменившемся статусе счёта/оплаты": http://[operator.online]/modules/wspay_4/uniteller_client.php
    define('UNITELLER_SHOP_ID',  '');   // ID магазина (Раздел "Точки продажи" личного кабинета => параметр Uniteller Point ID)
    define('UNITELLER_PASSWORD', '');   // Пароль из "параметры авторизации"
    define('UNITELLER_PAY_URL',  '');   // URL оплаты (например: https://wpay.uniteller.ru/pay/)
    define('UNITELLER_SAMO_INC', 0);    // inc для Uniteller в INVOICESFORBANK.dbo.Bank
    define('UNITELLER_SAMO_LOGIN', ''); // логин для Uniteller в INVOICESFORBANK.dbo.Bank

    // Параметры Кредит Европа Банк
    define('CREDIT_EUROPE_BANK_CLIENT_ID', '');                                                  // Идентификатор продавца
    define('CREDIT_EUROPE_BANK_STOREKEY', '');                                                   // Ключ безопасности
    define('CREDIT_EUROPE_BANK_API_LOGIN', '');                                                  // Пользователь
    define('CREDIT_EUROPE_BANK_API_PASSWORD', '');                                               // Пароль
    define('CREDIT_EUROPE_BANK_API_STATUS_URL', 'https://paysafe.crediteurope.ru/fim/api');      // URL API для получения статуса платежа
    define('CREDIT_EUROPE_BANK_PAY_URL', 'https://paysafe.crediteurope.ru/fim/est3Dgate');       // URL страницы оплаты
    define('CREDIT_EUROPE_BANK_SAMO_INC', 0);                                                    // Inc из INVOICESFORBANK.dbo.Bank
    define('CREDIT_EUROPE_BANK_SAMO_LOGIN', '');                                                 // Alias из INVOICESFORBANK.dbo.Bank
    define('CREDIT_EUROPE_BANK_LOG', '');                                                        // Путь к файлу лога (например, _TMP.'credit_europe_bank.log'), если пусто, то лог не будет писаться




    // Параметры Альфа-Банка
    define('ALFABANK_SAMO_INC', 0);                             // Inc из INVOICESFORBANK.dbo.Bank
    define('ALFABANK_SAMO_LOGIN', 'ALFABANK');                  // Alias из INVOICESFORBANK.dbo.Bank
    define('ALFABANK_API_LOGIN', '');                           // API-логин
    define('ALFABANK_API_CURRENCY', 810);                       // API-валюта 810 - RUB, ISO 4217
    define('ALFABANK_API_PASSWORD', '');                        // API-пароль
    define('ALFABANK_API_MERCHANT_LOGIN', '');                  // API-логин мерчанта (может быть пустым)
    define('ALFABANK_API_MERCHANT_LOGIN_B2C', '');              // API-логин мерчанта, который будет юзаться в cl_refer_person (может быть пустым)


    // Параметры Альфа-Банка для терминалов
    define('ALFABANK_T_SAMO_ALIAS', 'alfabank_t');              // Alias из INVOICESFORBANK.dbo.Bank



    // Параметры для PayLate
    define('PAYLATE_SAMO_INC',      0);                                     // Inc из INVOICESFORBANK.dbo.Bank
    define('PAYLATE_SAMO_ALIAS',    'PAYLATE');                             // Alias из INVOICESFORBANK.dbo.Bank
    define('PAYLATE_CLIENT_ID',     '1702082013');                          // ID клиента
    define('PAYLATE_LOGIN',         'test');                                // Логин
    define('PAYLATE_PASSWORD',      'test');                                // Пароль
    define('PAYLATE_PAY_URL',       'https://paylate.ru:21443/bypartner');  // URL, куда отправлять данные с формы
    define('PAYLATE_MAX_AMOUNT',    150000);                                // Максимальная сумма платежа


    // Параметры для PayBox
    define('PAYBOX_SAMO_INC',      1);                                         // Inc из INVOICESFORBANK.dbo.Bank
    define('PAYBOX_SAMO_ALIAS',    'PAYBOX');                                  // Alias из INVOICESFORBANK.dbo.Bank
    define('PAYBOX_MERCHANT_ID',   '123');                                     // Мерчант ИД
    define('PAYBOX_SECRET_KEY',    'secret');                                  // Secret key
    define('PAYBOX_PAY_URL',       'https://www.paybox.kz/payment.php');       // URL страницы оплаты, куда слать пользователя
    define('PAYBOX_STATUS_URL',    'https://www.platron.ru/get_status.php');   // URL страницы оплаты, куда слать пользователя
    define('PAYBOX_CURRENCY',      'KZT');                                     // Валюта


    // Параметры для LiqPay (https://www.liqpay.com/ru/doc/checkout)
    define('LIQPAY_SAMO_INC',      0);                                          // Inc из INVOICESFORBANK.dbo.Bank
    define('LIQPAY_SAMO_ALIAS',    'LIQPAY');                                   // Alias из INVOICESFORBANK.dbo.Bank
    define('LIQPAY_CURRENCY',      'UAH');                                      // Валюта платежа.Возможные значения: USD, EUR, RUB, UAH
    define('LIQPAY_PUBLIC_KEY',    '');                                         // Публичный ключ - идентификатор магазина. Получить ключ можно в настройках магазина
    define('LIQPAY_PRIVATE_KEY',   '');                                         // Приватный ключ



    // Параметры для Fondy, ниже забиты тестовые данные
    define('FONDY_SAMO_INC',        90526);       // Inc из INVOICESFORBANK.dbo.Bank
    define('FONDY_SAMO_ALIAS',      'Fondy');     // Alias из INVOICESFORBANK.dbo.Bank
    define('FONDY_MERCHANT_ID',     '1396424');   // MerchantID, берем из ЛК->СПИСОК МЕРЧАНТОВ->НАСТРОЙКИ МЕРЧАНТА->ТЕХНИЧЕСКИЕ "ID мерчанта"
    define('FONDY_PASSWORD',        'test');      // Ключ платежа, берем из ЛК->СПИСОК МЕРЧАНТОВ->НАСТРОЙКИ МЕРЧАНТА->ТЕХНИЧЕСКИЕ "Ключ платежа"
    define('FONDY_CURRENCY',        'RUB');       // Валюта - EUR, USD, GBP, RUB, UAH
    define('FONDY_PREAUTH',         false);       // Использовать преавторизацию
    define('FONDY_PAY_TTL',         0);           // Время жизни платежа в минутах, если платеж находится в промежуточном состоянии, то после этого ttl его статус больше проверяться не будет, если задать значение в 0, то будет проверяться всегда


    // Парамеьтры для Moldova Agroindbank
    define('AGROINDBANK_SAMO_INC',          0);                 // Inc из INVOICESFORBANK.dbo.Bank
    define('AGROINDBANK_SAMO_ALIAS',        'AGROINDBANK');     // Alias из INVOICESFORBANK.dbo.Bank
    define('AGROINDBANK_CURRENCY',          498);               // Валюта (ISO 4217), указан MDL
    define('AGROINDBANK_PASSWORD',          '');                // Пароль к сертификату
    define('AGROINDBANK_MERCHANT_URL',      'https://ecomm.maib.md:4455/ecomm2/MerchantHandler');   // URL мерчанта (куда отправляются запросы)
    define('AGROINDBANK_CLIENT_URL',        'https://ecomm.maib.md/ecomm2/ClientHandler');          // URL клиента (куда перебрасываем пользователя)
    define('AGROINDBANK_CAINFO_FILE',       '');    // Путь к файлу сертификата, например, _ROOT.'data/agroindbank/cacert.pem'
    define('AGROINDBANK_SSLCERT_FILE',      '');    // Путь к файлу сертификата, например, _ROOT.'data/agroindbank/pcert.pem'
    define('AGROINDBANK_SSLKEY_FILE',       '');    // Путь к файлу-ключу сертификата, например, _ROOT.'data/agroindbank/key.pem'


    // Параметры для Промсвязьбанка
    define('PSB_SAMO_INC',      0);                                     // Inc из INVOICESFORBANK.dbo.Bank
    define('PSB_SAMO_ALIAS',    'PSB');                                 // Alias из INVOICESFORBANK.dbo.Bank
    define('PSB_TERMINAL',      '79036768');                            // Терминал
    define('PSB_MERCHANT',      '790367686219999');                     // Мерчант
    define('PSB_MERCHANT_NAME', 'SAMO-SOFT');                           // Название мерчанта, на латинице
    define('PSB_KEY',           'C50E41160302E0F5D6D59F1AA3925C45');    // Ключ
    define('PSB_PRE_AUTH',      false);                                 // Предавторизация
    // Скрипт для обработки POST уведомлений: http://[online]/modules/wspay_4/acquiring_client.php?s=psb



    // Параметры для Payture (http://payture.com/integration/api/)
    define('PAYTURE_HOST',  ''); // Хост, например, тестовый - 'https://sandbox3.payture.com/'
    define('PAYTURE_KEY',   ''); // Идентификатор ТСП. Выдается с параметрами тестового/боевого доступа
    define('PAYTURE_PASSWORD',   ''); // Парол
    // для чека
    define('PAYTURE_INN',               ''); // ИНН организации, для которой пробивается чек
    define('PAYTURE_TAX',               1); // Ставка НДС: 1 – ставка НДС 18%; 2 – ставка НДС 10%; 3 – ставка НДС расч. 18/118; 4 – ставка НДС расч. 10/110; 5 – ставка НДС 0%; 6 – НДС не облагается
    define('PAYTURE_TAXATION_SYSTEM',   0); // Система налогообложения: 0 – Общая, ОСН; 1 – Упрощенная доход, УСН доход; 2 – Упрощенная доход минус расход, УСН доход - расход; 3 – Единый налог на вмененный доход, ЕНВД; 4 – Единый сельскохозяйственный налог, ЕСН; 5 – Патентная система налогообложения, Патент
    define('PAYTURE_PAYMENT_TYPE',      16); // Тип оплаты: 1 – Наличными; 2 – Картой Мир; 3 – Картой Visa; 4 – Картой MasterCard; 5 – Расширенная оплата 1; 6 – Расширенная оплата 2; 7 – Расширенная оплата 3; 8 – Расширенная оплата 4; 9 – Расширенная оплата 5; 10 – Расширенная оплата 6; 11 – Расширенная оплата 7; 12 – Расширенная оплата 8; 13 – Расширенная оплата 9; 14 – Предвариательная оплата(Аванс); 15 – Последующая оплата(Кредит); 16 – Иная форма оплаты



    // Параметры для Банка Открытие
    define('OPENBANK_SERVICE_URL',     ''); // 'https://securetest.openbank.ru/testpayment/rest/'; // тестовый
    define('OPENBANK_SAMO_INC',        0);
    define('OPENBANK_SAMO_ALIAS',      'OPENBANK');
    define('OPENBANK_LOGIN',            '');
    define('OPENBANK_PASSWORD',         '');
    define('OPENBANK_CURRENCY',      810); // RUR



    define('PROCESSING_KZ_SAMO_INC',        0);
    define('PROCESSING_KZ_SAMO_ALIAS',      'PROCESSINGKZ');
    define('PROCESSING_KZ_MERCHANT',        '000000000000057'); // Мерчант
    define('PROCESSING_KZ_CURRENCY',        398); // Тенге
    define('PROCESSING_KZ_LANGUAGE',        'ru'); // ru – русский, kz – казахский, en - английский
    define('PROCESSING_KZ_WSDL',            'https://test.processing.kz/CNPMerchantWebServices/services/CNPMerchantWebService?wsdl'); // тестовый
    define('PROCESSING_KZ_LOCATION',        'https://test.processing.kz/CNPMerchantWebServices/services/CNPMerchantWebService');  // тестовый



    // Общие параметры для Acquiring
    define('ACQUIRING_CHECK_MODEL', ''); // модель, которая будет отправлять чеки плательщику и в ФНС, если пусто, значит будет задействована та, от которой был платеж

    // Параметры Forte-Банка
    define('FORTEBANK_SAMO_INC', 0);                         // Inc из INVOICESFORBANK.dbo.Bank
    define('FORTEBANK_SAMO_LOGIN', '');                  // Alias из INVOICESFORBANK.dbo.Bank
    define('FORTEBANK_MERCHANTID', '');
    define('FORTEBANK_SERVICE_URL', '');
    define('FORTEBANK_LANG', 'RU');
    define('FORTEBANK_CURRENCY', 'RUB');
