<?php
 class Processing_Kz_Model extends Samo_Acquiring { protected $moduleName = 'processing_kz'; public function __construct() { $inc = $this->acquiringConfig('PROCESSING_KZ_SAMO_INC'); $login = $this->acquiringConfig('PROCESSING_KZ_SAMO_ALIAS'); if ($inc && $login) { parent::__construct(); $this->bankInc = $inc; $this->bankAlias = $login; } else { if ($this->is_module_installed('processing_kz')) { throw new Samo_Exception(get_called_class() . ' was not configured', 501); } } } protected static function doRequest($action, $params = [], $env = '') { $client = new SoapClient(static::acquiringConfig('PROCESSING_KZ_WSDL'), ['trace' => 1, 'location' => static::acquiringConfig('PROCESSING_KZ_LOCATION')]); $params['merchantId'] = static::acquiringConfig('PROCESSING_KZ_MERCHANT'); if ($env) { $params = [$env => $params]; } $res = $client->$action($params); if ($res && isset($res->return)) { $res = $res->return; } return $res; } public function makeFormData() { $inv = $this->getInvoice(); $amount = ceil($this->_amount * 100); $curr = $this->acquiringConfig('PROCESSING_KZ_CURRENCY'); $d = new Samo_Datetime('now'); $d = $d->format('d.m.Y H:i:s'); $res = $this->doRequest('startTransaction', ['orderId' => $inv['inumber'], 'totalAmount' => $amount, 'currencyCode' => $curr, 'languageCode' => $this->acquiringConfig('PROCESSING_KZ_LANGUAGE'), 'goodsList' => ['nameOfGoods' => 'Claim #'.$this->_claim, 'amount' => $amount, 'currencyCode' => $curr], 'returnURL' => $this->getReturnURL(), 'merchantLocalDateTime' => $d], 'transaction'); if (!$res->success) { throw new Samo_Exception($res->errorDescription); } $this->saveCurrentTransactionId($res->customerReference); $this->createCheckOrderStatusJob('return Processing_KZ_Model::processOrderStatus(\'' . $inv['inumber'] . '\');'); return $res->redirectURL; } public static function completeTransaction($inumber) { $invoice = static::getInvoiceInfo($inumber); if (static::doRequest('completeTransaction', ['referenceNr' => $invoice['TransactionId'], 'transactionSuccess' => true]) === true) { static::confirmOrder(static::acquiringConfig('PROCESSING_KZ_SAMO_ALIAS'), $inumber); return true; } return false; } public static function processOrderStatus($inumber) { $invoice = static::getInvoiceInfo($inumber); $res = static::doRequest('getTransactionStatusCode', ['referenceNr' => $invoice['TransactionId']]); switch ($res->transactionStatus) { case 'NO_SUCH_TRANSACTION': case 'DECLINED': case 'REVERSED': case 'REFUNDED': return true; break; case 'MID_DISABLED': case 'INVALID_MID': throw new Samo_Exception($res->transactionStatus); break; case 'PAID': static::confirmOrder(static::acquiringConfig('PROCESSING_KZ_SAMO_ALIAS'), $inumber); return true; break; case 'AUTHORISED': return static::completeTransaction($inumber); break; case 'PENDING_CUSTOMER_INPUT': case 'PENDING_AUTH_RESULT': default: return false; break; } } } 