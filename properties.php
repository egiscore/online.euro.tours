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

//    define('STATEFROM', 2); // ����� (������ "�����������") ��� ������ ��������� ������������  �� ������������!!!
    define('TOWNFROMINC', 2);
    define('CURRENCYINC',1); // ������ ��-���������
    define('CL_REFER_REC_ON_PAGE', 10);
    define('CL_REFER_LINKS_ON_PAGE', 20);
    define('PROC_TESTPEOPLE_INTERNEL', '');  // ��������� ���������� ����� ���������� ���������� �������
    define('FIO_DELIMETER', ' ');
    define('INTERNET_USER', 2); // ��� ������������ ����-����, �� ����� �������� �������� ������ select * from [online_tour_config] where [what] = 'INTERNET_USER'
    define('DEFAULT_DATE_FORMAT', '%d.%m.%Y');
    define('LANGS', 'rus'); //����� ��������� ������ rus,eng,... , �� ��������� ���������� ������
    define('COOKIE_DOMAIN', null); // ����� �� ������� ��������������� cookie (����� � ������ �������� ��� ���������)
    define('ASSETS_HOST', isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null); // ����� �� ������� �������� ���������� public
    define('COOKIE_EXPIRE', strtotime('+1 month'));
    define('SESSION_NAME', 'SAMO');
    define('SECURITY_CHECK_REFERER', true); // ��������� �� http_referer �� ���������� � http_host?, ��������� ���, ��� ������ �������� � iframe
    //define('EDOC_CHECK_TYPE', 0); // 0 - no check; 1 - check status (��������� ������� ������ � ������� monitor); 2 - check schedule
    //define('SEARCH_TOURTYPE_FILTER', 0); // �������, ���� �������������� ��� ����������� �������� 0
    //define('SEARCH_PROGRAMTYPE_FILTER', 0); // �������, ���� �������������� ��� ����������� �������� 0
    //define('SEARCH_INCOMINGPARTNER_FILTER', 0); // �������, ���� �������������� ��� ����������� �������� 0
    define('SEARCH_PAYMENTSCHEDULE',1);
    //define('ATTRIBUTE_LTAGS_HOTELTYPE', 'Hotel type');
    //define('MAP_KEY', 'AIzaSyDZBKPoj8jN9Rme6HwiVrsrmMFKqJfQtSI');
    define('PRICE_CACHE_REDIS', false);
    define('REGISTER_BY_INN', false); // �������� ���� INN ��������� ��� ����������� ��������� (������ ��� ��)

    /* Paths */
    /* ��� ���� ������������!! ������������� ���������� ��������� (�� �����), ��� ������ ��������� ��������. */

    $_normalize = function($path) {
        return rtrim(str_replace(array(DIRECTORY_SEPARATOR, '//'), '/', $path), '/');
    };

    define('_ROOT', $_normalize(__DIR__) . '/'); // ���� � ���������� � �������� �������
    define('WWWROOT', $_normalize(str_replace($_normalize($_SERVER['DOCUMENT_ROOT']), '/' , _ROOT)) . '/');  // URL ����������

    $tmp = $_normalize(dirname(__DIR__)) . '/tmp/'; // ������ tmp �� ��������� document_root
    define('_TMP', (file_exists($tmp)) ? $tmp : _ROOT . 'tmp/'); // ����� ������������ ��, ��� ��������
    unset($tmp);

    define('TOWNSFROM_CACHE', _TMP . 'servers_cache.php');
    define('INCLUDE_PATH_CACHE', _TMP . 'classmap_cache.php');
    define('ROUTES_PATH', _ROOT . 'routes.php');
    define('SMARTY_COMPILE_DIR', _TMP . 'templates_c/'); // ��� ����� ������� ������ ���� � ������������� ��������
    define('INTERNAL_CACHE_DIR', _TMP . 'cache.dir'); // �������� ��� ������ ��������� � c:/srv/tmp, ����� ��������� �� ����� �������� �����
    define('INTERNAL_CACHE_DRIVER', 'auto');
    define('FPDF_FONTPATH', _ROOT . 'vendor/pdffont/'); // ���� � ������� ������� ��� ��������� PDF-����������

    /* System settings */
    define('DEBUG',isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '212.34.54.82');
    define('APPMODE', (DEBUG) ? 'test' : 'production');

    define('SMARTY_RESOURCE_CHAR_SET', 'cp1251');

    define('LOG_TYPE', 'samo_firebug');
    define('TOOLSPROTECT', 'wpR4UM4l9D'); // �� �������� ������������!!!
    //define('FRIENDLY_URLS', 1);

    define('SAMOGUID', '00000000-0000-0000-0000-000000000000');
    /*
    # � ��������� ������� ���-������ ����� �� ������-��������, � ����� ������������ ��������� � ������ ����������
    $_SERVER["REMOTE_ADDR"] = ($_SERVER["REMOTE_ADDR"] == '127.0.0.1' && isset($_SERVER['HTTP_REMOTE_ADDR'])) ? $_SERVER['HTTP_REMOTE_ADDR'] : $_SERVER["REMOTE_ADDR"];

    # � ������, ����� ������ ����� ��������� ������� �� ����������� ����������� ������ ������ ���������� ������������ ������������� �� ���� ����� (����� �������� ������ �������������� ������)
    if ($_SERVER['HTTP_HOST'] != 'maindomain.tld' && $_SERVER['REQUEST_METHOD'] == 'GET') {
        header('Location: http://maindomain.tld'.$_SERVER['REQUEST_URI'],true,301);
        exit;
    }
    //*/

    function PSBANK_Users() {
        //������������ web-�������
        return array(
            'samo' => 'samo',
        );
    }
    define('PSBANK_DEFAULT_OPERATION',2); //����� ������������ ����� ��� simple_client.php

    // ��������� ������� � Platron
    // ��������!!! � ������� Platron'� ���� ��������� � ��������:
    // - [check_url]  = http://[operator.online]/modules/wspay_4/platron_client.php?check
    // - [capture_url]  = http://[operator.online]/modules/wspay_4/platron_client.php?capture
    // - [result_url] = http://[operator.online]/modules/wspay_4/platron_client.php
    // - [request_method] = POST
    define('PLATRON_MERCHANT_ID', ''); // merchant_id � ��������
    define('PLATRON_SECRET_KEY',  '');    // secret_key � ��������
    define('PLATRON_SAMO_INC', 0); // inc ��� �������� � INVOICESFORBANK.dbo.Bank
    define('PLATRON_SAMO_LOGIN', 'PLATRON'); // ����� ��� �������� � INVOICESFORBANK.dbo.Bank
    define('PLATRON_PAY_URL',       'https://www.platron.ru/payment.php');        // URL �������� ������, ���� ����� ������������
    define('PLATRON_STATUS_URL',    'https://www.platron.ru/get_status.php');
    define('PLATRON_CURRENCY',    'RUB');
    define('PLATRON_AVIA_TICKET', '0'); // ���������� ���������� ��� ���������

    // ��������� ������� � Platron ��� ������� ���
    // ��������!!! � ������� Platron'� ���� ��������� � ��������:
    //[check_url]  = http://[operator.online]/modules/wspay_4/platron_client.php?b2c=1&check
    //[capture_url]  = http://[operator.online]/modules/wspay_4/platron_client.php?b2c=1&capture
    //[result_url] = http://[operator.online]/modules/wspay_4/platron_client.php?b2c=1
    //define('PLATRON_MERCHANT_ID_B2C', ''); // merchant_id � ��������
    //define('PLATRON_SECRET_KEY_B2C', '');    // secret_key � ��������



    //define('WSPAY_NULL_PASSPORT', true); //��������� ��������� ������ � ��������� ������� �������� ��������� ����������� �����

    // ��������� ������� � Sberbank
    define('SBERBANK_USERNAME',     ''); // ����� ��� ������� � ���������
    define('SBERBANK_PASSWORD',     ''); // ������ ��� ������� � ���������
    define('SBERBANK_SAMO_INC',     0);  // inc ��� ��������� � INVOICESFORBANK.dbo.Bank
    define('SBERBANK_SAMO_LOGIN',   ''); // ����� ��� ��������� � INVOICESFORBANK.dbo.Bank
    define('SBERBANK_URL',          ''); // URL ��������� ��� �������� ��������, �������� "https://3dsec.sberbank.ru/payment/rest/"
    define('SBERBANK_PRE_AUTH',     0);  // ��������� ������� � ���������������

    define('SBERBANK_CLIENT_LOGIN', ''); // for sberbank_client.php to pay without get param [login]
    //define('SBERBANK_CLIENT_LOG', _TMP . 'sberbank_client.log');


    // ��������� ������� � ��������������
    // ��������!! ��������� � InvNumbers c ��������� 0 (����) � min ������ 6 ��������
    // ��� ������� � ���������������
    define('KKB_KZ_MERCHANT_ID',        '');               // �������� �� � ���������� ������� (������: 12345678)
    define('KKB_KZ_MERCHANT_NAME',      '');               // �������� �������� (��������) Shop/merchant Name (������: Test shop)
    define('KKB_KZ_MERCHANT_CERT_ID',   '');               // �������� ����� ����������� Cert Serial Number (������: 00C182B189)
    define('KKB_KZ_PRV_PASSWORD',   '');                   // ������ � ��������� ����� Private cert password (���� ��� ���, �� ������ ������������ ��� ������) (������: 12345)
    define('KKB_KZ_PAY_URL',        '');                   // ���� �������� ���� (������: https://epay.kkb.kz/jsp/process/logon.jsp)
    // ��� ������ ��
    define('KKB_KZ_PRV_FILENAME',  '');                     // ���� � ��������� ����� Private cert path (������: _ROOT . 'data/kkb_kz/prv.pem')
    define('KKB_KZ_PUB_FILENAME',  '');                     // ���� � ��������� ����� Public cert path (������: _ROOT . 'data/kkb_kz/pub.pem')
    define('KKB_KZ_SAMO_INC',      '');                     // inc ��� kkb_kz � INVOICESFORBANK.dbo.Bank (������: 16512)
    define('KKB_KZ_SAMO_LOGIN',    '');                     // ����� � ������� ���� (������: KKB_KZ)


    // ��������� ������� � Uniteller
    // �� �������� ������� � ���������� �������� "URL ��� ����������� ������� ��������-�������� �� ������������ ������� �����/������": http://[operator.online]/modules/wspay_4/uniteller_client.php
    define('UNITELLER_SHOP_ID',  '');   // ID �������� (������ "����� �������" ������� �������� => �������� Uniteller Point ID)
    define('UNITELLER_PASSWORD', '');   // ������ �� "��������� �����������"
    define('UNITELLER_PAY_URL',  '');   // URL ������ (��������: https://wpay.uniteller.ru/pay/)
    define('UNITELLER_SAMO_INC', 0);    // inc ��� Uniteller � INVOICESFORBANK.dbo.Bank
    define('UNITELLER_SAMO_LOGIN', ''); // ����� ��� Uniteller � INVOICESFORBANK.dbo.Bank

    // ��������� ������ ������ ����
    define('CREDIT_EUROPE_BANK_CLIENT_ID', '');                                                  // ������������� ��������
    define('CREDIT_EUROPE_BANK_STOREKEY', '');                                                   // ���� ������������
    define('CREDIT_EUROPE_BANK_API_LOGIN', '');                                                  // ������������
    define('CREDIT_EUROPE_BANK_API_PASSWORD', '');                                               // ������
    define('CREDIT_EUROPE_BANK_API_STATUS_URL', 'https://paysafe.crediteurope.ru/fim/api');      // URL API ��� ��������� ������� �������
    define('CREDIT_EUROPE_BANK_PAY_URL', 'https://paysafe.crediteurope.ru/fim/est3Dgate');       // URL �������� ������
    define('CREDIT_EUROPE_BANK_SAMO_INC', 0);                                                    // Inc �� INVOICESFORBANK.dbo.Bank
    define('CREDIT_EUROPE_BANK_SAMO_LOGIN', '');                                                 // Alias �� INVOICESFORBANK.dbo.Bank
    define('CREDIT_EUROPE_BANK_LOG', '');                                                        // ���� � ����� ���� (��������, _TMP.'credit_europe_bank.log'), ���� �����, �� ��� �� ����� ��������




    // ��������� �����-�����
    define('ALFABANK_SAMO_INC', 0);                             // Inc �� INVOICESFORBANK.dbo.Bank
    define('ALFABANK_SAMO_LOGIN', 'ALFABANK');                  // Alias �� INVOICESFORBANK.dbo.Bank
    define('ALFABANK_API_LOGIN', '');                           // API-�����
    define('ALFABANK_API_CURRENCY', 810);                       // API-������ 810 - RUB, ISO 4217
    define('ALFABANK_API_PASSWORD', '');                        // API-������
    define('ALFABANK_API_MERCHANT_LOGIN', '');                  // API-����� �������� (����� ���� ������)
    define('ALFABANK_API_MERCHANT_LOGIN_B2C', '');              // API-����� ��������, ������� ����� ������� � cl_refer_person (����� ���� ������)


    // ��������� �����-����� ��� ����������
    define('ALFABANK_T_SAMO_ALIAS', 'alfabank_t');              // Alias �� INVOICESFORBANK.dbo.Bank



    // ��������� ��� PayLate
    define('PAYLATE_SAMO_INC',      0);                                     // Inc �� INVOICESFORBANK.dbo.Bank
    define('PAYLATE_SAMO_ALIAS',    'PAYLATE');                             // Alias �� INVOICESFORBANK.dbo.Bank
    define('PAYLATE_CLIENT_ID',     '1702082013');                          // ID �������
    define('PAYLATE_LOGIN',         'test');                                // �����
    define('PAYLATE_PASSWORD',      'test');                                // ������
    define('PAYLATE_PAY_URL',       'https://paylate.ru:21443/bypartner');  // URL, ���� ���������� ������ � �����
    define('PAYLATE_MAX_AMOUNT',    150000);                                // ������������ ����� �������


    // ��������� ��� PayBox
    define('PAYBOX_SAMO_INC',      1);                                         // Inc �� INVOICESFORBANK.dbo.Bank
    define('PAYBOX_SAMO_ALIAS',    'PAYBOX');                                  // Alias �� INVOICESFORBANK.dbo.Bank
    define('PAYBOX_MERCHANT_ID',   '123');                                     // ������� ��
    define('PAYBOX_SECRET_KEY',    'secret');                                  // Secret key
    define('PAYBOX_PAY_URL',       'https://www.paybox.kz/payment.php');       // URL �������� ������, ���� ����� ������������
    define('PAYBOX_STATUS_URL',    'https://www.platron.ru/get_status.php');   // URL �������� ������, ���� ����� ������������
    define('PAYBOX_CURRENCY',      'KZT');                                     // ������


    // ��������� ��� LiqPay (https://www.liqpay.com/ru/doc/checkout)
    define('LIQPAY_SAMO_INC',      0);                                          // Inc �� INVOICESFORBANK.dbo.Bank
    define('LIQPAY_SAMO_ALIAS',    'LIQPAY');                                   // Alias �� INVOICESFORBANK.dbo.Bank
    define('LIQPAY_CURRENCY',      'UAH');                                      // ������ �������.��������� ��������: USD, EUR, RUB, UAH
    define('LIQPAY_PUBLIC_KEY',    '');                                         // ��������� ���� - ������������� ��������. �������� ���� ����� � ���������� ��������
    define('LIQPAY_PRIVATE_KEY',   '');                                         // ��������� ����



    // ��������� ��� Fondy, ���� ������ �������� ������
    define('FONDY_SAMO_INC',        90526);       // Inc �� INVOICESFORBANK.dbo.Bank
    define('FONDY_SAMO_ALIAS',      'Fondy');     // Alias �� INVOICESFORBANK.dbo.Bank
    define('FONDY_MERCHANT_ID',     '1396424');   // MerchantID, ����� �� ��->������ ���������->��������� ��������->����������� "ID ��������"
    define('FONDY_PASSWORD',        'test');      // ���� �������, ����� �� ��->������ ���������->��������� ��������->����������� "���� �������"
    define('FONDY_CURRENCY',        'RUB');       // ������ - EUR, USD, GBP, RUB, UAH
    define('FONDY_PREAUTH',         false);       // ������������ ��������������
    define('FONDY_PAY_TTL',         0);           // ����� ����� ������� � �������, ���� ������ ��������� � ������������� ���������, �� ����� ����� ttl ��� ������ ������ ����������� �� �����, ���� ������ �������� � 0, �� ����� ����������� ������


    // ���������� ��� Moldova Agroindbank
    define('AGROINDBANK_SAMO_INC',          0);                 // Inc �� INVOICESFORBANK.dbo.Bank
    define('AGROINDBANK_SAMO_ALIAS',        'AGROINDBANK');     // Alias �� INVOICESFORBANK.dbo.Bank
    define('AGROINDBANK_CURRENCY',          498);               // ������ (ISO 4217), ������ MDL
    define('AGROINDBANK_PASSWORD',          '');                // ������ � �����������
    define('AGROINDBANK_MERCHANT_URL',      'https://ecomm.maib.md:4455/ecomm2/MerchantHandler');   // URL �������� (���� ������������ �������)
    define('AGROINDBANK_CLIENT_URL',        'https://ecomm.maib.md/ecomm2/ClientHandler');          // URL ������� (���� ������������� ������������)
    define('AGROINDBANK_CAINFO_FILE',       '');    // ���� � ����� �����������, ��������, _ROOT.'data/agroindbank/cacert.pem'
    define('AGROINDBANK_SSLCERT_FILE',      '');    // ���� � ����� �����������, ��������, _ROOT.'data/agroindbank/pcert.pem'
    define('AGROINDBANK_SSLKEY_FILE',       '');    // ���� � �����-����� �����������, ��������, _ROOT.'data/agroindbank/key.pem'


    // ��������� ��� ��������������
    define('PSB_SAMO_INC',      0);                                     // Inc �� INVOICESFORBANK.dbo.Bank
    define('PSB_SAMO_ALIAS',    'PSB');                                 // Alias �� INVOICESFORBANK.dbo.Bank
    define('PSB_TERMINAL',      '79036768');                            // ��������
    define('PSB_MERCHANT',      '790367686219999');                     // �������
    define('PSB_MERCHANT_NAME', 'SAMO-SOFT');                           // �������� ��������, �� ��������
    define('PSB_KEY',           'C50E41160302E0F5D6D59F1AA3925C45');    // ����
    define('PSB_PRE_AUTH',      false);                                 // ���������������
    // ������ ��� ��������� POST �����������: http://[online]/modules/wspay_4/acquiring_client.php?s=psb



    // ��������� ��� Payture (http://payture.com/integration/api/)
    define('PAYTURE_HOST',  ''); // ����, ��������, �������� - 'https://sandbox3.payture.com/'
    define('PAYTURE_KEY',   ''); // ������������� ���. �������� � ����������� ���������/������� �������
    define('PAYTURE_PASSWORD',   ''); // �����
    // ��� ����
    define('PAYTURE_INN',               ''); // ��� �����������, ��� ������� ����������� ���
    define('PAYTURE_TAX',               1); // ������ ���: 1 � ������ ��� 18%; 2 � ������ ��� 10%; 3 � ������ ��� ����. 18/118; 4 � ������ ��� ����. 10/110; 5 � ������ ��� 0%; 6 � ��� �� ����������
    define('PAYTURE_TAXATION_SYSTEM',   0); // ������� ���������������: 0 � �����, ���; 1 � ���������� �����, ��� �����; 2 � ���������� ����� ����� ������, ��� ����� - ������; 3 � ������ ����� �� ��������� �����, ����; 4 � ������ �������������������� �����, ���; 5 � ��������� ������� ���������������, ������
    define('PAYTURE_PAYMENT_TYPE',      16); // ��� ������: 1 � ���������; 2 � ������ ���; 3 � ������ Visa; 4 � ������ MasterCard; 5 � ����������� ������ 1; 6 � ����������� ������ 2; 7 � ����������� ������ 3; 8 � ����������� ������ 4; 9 � ����������� ������ 5; 10 � ����������� ������ 6; 11 � ����������� ������ 7; 12 � ����������� ������ 8; 13 � ����������� ������ 9; 14 � ���������������� ������(�����); 15 � ����������� ������(������); 16 � ���� ����� ������



    // ��������� ��� ����� ��������
    define('OPENBANK_SERVICE_URL',     ''); // 'https://securetest.openbank.ru/testpayment/rest/'; // ��������
    define('OPENBANK_SAMO_INC',        0);
    define('OPENBANK_SAMO_ALIAS',      'OPENBANK');
    define('OPENBANK_LOGIN',            '');
    define('OPENBANK_PASSWORD',         '');
    define('OPENBANK_CURRENCY',      810); // RUR



    define('PROCESSING_KZ_SAMO_INC',        0);
    define('PROCESSING_KZ_SAMO_ALIAS',      'PROCESSINGKZ');
    define('PROCESSING_KZ_MERCHANT',        '000000000000057'); // �������
    define('PROCESSING_KZ_CURRENCY',        398); // �����
    define('PROCESSING_KZ_LANGUAGE',        'ru'); // ru � �������, kz � ���������, en - ����������
    define('PROCESSING_KZ_WSDL',            'https://test.processing.kz/CNPMerchantWebServices/services/CNPMerchantWebService?wsdl'); // ��������
    define('PROCESSING_KZ_LOCATION',        'https://test.processing.kz/CNPMerchantWebServices/services/CNPMerchantWebService');  // ��������



    // ����� ��������� ��� Acquiring
    define('ACQUIRING_CHECK_MODEL', ''); // ������, ������� ����� ���������� ���� ����������� � � ���, ���� �����, ������ ����� ������������� ��, �� ������� ��� ������

    // ��������� Forte-�����
    define('FORTEBANK_SAMO_INC', 0);                         // Inc �� INVOICESFORBANK.dbo.Bank
    define('FORTEBANK_SAMO_LOGIN', '');                  // Alias �� INVOICESFORBANK.dbo.Bank
    define('FORTEBANK_MERCHANTID', '');
    define('FORTEBANK_SERVICE_URL', '');
    define('FORTEBANK_LANG', 'RU');
    define('FORTEBANK_CURRENCY', 'RUB');
