<?php
 class Openbank_Model extends Samo_Acquiring { public function __construct() { $inc = $this->acquiringConfig('OPENBANK_SAMO_INC'); $login = $this->acquiringConfig('OPENBANK_SAMO_ALIAS'); if ($inc && $login) { parent::__construct(); $this->bankInc = $inc; $this->bankAlias = $login; } else { if ($this->is_module_installed('openbank')) { throw new Samo_Exception(get_called_class() . ' was not configured', 501); } } } public function makeFormData() { $invoice = $this->getInvoice(); $inumber = $invoice['inumber']; $res = $this->doRequest('register', ['orderNumber' => $inumber, 'amount' => ceil($this->_amount * 100), 'currency' => static::acquiringConfig('OPENBANK_CURRENCY'), 'returnUrl' => $this->getReturnURL()]); $this->saveCurrentTransactionId(str_replace('-', '', $res['orderId'])); $this->createCheckOrderStatusJob('return '.get_class($this).'::processOrderStatus(\'' . $inumber . '\', \'' . $res['orderId'] . '\');'); return $res['formUrl']; } public static function processOrderStatus($inumber, $transaction) { $res = static::doRequest('getOrderStatus', ['orderId' => $transaction]); if ($res['OrderNumber'] != $inumber) { throw new Samo_Exception('Invalid INumber'); } switch ((int)$res['OrderStatus']) { case 2: static::confirmOrder(static::acquiringConfig('OPENBANK_SAMO_ALIAS'), $inumber); return true; break; case 3: case 4: case 6: return true; break; case 1: static::setHoldInvoiceByINumber(static::acquiringConfig('OPENBANK_SAMO_ALIAS'), $inumber); return true; break; case 0: case 5: default: return false; break; } } protected static function doRequest($action, $params) { $service_url = static::acquiringConfig('OPENBANK_SERVICE_URL'); if (empty($params['userName'])) { $params['userName'] = static::acquiringConfig('OPENBANK_LOGIN'); } if (empty($params['password'])) { $params['password'] = static::acquiringConfig('OPENBANK_PASSWORD'); } $res = Samo_Curl::request($service_url.$action.'.do', $params); $res = json_decode($res, true); if (!$res) { throw new Samo_Exception(); } if (!empty($res['errorCode'])) { throw new Samo_Exception(Samo_String::set($res['errorMessage'], 'utf-8')->ansi()); } return $res; } public static function parseCallbackNotify($data) { $status = -100; $summa = 0; $act = isset($data['uact']) ? $data['uact'] : ''; if ($act == 'get_info' || $act == 'payment') { $user = isset($data['duser']) ? $data['duser'] : ''; $pass = isset($data['dpass']) ? $data['dpass'] : ''; if (!$user || !$pass) { if (isset($_SERVER['PHP_AUTH_USER'])) { $user = trim($_SERVER['PHP_AUTH_USER']); $pass = trim($_SERVER['PHP_AUTH_PW']); } if (!$user || !$pass) { header("WWW-Authenticate: Basic realm=\"OpenBank Login\""); header("HTTP/1.0 401 Unauthorized"); echo '<html><body><h1>Rejected!</h1><big>Wrong Username or Password!</big><br/>&nbsp;<br/>&nbsp;</body></html>'; exit; } } $ba = static::acquiringConfig('OPENBANK_SAMO_ALIAS'); $model = static::_getModel($ba); $bank = $model->getBank($ba); if ($user == $bank['Login'] && $pass == $bank['Psw']) { $claim = isset($data['cid']) ? $data['cid'] : ''; if ($claim) { try { $info = $model->getClaim($claim); $summa = (float)$info['PayDebt']; if ($act == 'get_info') { $status = 0; } else if ($act == 'payment') { $sum = isset($data['sum']) ? (float)$data['sum'] : 0; if ($sum > 0 && $sum <= $summa) { $tr = isset($data['trans']) ? $data['trans'] : null; $model->payClaim($claim, null, $sum, $tr, null, null); $status = 0; } else { $status = -3; } } else { $status = -4; } } catch (WSPAY_exception $e) { if ($e->getCode() == WSPAY_model::CLAIM_CANNOT_PAY) { $status = -1; } else { $status = -100; } } } else { $status = -1; } } } else { $status = -4; } return http_build_query(['status' => $status, 'summa' => $summa]); } } 