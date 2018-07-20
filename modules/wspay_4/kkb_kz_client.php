<?php
 include_once '../../properties.php'; include_once 'lib.php'; include_once _ROOT . 'includes/classes/class.samo_config.php'; Samo_Loader::register_autoload(); $db = connectdb(); $response = Samo_Request::find('response'); $status = Samo_Request::find('status'); if (DEBUG) { file_put_contents(dirname(INCLUDE_PATH_CACHE) . '/kkb_kz.log', '[' . date('Y-m-d H:i:s') . ']' . PHP_EOL . var_export($_POST, true) . PHP_EOL . PHP_EOL . PHP_EOL, FILE_APPEND | LOCK_EX); } if ($status == 'fail') { die('0'); } try { if ($response && preg_match('/<bank[^>]*>.*?<\/bank>/', $response, $letter)) { $xml = new Andr_Xml($response); $letter = $letter[0]; $sign = base64_decode((string)$xml->bank_sign); $key = file_get_contents(KKB_KZ_PUB_FILENAME); $key = openssl_get_publickey($key); $sign = strrev($sign); $result = openssl_verify($letter, $sign, $key); openssl_free_key($key); if ($result) { $merchant = $xml->bank->customer->merchant; $order = $merchant->order; if ((string)$merchant['cert_id'] == KKB_KZ_MERCHANT_CERT_ID && (int)$order['currency'] == 398) { $model = Samo_Loader::load_class('WSPAY_model'); $model = new $model($db); $bank = $model->getBank(KKB_KZ_SAMO_LOGIN); $iNumber = (string)$order['order_id']; $invoice = $model->getInvoiceData($iNumber); if ($invoice['CurSum'] <= (float)$order['amount'] && $invoice['Currency'] == 'KZT') { $res = $model->confirmInvoiceByINumber($iNumber, PSBANK_DEFAULT_OPERATION); die('0'); } } } } } catch (Exception $e) { $e; } die('1'); 