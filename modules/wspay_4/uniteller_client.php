<?php
 include_once '../../properties.php'; include_once 'lib.php'; include_once _ROOT . 'includes/classes/class.samo_config.php'; Samo_Loader::register_autoload(); $db = connectdb(); $notify_status = Samo_Request::find('Status'); $notify_order_id = Samo_Request::find('Order_ID'); $notify_signature = Samo_Request::find('Signature'); if (DEBUG) { file_put_contents(dirname(INCLUDE_PATH_CACHE) . '/uniteller.log', '[' . date('Y-m-d H:i:s') . ']' . PHP_EOL . var_export($_POST, true) . PHP_EOL . PHP_EOL . PHP_EOL, FILE_APPEND | LOCK_EX); } if ($notify_status && $notify_order_id && $notify_signature) { if ( $notify_signature == strtoupper(md5($notify_order_id . $notify_status . UNITELLER_PASSWORD)) && $notify_status == 'paid' ) { $model = Samo_Loader::load_class('WSPAY_model'); $model = new $model($db); $bank = $model->getBank(UNITELLER_SAMO_LOGIN); $res = $model->confirmInvoiceByINumber($notify_order_id, PSBANK_DEFAULT_OPERATION); die('Ok'); } } die('Error'); 