<?php
class LiqPay { const PROTOCOL_VERSION = 3; const PAY_URL = 'https://www.liqpay.com/api/3/checkout'; protected $publicKey = ''; protected $privateKey = ''; public function __construct($publicKey, $privateKey) { $this->publicKey = $publicKey; $this->privateKey = $privateKey; } public function getRequestData($amount, $currency, $description, $orderId, $callbackURL = '', $advParams = []) { $data = [ 'version' => static::PROTOCOL_VERSION, 'public_key' => $this->publicKey, 'action' => 'pay', 'amount' => $amount, 'currency' => $currency, 'description' => $description, 'order_id' => $orderId, 'sandbox' => 0, 'server_url' => $callbackURL ]; if ($advParams) { $data = array_merge($data, $advParams); } $data = base64_encode(json_encode($data)); $sign = $this->getSign($data); return [ 'data' => $data, 'signature' => $sign ]; } protected function getSign($data) { return base64_encode(sha1($this->privateKey.$data.$this->privateKey, true)); } public function parseStatusInfo($data, $sign) { if (!$sign || $sign != $this->getSign($data)) { throw new Exception('Invalid signature'); } $data = json_decode(base64_decode($data), true); if (!$data['public_key'] || $data['public_key'] != $this->publicKey) { throw new Exception('Invalid public key'); } return $data; } } 