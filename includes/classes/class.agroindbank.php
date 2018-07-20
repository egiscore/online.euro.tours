<?php
class Agroindbank { protected $cainfoFile = ''; protected $sslcertFile = ''; protected $sslkeyFile = ''; protected $password = ''; protected $ip = ''; protected $merchantUrl = ''; public function __construct($merchantUrl, $cainfoFile, $sslcertFile, $sslkeyFile, $password, $ip) { $this->merchantUrl = $merchantUrl; $this->cainfoFile = $cainfoFile; $this->sslcertFile = $sslcertFile; $this->sslkeyFile = $sslkeyFile; $this->password = $password; $this->ip = $ip; } protected function doRequest($params) { $ch = curl_init($this->merchantUrl); $params['client_ip_addr'] = $this->ip; curl_setopt($ch, CURLOPT_CERTINFO, true); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); curl_setopt($ch, CURLOPT_CAINFO, $this->cainfoFile); curl_setopt($ch, CURLOPT_SSLCERT, $this->sslcertFile); curl_setopt($ch, CURLOPT_SSLKEY, $this->sslkeyFile); curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $this->password); curl_setopt($ch, CURLOPT_HEADER, 0); curl_setopt($ch, CURLOPT_POST, true); curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params)); $response = curl_exec($ch); curl_close($ch); $response = trim($response); $res = []; foreach (explode("\n", $response) as $i => $item) { if (preg_match('/^(.*?):(.*?)$/', $item, $m)) { $res[trim($m[1])] = trim($m[2]); } } if (!$res) { throw new Samo_Exception(Samo_EPlatez::messages('ACQUIRING_REQUEST_FAILED')); } if (isset($res['error'])) { throw new Samo_Exception($res['error']); } return $res; } public function getTransactionStatus($tr) { $res = $this->doRequest(['command' => 'c', 'trans_id' => $tr]); if (isset($res['RESULT']) && $res['RESULT']) { return $res['RESULT']; } throw new Samo_Exception(Samo_EPlatez::messages('ACQUIRING_FETCH_TRANSACTION_STATUS_FAILED')); } public function getTransactionId($amount, $currency, $description = '') { $res = $this->doRequest(['command' => 'v', 'amount' => $amount * 100, 'currency' => $currency, 'description' => $description]); if (isset($res['TRANSACTION_ID']) && $res['TRANSACTION_ID']) { return $res['TRANSACTION_ID']; } throw new Samo_Exception(Samo_EPlatez::messages('ACQUIRING_FETCH_TRANSACTION_ID_FAILED')); } } 