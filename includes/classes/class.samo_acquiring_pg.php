<?php
 class Samo_Acquiring_PG extends Samo_Acquiring { protected $OPT_CREATE_CHECK_STATUS_JOB = true; public function __construct() { parent::__construct(); $this->bankInc = $this->_pgConfig('SAMO_INC'); $this->bankAlias = $this->_pgConfig('SAMO_ALIAS'); if (null == $this->bankInc) { throw new Samo_Exception(get_called_class() . ' was not configured', 501); } } protected function _pgConfig($what) { $mn = strtoupper($this->moduleName); return $this->acquiringConfig($mn.'_'.$what); } public function getHiddenFields() { return array_merge(['pg_merchant_id' => $this->_pgConfig('MERCHANT_ID'), 'pg_order_id' => '', 'pg_amount' => '', 'pg_currency' => '', 'pg_description' => '', 'pg_salt' => '', 'pg_sig' => '', 'pg_success_url' => '', 'pg_failure_url' => ''], $this->getAviaFields()); } public function getFormAction() { return $this->_pgConfig('PAY_URL'); } protected static function _sign($data, $script, $merchantId, $secretKey) { if (!isset($data['pg_salt'])) { $data['pg_salt'] = uniqid(); } if ($merchantId) { $data['pg_merchant_id'] = $merchantId; } $script = trim(basename($script)); ksort($data); $d = $data; array_unshift($d, $script); array_push($d, $secretKey); $data['pg_sig'] = md5(implode(';', $d)); return $data; } protected function getAviaFields() { $return = []; if ($this->_pgConfig('AVIA_TICKET')) { $tName = false; $ps = []; $claim = Samo_Loader::load_object('Samo_Claim'); $claim->construct($this->_claim); if ($res = $claim->claimPeoples()) { $minInc = false; foreach ($res as $r) { if ($minInc === false || $r['Inc'] < $minInc) { $minInc = $r['Inc']; } $ps[$r['Inc']] = $r['LName']; } if ($minInc) { $tName = $ps[$minInc]; } } if (!$tName) { throw new Samo_Exception('Tourist name not found'); } $return['pg_ticket_passenger_name'] = $tName; $info = $claim->claimInfo(); $return['pg_tripleg_1_date'] = $info['DateBeg']->format('Y-m-d'); $return['pg_tripleg_2_date'] = $info['DateEnd']->format('Y-m-d'); } return $return; } public function makeFormData() { $invoice = $this->getInvoice(); $aFields = $this->getAviaFields(); $params = array_merge(['pg_order_id' => $invoice['inumber'], 'pg_amount' => $this->_amount, 'amount' => $this->_amount, 'pg_currency' => $this->_pgConfig('CURRENCY'), 'pg_description' => $aFields ? $this->_claim : 'Pay for claim N'.$this->_claim, 'pg_failure_url' => $this->makeFailURL($invoice['inumber']), 'pg_success_url' => $this->makeOkURL($invoice['inumber'])], $aFields); $params = self::_sign($params, $this->_pgConfig('PAY_URL'), $this->_pgConfig('MERCHANT_ID'), $this->_pgConfig('SECRET_KEY')); if ($this->OPT_CREATE_CHECK_STATUS_JOB) { $this->createCheckOrderStatusJob('return '.get_class($this).'::checkOrderStatus(\''.$invoice['inumber'].'\', \''.$this->_pgConfig('STATUS_URL').'\', \''.$this->_pgConfig('MERCHANT_ID').'\', \''.$this->_pgConfig('SECRET_KEY').'\', \''.$this->_pgConfig('SAMO_ALIAS').'\');'); } return $params; } public static function checkOrderStatus($inumber, $url, $merchantId, $secretKey, $bankAlias) { $params = array ( 'pg_merchant_id' => $merchantId, 'pg_order_id' => $inumber, ); $params = self::_sign($params, $url, $merchantId, $secretKey); $res = file_get_contents($url.'?'.http_build_query($params)); if (!$res) { throw new Samo_Exception(Samo_EPlatez::messages('ACQUIRING_FETCH_TRANSACTION_STATUS_FAILED')); } $res = new Andr_Xml($res); $params = array(); $pg_sig = ''; foreach ($res->children() as $ch) { $n = $ch->getName(); if ($n != 'pg_sig') { $params[$n] = (string)$ch; } else { $pg_sig = (string)$ch; } } $params = self::_sign($params, $url, null, $secretKey); if (!$pg_sig || $pg_sig != $params['pg_sig']) { throw new Samo_Exception(Samo_EPlatez::messages('ACQUIRING_INCORRECT_RESPONSE_SIGNATURE')); } if ((string)$res->pg_status != 'ok') { throw new Samo_Exception((string)$res->pg_error_description.'('.(string)$res->pg_error_code.')'); } switch(trim((string)$res->pg_transaction_status)) { case 'ok': self::confirmOrder($bankAlias, $inumber); return true; break; case 'failed': case 'revoked': return true; break; } return false; } } 