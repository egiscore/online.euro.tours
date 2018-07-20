<?php

define('ANDR_ENCODING_FILE', 'windows-1251');
define('ANDR_ENCODING_XML', 'utf-8');

define('ANDR_ROOT', dirname(__FILE__) . '/');

include_once ANDR_ROOT . '../../properties.php';

if (defined('_ROOT')) {
    define('ANDR_FOLDER_SITE', _ROOT);
} else {
    define('ANDR_FOLDER_SITE', ANDR_ROOT . '../../');
}

if (file_exists(ANDR_FOLDER_SITE . 'VERSION')) {
    $version = intval(file_get_contents(ANDR_FOLDER_SITE . 'VERSION'));
} else {
    $version = 0;
}

define('ONLINE_VERSION', $version);

define('ANDR_MODEL_VERSION_DEF', 5); //@todo: � ����� ������ ��� ������, ���� ���� ���� ��������� ������ ���������.

if (!defined('ANDR_MODEL_VERSION_DEF')) {
    if (defined('TOWNFROMINC')) {
        $_mv = 4;
    } else {
        $_mv = 0;
    }
    define('ANDR_MODEL_VERSION', $_mv);
} else {
    define('ANDR_MODEL_VERSION', ANDR_MODEL_VERSION_DEF);
}

if (ANDR_MODEL_VERSION >= 2) {
    ini_set('include_path', ANDR_ROOT . PATH_SEPARATOR . ANDR_FOLDER_SITE . 'vendor/pear/' . PATH_SEPARATOR . ini_get('include_path'));
} else {
    ini_set('include_path', ANDR_ROOT . PATH_SEPARATOR . ANDR_FOLDER_SITE . 'includes/classes/pear/' . PATH_SEPARATOR . ini_get('include_path'));
}
define('SMSSQL_DEF_USE', 0); //������������ �������� �������� �������� �� ��
define('SMSSQL_DEF_CREATE', 1); //���������� �������� �������� ��������
define('SMSSQL_DEF_DIR', ANDR_FOLDER_SITE . 'tmp/SMSSQL/'); //���� ��������� ��������

define('ANDR_SESSION_NAME', 'SAMO_ANDR'); //���� �� ��������, �� ������ �� ����� ���������

define('ANDR_SERV_MUST_BRON', 0); //�������� ������, ���� ������������ ������ ��� ����������� �������������
define('ANDR_SERV_TYPE_MUST_BRON', 0); //�������� ������, ���� ������������ ��� ������ ��� ����������� �������������

define('ANDR_SAVE_RUS_NAME', 0); //��������� ��� ��� ������� ���

define('ANDR_USE_UNREAD_FOR_NOTE', 0); //��� ������������ ���� ���������� �� ������, �� ������ ������ �� �����������

define('ANDR_DEBUG', 0);

include_once 'samo_domxml.php';

function __serviceType() {
    $type_map = array(
        1 => 3,
        2 => 4,
        4 => 3,
    );
    //3-��������, 4-���������, 5-������
    return $type_map;
}

function __portMap() {
    $port_map = array(
        '1.0' => 'port_work_1_00',
        '1.1' => 'port_work_1_01',
        '1.2' => 'port_work_1_02',
        '1.3' => 'port_work_1_03',
        '1.4' => 'port_work_1_04',
        '2.0' => 'port_work_1_04',
        '2.1' => 'port_work_2_01',
        '3.0' => 'port_work_3_00',
        '3.1' => 'port_work_3_01',
    );
    return $port_map;
}

include_once _ROOT . 'includes/classes/class.samo_config.php';

Samo_Loader::register_autoload();
