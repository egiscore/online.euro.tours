<?php
$_ORIG_CWD = getcwd(); $_ORIG_GET = $_GET; $_ORIG_POST = $_POST; $_GET['page'] = 'passport'; define('SAMO_REQUEST_DONT_FINISH', true); include dirname(__FILE__) . '/default.php'; if (!isset($_SESSION['samo_auth']) || !isset($_SESSION['samo_auth']['PartPassInc'])) { exit; } session_write_close(); $_GET = $_ORIG_GET; $_POST = $_ORIG_POST; $PARTPASSINC = $_SESSION['samo_auth']['PartPassInc']; $PARTNERINC = $_SESSION['samo_auth']['Partner']; $PARTNERNAME = $_SESSION['samo_auth']['OfficialName']; $LOGINNAME = $_SESSION['samo_auth']['PartPassAlias']; chdir($_ORIG_CWD); unset($routes, $module, $temp, $date, $messages, $_ORIG_GET, $_ORIG_POST, $_ORIG_CWD, $_SESSION, $HTTP_SESSION_VARS, $paranoia, $action, $samo_auth); 