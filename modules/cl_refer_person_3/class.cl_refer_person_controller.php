<?php
 class Cl_Refer_Person_Controller extends Samo_Controller { public $model; const PAYMENT_AUTOSTART = 1; const PAYMENT_WAIT = 2; const PAYMENT_ERROR = 3; public function default_action() { $rules = $this->model->permissions(); $this->view->js_var('samo.print', $rules)->assign('rules', $rules); if ($bonus_info = $this->model->bonus_info()) { $this->view->assign('BONIS_INFO', $bonus_info); } if ($claimList = $this->model->claimList()) { $this->view->assign('claimList', $claimList); if (!$this->model->defaults['CLAIM']) { $claim = reset($claimList); $this->model->defaults['CLAIM'] = $claim['id']; $this->model->defaults['CLAIMBEG'] = $claim['id']; $this->model->defaults['CLAIMEND'] = $claim['id']; } if ($result = $this->model->getClaim()) { $accessPay = isset($_SESSION['samo_auth']['AccessPay']) ? $_SESSION['samo_auth']['AccessPay'] : 0; $freights = $this->model->claimFreights(); $result['orders'] = [ 'hotels' => $this->model->claimHotels(), 'freights' => $freights, 'services' => $this->model->claimServices(), 'insures' => $this->model->claimInsures(), 'visas' => $this->model->claimVisas(), 'peoples' => $this->model->claimPeoples(), ]; $result['cost'] = $this->model->claimCost(); $result['pay_variants'] = $accessPay ? $this->model->payVariants() : false; if ($accessPay && $result['pay_variants']) { if (($dopay = Samo_Request::intval('DOPAY')) && !in_array($result['cl_status'], ['hold', 'paid', 'partpaid', 'cancel'])) { if (self::PAYMENT_AUTOSTART == $dopay) { $this->view->js_call_onready('samo.payment_autostart'); } elseif (self::PAYMENT_WAIT == $dopay && $result['cl_status'] != 'hold') { $this->view->assign('payment_wait', true); $this->view->js_call_onready('samo.payment_wait'); } elseif (self::PAYMENT_ERROR == $dopay) { $this->view->assign('payment_error', true); } } } if (false !== ($phys_byer = $this->model->phys_byer())) { $buyer = []; foreach ($phys_byer as $group => $fields) { foreach ($fields as $field) { $buyer[$field['Field']] = $field['Value']; } } $phys_byer = $buyer; $this->view->assign('phys_byer', $phys_byer); } $contractPreview = false; if (false !== $phys_byer && $contract = $this->contractModel()) { if (false !== $contract->template()) { $contractPreview = true; } } $this->view->assign('CONTRACT', $contractPreview); $this->view ->assign('result', $result) ->assign('partpass_mode', $_SESSION['samo_auth']['mode']); $routes = Samo_Registry::get('routes'); if (isset($routes['cancel_claim']) && $_SESSION['samo_auth']['Person'] == 0) { unset($routes['cancel_claim']); Samo_Registry::set('routes', $routes); } } } parent::default_action(); } public function check_auth() { $this->auth_init(); $is_post = Samo_Request::is_post(); $is_logon = $is_post && 'logon' === Samo_Request::post('samo_action'); $response = Samo_Registry::get('response'); $KEY = Samo_Request::strval('KEY'); $oauth_client = Samo_Request::strval('oauth_client'); $login = Samo_Request::find('CLAIM'); $claim = intval($login); if ($KEY && $oauth_client) { if ($result = $this->model->checkPersonAndrAuth($KEY, $oauth_client, $claim)) { $result['trusted_referer'] = true; $_SESSION['samo_auth'] = $result; } $params = [ 'CLAIM' => $claim, ]; if ($dopay = Samo_Request::intval('DOPAY')) { $params['DOPAY'] = $dopay; } return $response->redirect_to(Samo_Url::route('cl_refer_person', $params)); } $is_js = $response->respond_to_js(); $paranoia = !$this->auth_paranoia(); if ($paranoia) { unset($_SESSION['paranoia']); $_SESSION['samo_auth'] = false; } if (!isset($_SESSION['samo_auth']) || $_SESSION['samo_auth'] == false) { if ($is_js && !$is_logon) { $this->_logon_popup_open(); } if ($is_logon) { $wordpassword = Samo_Request::post('WORDPASSWORD'); $logon_key = Samo_Request::post('logon_key'); if (!isset($_SESSION['logon_key']) or $logon_key !== $_SESSION['logon_key']) { $_SESSION['auth_error'] = $this->messages['SAMO_LOGIN_AUTH_TIMEOUT']; return $response->refresh(); } $result = $this->model->checkAuth($login, $wordpassword); if (!$result || (is_array($result) && isset($result['Partner']) && (string)$result['Partner'] === '-1')) { $_SESSION['auth_error'] = $this->messages[$claim ? 'SAMO_LOGON_ERROR_PERSON' : 'SAMO_LOGON_ERROR']; } else { if (isset($_SESSION['auth_error'])) { unset($_SESSION['auth_error']); } $_SESSION['samo_auth'] = $result; $this->model->defaults['PARTTYPE'] = $result['ParttypeName']; $this->model->defaults['OFFICIAL_NAME'] = $result['OfficialName']; } if ($is_js) { if (isset($_SESSION['auth_error'])) { $this->view->js_call('samo.logon_error', $_SESSION['auth_error']); unset($_SESSION['auth_error']); $response->output(); $response->finish(); } else { $this->_logon_popup_close(); } } else { $response->refresh(); } } else { $error = isset($_SESSION['auth_error']) ? $_SESSION['auth_error'] : false; $this->logon_key(); $this->view->assignif('flash', true, $error) ->assign('flash_message', $error) ->module(false)->render('login_person'); if ($error) { unset($_SESSION['auth_error']); } $response->output(); $response->finish(); } } else { if ($is_logon) { $response->refresh(); } elseif ($paranoia && !$is_js) { $this->LOGOUT(); } if ($_SESSION['samo_auth']['type'] == 'phys_byer' && isset($_GET['CLAIM']) && isset($_SESSION['samo_auth']['CLAIM']) && $_SESSION['samo_auth']['CLAIM'] == $_GET['CLAIM']) { if (false !== ($_SESSION['samo_auth'] = $this->model->checkAuth($_SESSION['samo_auth']['CLAIM'], $_SESSION['samo_auth']['PNUMBER']))) { unset($_SESSION['samo_auth']['CLAIM']); } } if (($_SESSION['samo_auth'] !== false)) { $this->unread_msg(); } $this->view->assign('logged', $_SESSION['samo_auth'] !== false) ->assign('LOGIN_AGENCY_OFFICIAL_NAME', $_SESSION['samo_auth']['OfficialName']) ->assign('LOGIN_OFFICIAL_NAME', (isset($_SESSION['samo_auth']['PartPassName']) && strlen(trim($_SESSION['samo_auth']['PartPassName']))) ? $_SESSION['samo_auth']['PartPassName'] : '') ->assign('LOGIN_AGENCY_PARTNER_TYPE', $_SESSION['samo_auth']['ParttypeName']); } return ($_SESSION['samo_auth'] !== false) ? $_SESSION['samo_auth']['type'] : false; } private function _logon_popup_open($antibot = false) { $view = $this->view->module(false); $this->logon_key(); $view->popup_template('login_form_person.tpl', $this->messages['SAMO_AUTH_REQUIRED'], $antibot ? 220 : 400, 180, true, 'logon') ->js_call('samo.logon_box'); if (Samo_Request::is_post()) { $_SESSION['orig_POST'] = $_POST; if ($_post = Samo_Registry::get('_POST')) { $_SESSION['unmodified_POST'] = $_post; } } } public function CLAIM_CONFIRM_PREORDER() { $result = $this->model->phys_byer(true); $result->load($_SESSION['samo_auth']['PhysBuyerInc']); try { $result->self_test(); $this->view->js_call('samo.claim_confirm_order'); } catch (Samo_Buyer_Exception $e) { $this->view->js_var('preorderEvent', 1); $this->phys_byer(); } } public function phys_byer() { if (false !== ($result = $this->model->phys_byer())) { $this->view->assign('BUYER', $result) ->assign('CLAIM', Samo_Utils::ifs($this->model->defaults['CLAIM'], Samo_Request::intval('CLAIM'))) ->popup_template('phys_byer.tpl', $this->messages['BUYER_EDIT_TITLE'], 480, 240) ->js_call('samo.phys_byer'); } } public function phys_byer_edit() { try { $collection = Samo_Request::post('frm'); if (is_array($collection)) { foreach ($collection as $data) { foreach ($data as $inc => $params) { if ($inc == $_SESSION['samo_auth']['PhysBuyerInc']) { $this->model->phys_byer_edit($params); } } } } $this->view->popup_close(); if (false !== ($phys_byer = $this->model->phys_byer())) { $buyer = []; foreach ($phys_byer as $group => $fields) { foreach ($fields as $field) { $buyer[$field['Field']] = $field['Value']; } } $this->view ->element_text('#cl_refer .tbl_phys_byer .fio', $buyer['NAME']) ->element_text('#cl_refer .tbl_phys_byer .email', $buyer['EMAIL']) ->element_text('#cl_refer .tbl_phys_byer .mobile', $buyer['MOBILE']) ->assign('LOGIN_AGENCY_OFFICIAL_NAME', $buyer['NAME']) ->assign('LOGIN_AGENCY_PARTNER_TYPE', $_SESSION['samo_auth']['ParttypeName']) ->assign('control', 'logout') ->element_update('#div_logout', '../controls.tpl'); } } catch (Samo_Buyer_Exception $e) { $errors = $e->getErrors(); foreach ($errors as $error => $fields) { foreach ($fields as $field) { $this->view->js_call('samo.field.error', $error, '[name*="' . $field['FormField'] . '"]'); } } Samo_Registry::get('response')->output(); } catch (Samo_Exception $e) { $this->view->error($e->getMessage()); } } private function contractModel() { $agreement = Samo_Loader::load_object('Agreement_Person'); $agreement->claim($this->model->defaults['CLAIM']); return $agreement; } public function contract() { $agreement = $this->contractModel(); if (false !== ($res = $agreement->getExternalDocument())) { $this->view->js_call('samo.download_result', array_merge($res, array('label' => $this->messages['CL_R_P_AGREEMENT_DOWNLOAD']))); } return $res; } public function keepalive() { $this->auth_init(); Samo_Registry::get('response')->finish(); } public function samo_action() { if (Samo_Request::get('proxy_action') || Samo_Request::get('target')) { $_GET['proxy_action'] = $_GET['samo_action']; $_GET['samo_action'] = 'proxy_action'; return $this->proxy_action(); } Samo_Registry::get('response')->not_found(); } public function proxy_action() { if ($target = Samo_Request::get('target')) { $routes = Samo_Registry::get('routes'); if (isset($routes[$target])) { $module = $routes[$target]; if (isset($module['uses']) && is_array($module['uses']) && in_array('cl_refer_person', $module['uses'])) { $action = $_GET['samo_action'] = (isset($_GET['proxy_action'])) ? $_GET['proxy_action'] : 'default_action'; $this->model->fixRoutes(); Samo_Registry::set('module', $module); Samo_Loader::load_object(ucwords($module['controller'], '_')); if (method_exists(Samo_Registry::get('controller'), $action)) { call_user_func(array(Samo_Registry::get('controller'), $action)); } elseif (method_exists(Samo_Registry::get('controller'), 'samo_action')) { call_user_func_array(array(Samo_Registry::get('controller'), 'samo_action'), array($action)); } return true; } } } Samo_Registry::get('response')->not_found(); } protected function unread_msg($update = false) { if (!isset($_SESSION['unread_msg'])) { $_SESSION['unread_msg'] = array('total' => 0, 'urgent' => 0, 'time' => 0); } if (isset($_SESSION['samo_auth']['Person']) && 1 == $_SESSION['samo_auth']['Person'] && isset($_SESSION['samo_auth']['ClaimList'])) { $routes = Samo_Registry::get('routes'); if (isset($routes['messages_person'])) { $atime = Samo_Request::time(); if ($update || ($_SESSION['unread_msg']['time'] + 60 < $atime)) { $messages = Samo_Loader::load_object('Messages_Person_Model'); $current = $messages->unreadCount(); $_SESSION['unread_msg'] = [ 'time' => $atime, 'total' => $current['total'], 'urgent' => $current['urgent'], ]; } $urgent = $_SESSION['unread_msg']['urgent']; $this->view->js_call_onready('samo.unread_messages', $_SESSION['unread_msg']['total'], $urgent); } } return $_SESSION['unread_msg']['total']; } } 