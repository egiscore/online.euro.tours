<?php
 class Kkb_Kz_Model extends Samo_EPlatez { public function construct($claim = null, $people = null, $order = null) { parent::construct($claim, $people, $order); $this->checkKKBKZParams(); $this->defaults['BANK'] = KKB_KZ_SAMO_INC; } public function is_enabled() { parent::is_enabled(); $this->fetchOwner(); } protected function checkKKBKZParams() { foreach (array( 'MERCHANT_ID', 'MERCHANT_NAME', 'MERCHANT_CERT_ID', 'PRV_FILENAME', 'PUB_FILENAME', 'SAMO_INC', 'PAY_URL' ) as $i) { $i = 'KKB_KZ_' . $i; if (!defined($i) || !constant($i)) { $this->_die($this->messages['KKB_KZ_PARAMS_NOT_SETS']); break; } } } private function _die($message) { throw new Samo_Exception($message); } protected function makeSign($orderId, $amount, $currencyCode) { $fname = KKB_KZ_PRV_FILENAME; if (!file_exists($fname)) { $this->_die('Certificate file (' . $fname . ') not found!'); } $password = defined('KKB_KZ_PRV_PASSWORD') && KKB_KZ_PRV_PASSWORD ? KKB_KZ_PRV_PASSWORD : null; $key = openssl_get_privatekey(file_get_contents($fname), $password); if (!$key) { $this->_die('Certificate error [' . openssl_error_string() . ']'); } $xml = new Andr_Xml('<merchant/>'); $xml->addAttributes( array( 'cert_id' => KKB_KZ_MERCHANT_CERT_ID, 'name' => KKB_KZ_MERCHANT_NAME ) ); $xml->addChild('order')->addAttributes( array( 'order_id' => $orderId, 'amount' => $amount, 'currency' => $currencyCode, ) )->addChild('department')->addAttributes( array( 'merchant_id' => KKB_KZ_MERCHANT_ID, 'amount' => $amount ) ); $xml = $xml->asXml(); $xml = str_replace(array("\r\n", "\r", "\n", PHP_EOL), '', $xml); openssl_sign($xml, $out, $key); $result = '<document>' . $xml . '<merchant_sign type="RSA">' . base64_encode(strrev($out)) . '</merchant_sign></document>'; return base64_encode($result); } public function getRequestData() { $this->checkKKBKZParams(); parent::getPaymentInfo(); list($moneyIndex, $moneyName, $currencyCode) = $this->getCurrency(); $amount = floatval(str_replace(',', '.', Samo_Request::find('amount'))); if (!$amount) { $this->_die($this->messages['KKB_KZ_EMPTY_AMOUNT']); } $this->fetchOwner(); $this->getPaymentInfo(); if ($amount > $this->defaults['CLAIM_COST'][$moneyIndex]['Debt']) { $this->_die($this->messages['KBB_KZ_OVER_AMOUNT'] . $this->defaults['CLAIM_COST'][$moneyIndex]['Debt']); } $this->fetch_eplatez_Number(); $orderId = str_pad($this->defaults['inumber'], 6, '0', STR_PAD_LEFT); $this->setPayerInfo(); $this->defaults['FIRM'] = 'KKB_KZ'; $this->defaults['TRANSACTIONID'] = $orderId; $this->defaults['PAYER']['CURRENCY'] = $moneyName; $this->defaults['PAYER']['TOPAY'] = $amount; $this->SaveToInvoicesForBank(); return array( $this->makeSign($orderId, $amount, $currencyCode), $this->makeAppendix($amount) ); } protected function setPayerInfo() { $this->defaults['PAYER']['PAYER_FIO'] = Samo_Request::remote_addr(); $this->defaults['PAYER']['PAYER_PSERIE'] = null; $this->defaults['PAYER']['PAYER_PNUMBER'] = null; $this->defaults['PAYER']['PAYER_PGIVENDATE'] = 0; $this->defaults['PAYER']['PAYER_PGIVENORG'] = null; $this->defaults['PAYER']['PAYER_PGIVENORG_MENT'] = null; $this->defaults['PAYER']['PAYER_ADDRESS'] = null; $this->defaults['PAYER']['PAYER_BORN'] = null; } protected function makeAppendix($amount) { $app = new Andr_Xml('<document/>'); $subject = sprintf(Samo_EPlatez::messages('ACQUIRING_PAYMENT_PURPOSE_KKB_KZ'), $this->defaults['CLAIM'], $this->defaults['inumber']); $name = mb_convert_encoding($subject, 'utf-8', 'windows-1251'); $app->addChild('item')->addAttributes( array( 'number' => 1, 'name' => $name, 'quantity' => 1, 'amount' => $amount ) ); return base64_encode($app->asXml()); } protected function getCurrency() { $moneyIndex = $moneyName = $currencyCode = false; foreach ($this->defaults['CLAIM_COST'] as $ind => $i) { if ( $i['CurrencyAlias'] == 'KZT' || (DEBUG && $i['CurrencyAlias'] == 'RUB') ) { $currencyCode = 398; $moneyIndex = $ind; $moneyName = 'KZT'; break; } } if (false === $moneyIndex) { $this->_die(Samo_EPlatez::messages('ACQUIRING_PAYMENT_INCORRECT_CURRENCY_KKB_KZ')); } return array($moneyIndex, $moneyName, $currencyCode); } public function getPaymentInfoForKKBKZ() { $this->checkKKBKZParams(); parent::getPaymentInfo(); $routes = Samo_Registry::get('routes'); if (($email = (isset($_SESSION) && isset($_SESSION['samo_auth']['PartnerEmail1'])) ? $_SESSION['samo_auth']['PartnerEmail1'] : (isset($_SESSION['samo_auth']['PartnerEmail2']) ? $_SESSION['samo_auth']['PartnerEmail2'] : '')) && preg_match('/(.*?)@([^\s^;]+)/', $email, $m)) { $email = $m[1] . '@' . $m[2]; } list($moneyIndex, $moneyName, $currencyCode) = $this->getCurrency(); $host = Samo_Request::scheme() . '://' . Samo_Request::host(); $url = $host . str_replace($host, '', $routes['kkb_kz']['url']); $p = parse_url($url); $url .= isset($p['query']) ? '&' : '?'; $url .= 'CLAIM=' . $this->defaults['CLAIM'] . '&samo_action='; $postUrl = Samo_Request::scheme() . '://' . Samo_Request::host() . '/modules/wspay_4/kkb_kz_client.php?CLAIM=' . $this->defaults['CLAIM'] . '&status='; $this->defaults['kkb_kz'] = array( 'paid' => $this->defaults['CLAIM_COST'][$moneyIndex]['Paid'], 'amount' => $this->defaults['CLAIM_COST'][$moneyIndex]['Debt'], 'currency_public' => $moneyName, 'currency' => $moneyName, 'pay_url' => KKB_KZ_PAY_URL, 'email' => $email, 'back_link' => $url . 'RESULT&status=ok', 'failure_back_link' => $url . 'RESULT&status=fail', 'post_link' => $postUrl . 'ok', 'failure_post_link' => $postUrl . 'fail', ); return $this->defaults['kkb_kz']; } public function pay_variant($claim) { if ($this->is_module_installed('kkb_kz')) { try { $this->checkKKBKZParams(); } catch (Samo_Exception $e) { throw new Samo_Exception($e->getMessage(), 501, $e); } return true; } return false; } } 