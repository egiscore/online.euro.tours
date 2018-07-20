<?php
 class Samo_Controller { protected $view = null; public $model = null; protected $actions = array(); protected $embeddable = true; protected $embed_date_fields = array('CHECKIN', 'CHECKIN_BEG', 'CHECKIN_END'); protected $is_embedable = false; protected $allow_js = true; protected $persistent = array(); protected $messages = array(); protected $callback_params = array(); protected $warn_unavailable_direction = false; protected $empty_form = false; public $action = null; public function __construct() { $this->action = $action = ($tmp = Samo_Request::get('samo_action')) ? $tmp : 'default_action'; if (!preg_match('~^[a-z][0-9a-z]*(_?[0-9a-z]*)+$~i', $action)) { Samo_Registry::get('response')->not_found(); } Samo_Registry::set('controller', $this); if ($action != 'LOGOUT') { $this->view = Samo_Registry::get('view'); $module = Samo_Registry::get('module'); $this->view->module($module['module']) ->assign('APP_HTTP_HOST', Samo_Request::scheme() . '://' . Samo_Request::host()); $this->load_messages($module); if (Samo_Registry::get('response')->respond_to_js() && $action != 'embed') { if (!Samo_Request::check_csrf_token()) { @touch(SMARTY_COMPILE_DIR . 'csrf_' . $module['module'] . '_' . $action); } } else { $this->view->assign('csrf_token', Samo_Request::csrf_token()); } $this->model = Samo_Loader::load_object(ucwords($module['model'], '_')); $this->persistent = array('TOWNFROMINC'); if (function_exists('samo_auth_hook')) { call_user_func('samo_auth_hook'); } if (isset($module['url']) && $this->allow_js()) { $this->view->js_var('samo.ROOT_URL', $module['url']); } $this->model->action = $action; $types = $this->model->auth_required(); if (!$types && isset($module['auth']) && is_array($module['auth'])) { $types = $module['auth']; } if (($types) && ($current_type = $this->check_auth())) { if (!in_array($current_type, $types)) { $_SESSION['samo_auth'] = false; $this->view->clear_assign('logged'); if (!$this->check_auth()) { throw new Samo_Exception($this->messages['SAMO_AUTH_REQUIRED'], 401); } } } if ((isset($module['antibot']) && $module['antibot'] == true) || (Samo_Request::is_post() && 'antibot' == Samo_Request::post('samo_action'))) { $this->embeddable = false; $this->check_antibot(); } if (!$types && $this->embeddable) { if (is_string($this->embeddable)) { $this->embeddable = array($this->embeddable); } if (is_array($this->embeddable) && !in_array($this->model->action, array('default_action')) && Samo_Request::get('samo_action') != 'embed') { $this->is_embedable = in_array($this->model->action, $this->embeddable); if ($this->is_embedable && method_exists($this, $this->model->action)) { $_GET['embed_action'] = $this->model->action; } } else { $this->is_embedable = true; } } else { $this->is_embedable = false; } if (Samo_Request::get('is_js')) { $this->view->full_paths(true); } if ($this->is_embedable() && Samo_Request::get('samo_action') == 'embed') { $this->view->full_paths(true); Samo_Registry::set('embeded', Samo_Request::scheme() . '://' . Samo_Request::host()); } $this->model->calc_stats(); $this->model->construct(); $this->construct(); } } protected function allow_js() { return $this->allow_js; } protected function load_messages($module) { $messages = Samo_Registry::get('messages'); if (isset($module['path']) && file_exists($module['path'] . '/lang/messages_' . Samo_Request::lang() . '.php')) { include $module['path'] . '/lang/messages_' . Samo_Request::lang() . '.php'; $this->messages = $messages; Samo_Registry::set('messages', $this->messages); } else { $this->messages = Samo_Registry::get('messages'); } } public function is_embedable() { return $this->is_embedable; } public function warn_unavailable_direction($warn = null) { if (null !== $warn) { $this->warn_unavailable_direction = (bool)$warn; } if ($this->warn_unavailable_direction) { $this->persistent = array(); $cookie_path = defined('COOKIE_PATH') ? COOKIE_PATH : WWWROOT; $response = Samo_Registry::get('response'); $response->save_pref('pSTATEINC', null, $cookie_path); $response->save_pref('pTOWNFROMINC', null, $cookie_path); $this->view->js_call_onready($this->view->jquery_object() . '.modal', $this->messages['SERVER_NOT_AVAILABLE'], ''); } return $this->warn_unavailable_direction; } public function empty_form($empty = null) { if (null !== $empty) { $this->empty_form = (bool)$empty; } if ($this->empty_form) { return $this->default_action(); } } public function before_output() { if ($this->is_embedable()) { $module = Samo_Registry::get('module'); if (Samo_Request::get('samo_action') == 'embed') { $this->view->js_var('samo.' . $module['module'] . '_embedable', uniqid('embed')); $this->view->js_var('samo.location', $this->model->link_to_page()); } elseif (!Samo_Request::find('embed')) { if ($link_to_page = $this->model->link_to_page()) { $embed = null; $mini_modules = ['currency', 'fast_search', 'check_confirm', 'popular_hotel', 'fast_search_person']; $auth_modules = ['edit_agency', 'register_agency', 'claim_act', 'cl_refer_person', 'agreement', 'warrant', 'cl_wizard', 'registration', 'cl_refer']; if (!$module['public']) { $auth_modules[] = $module['module']; } if ($url = parse_url($link_to_page)) { if (!empty($url['query'])) { parse_str($url['query'], $query); if (!empty($query['samo_action'])) { $query['embed_action'] = $query['samo_action']; } foreach ($query as $key => $val) { if (in_array($key, $this->embed_date_fields)) { $val = Samo_Datetime::parse($val)->diff(); unset($query[$key]); if ('CHECKIN_END' == $key) { $key = 'MAXPERIOD'; $val = isset($query['MINDAYSBEFORE']) ? $val - $query['MINDAYSBEFORE'] : $val; } else { $key = 'MINDAYSBEFORE'; } $query[$key] = $val; } if (!$val) { unset($query[$key]); } } } $query['samo_action'] = 'embed'; $url['query'] = http_build_query($query); $embed = !in_array($module['module'], $auth_modules) ? Samo_Url::build_url($url) : null; } if (!in_array($module['module'], $mini_modules)) { if (Samo_Request::is_admin()) { $this->view->assign('link_to_page', $link_to_page)->js_call_if_exists('samo.link_to_page', $link_to_page, $embed); } else { $this->view->assign('link_to_page', $link_to_page)->js_call_if_exists('samo.link_to_page', $link_to_page); } } } } } $response = Samo_Registry::get('response'); if ($this->allow_js()) { $request_version = Samo_Request::get('rev'); if ($request_version && $this->action != 'default_action') { if (!$revision = Samo_Registry::get('cache')->get('ASSETS_VERSION')) { $revision = Samo_Utils::assets_revision(); } if ($request_version != $revision) { $this->view->message($this->messages['RELOAD_PAGE'], 'error', true); } } $module = Samo_Registry::get('module'); if (!isset($this->callback_params['TOWNFROMINC'])) { $this->callback_params['TOWNFROMINC'] = $this->model->townFrom(); } if (!isset($this->callback_params['STATEINC'])) { $this->callback_params['STATEINC'] = $this->model->state(); } $callback_action = $this->action == 'embed' ? (($embed_action = Samo_Request::find('embed_action')) ? $embed_action : 'embed') : $this->action; $method = $this->action == 'default_action' || $this->action == 'embed' && $callback_action == 'embed' ? 'js_call_onready' : 'js_call_if_exists'; call_user_func_array([$this->view, $method], ['samo.page_callback', $module['module'], $callback_action, $this->callback_params]); if (Samo_Request::get('embed_external') && ($embed = Samo_Request::find('embed'))) { $response = Samo_Registry::get('response'); $buffer = $response->_buffer(); $response->_buffer(''); $this->view->js_var('samo.external_' . $embed, $buffer); } } $cookie_path = defined('COOKIE_PATH') ? COOKIE_PATH : WWWROOT; $response->save_pref('pLANG', Samo_Request::lang(), $cookie_path); if ($this->model) { foreach ($this->persistent as $control) { $value = $this->model->defaults($control); if (!($control == 'TOWNFROMINC' && $value == Samo::TOWNFROMHOTELINC)) { $response->save_pref('p' . $control, $value, $cookie_path); } } } } public function after_output() { } protected function construct() { } protected function default_app_env() { if ($this->allow_js) { $format = (defined('DEFAULT_DATE_FORMAT')) ? DEFAULT_DATE_FORMAT : '%d.%m.%Y'; $jsDateFormat = str_replace(array('%d', '%m', '%y', '%Y'), array('dd', 'mm', 'yyyy', 'yyyy'), $format); $jsDateMask = str_replace(array('dd', 'mm', 'yyyy'), array('39', '19', '2099'), $jsDateFormat); $routes = Samo_Registry::get('routes'); $module = Samo_Registry::get('module'); $jsRoutes = array('WWWROOT' => WWWROOT); foreach ($routes as $mod => $params) { if ($mod == $module['module'] || $params['public'] == true || (isset($params['uses']) && ((is_string($params['uses']) && strlen($params['uses']) && $params['uses'] == $module['module'])) || (isset($params['uses']) && is_array($params['uses']) && in_array($module['module'], $params['uses'])) || (isset($params['uses']) && $params['uses'] === '*'))) { $jsRoutes[$mod]['url'] = $params['url']; $jsRoutes[$mod]['title'] = $params['title']; $jsRoutes[$mod]['public'] = $params['public']; } } $ROOT_URL = $jsRoutes[$module['module']]['url']; $this->view ->js_var('samo.dateFormat', $jsDateFormat, false) ->js_var('samo.dateMask', $jsDateMask, false) ->js_var('samo.MODULE', $module['module']) ->js_var('samo.ROUTES', $jsRoutes, 2) ->js_var('samo.PROGRESS_TIMEOUT', intval(ini_get('max_execution_time'))) ->assign('ROOT_URL', $ROOT_URL); unset($jsRoutes['WWWROOT']); $this->view->assign('routes', $jsRoutes); } } public function default_action() { $this->default_app_env(); $this->view->render('layout'); } public function LOGOUT() { $this->auth_init(); $_SESSION['samo_auth'] = false; session_write_close(); Samo_Registry::get('response')->refresh(); } public function menu() { $this->view->render('menu'); } public function embed() { if ($this->is_embedable()) { $this->view->full_paths(true); Samo_Registry::get('response')->respond_to('js'); $action = 'default_action'; if (!Samo_Request::bitval('is_js')) { $this->view->document_write(true); } if ($a = Samo_Request::find('embed_action')) { if (method_exists($this, $a)) { $action = $a; } elseif (method_exists($this, 'samo_action')) { return $this->samo_action($a); } } $this->$action(); } } public function init_data() { if (isset($this->actions['INIT'])) { $res = array(); $model = $this->model; foreach ($this->actions['INIT'] as $control) { $res[$control] = $model->loadData($control); } if (count($res)) { $this->view->bulk_assign($res); } } } public function auth_init($session_name = SESSION_NAME) { if (!headers_sent() && !isset($_SESSION)) { $cookie_path = defined('COOKIE_PATH') ? COOKIE_PATH : WWWROOT; ini_set('session.cookie_path', $cookie_path); ini_set('session.cookie_domain', COOKIE_DOMAIN); session_name($session_name); session_start(); } } public function check_antibot() { if ($this->action == 'embed' && !Samo_Request::find('DOLOAD') && !Samo_Request::find('embed_action')) { $result = true; } else { $this->auth_init(); $time = Samo_Request::time(); $ip = Samo_Request::remote_addr(); $ua = Samo_Request::user_agent(); $antibot_expire = (defined('ANTIBOT_EXPIRE')) ? ANTIBOT_EXPIRE : 1800; if (isset($_SESSION['antibot']) && $_SESSION['antibot']) { $is_ok = $_SESSION['antibot_ctime'] + $antibot_expire > $time; $is_ok = $is_ok && $_SESSION['antibot_ip'] == $ip; $is_ok = $is_ok && $_SESSION['antibot_ua'] == $ua; if (!$is_ok) { unset($_SESSION['antibot']); } } $result = isset($_SESSION['antibot']) && $_SESSION['antibot'] === true; } if (!$result) { $response = Samo_Registry::get('response'); $is_js = $response->respond_to_js(); $is_logon = Samo_Request::find('antibot'); if (!isset($_SESSION['antibot']) || $_SESSION['antibot'] == false) { if ($is_js && !$is_logon) { $this->_logon_popup_open(true); } if ($is_logon) { if (!isset($_SESSION['captcha_keystring']) or empty($_SESSION['captcha_keystring']) or $is_logon !== $_SESSION['captcha_keystring'] ) { $_SESSION['auth_error'] = $this->messages['INCORRECT_CAPTCHA']; } else { $result = true; $_SESSION['antibot'] = true; $_SESSION['antibot_ctime'] = $time; $_SESSION['antibot_ip'] = $ip; $_SESSION['antibot_ua'] = $ua; if (isset($_SESSION['auth_error'])) { unset($_SESSION['auth_error']); } } unset($_SESSION['captcha_keystring']); if ($is_js) { if (isset($_SESSION['auth_error'])) { $this->view->js_call('samo.logon_error', $_SESSION['auth_error']); unset($_SESSION['auth_error']); $response->output(); $response->finish(); } else { $this->_logon_popup_close(); } } else { $response->refresh(); } } else { $error = isset($_SESSION['auth_error']) ? $_SESSION['auth_error'] : false; $this->view->assignif('flash', true, $error) ->assign('flash_message', $error) ->assign('page_title', isset($this->messages['PAGE_TITLE']) ? $this->messages['PAGE_TITLE'] : false) ->assign('antibot', true) ->assign('SESSION', array('NAME' => SESSION_NAME, 'ID' => session_id())) ->module(false) ->render('login'); if ($error) { unset($_SESSION['auth_error']); } $response->output(); $response->finish(); } } else { $result = true; } } return $result; } private function _logon_popup_open($antibot = false) { $view = $this->view->module(false); if ($antibot) { $view->assign('antibot', $antibot) ->assign('SESSION', array('NAME' => SESSION_NAME, 'ID' => session_id())); } $this->logon_key(); if ('embed' == $this->action) { $view->full_paths(true)->render('common'); } $view->assign('popup_login', true); $view->popup_template('login_form.tpl', $this->messages['SAMO_AUTH_REQUIRED'], $antibot ? 220 : 380, 180, true, 'logon') ->js_call('samo.logon_box'); if (Samo_Request::is_post()) { $_SESSION['orig_POST'] = $_POST; if ($_post = Samo_Registry::get('_POST')) { $_SESSION['unmodified_POST'] = $_post; } if (isset($_FILES) && count($_FILES)) { $files = array(); foreach ($_FILES as $field => $file) { if (is_uploaded_file($file['tmp_name'])) { $file['md5sum'] = md5_file($file['tmp_name']); if (move_uploaded_file($file['tmp_name'], _ROOT . 'dnl/' . basename($file['tmp_name']))) { $file['tmp_name'] = _ROOT . 'dnl/' . basename($file['tmp_name']); $files[$field] = $file; } } } $_SESSION['orig_FILES'] = $files; } } } protected function _logon_popup_close() { $this->view->popup_close('logon'); if (isset($_SESSION['orig_POST'])) { $_POST = $_SESSION['orig_POST']; unset($_SESSION['orig_POST']); $_SERVER['REQUEST_METHOD'] = 'POST'; } if (isset($_SESSION['orig_FILES'])) { $_FILES = $_SESSION['orig_FILES']; unset($_SESSION['orig_FILES']); } if (isset($_SESSION['unmodified_POST'])) { Samo_Registry::set('_POST', $_SESSION['unmodified_POST']); unset($_SESSION['unmodified_POST']); } return true; } protected function logon_key() { $sid = md5(Samo_Request::remote_addr() . Samo_Request::time() . Samo_Request::user_agent()); $_SESSION['logon_key'] = $sid; $this->view->assign('logon_key', $sid); return true; } public function check_auth() { $this->auth_init(); if (isset($_SESSION['antibot']) && false === $_SESSION['antibot']) { return $this->check_antibot(); } $is_post = Samo_Request::is_post(); $is_logon = $is_post && 'logon' === Samo_Request::post('samo_action'); $response = Samo_Registry::get('response'); $KEY = Samo_Request::strval('KEY'); $oauth_client = Samo_Request::strval('oauth_client'); if ($KEY && $oauth_client) { if ($result = $this->model->checkAgencyAndrAuth($KEY, $oauth_client)) { $result['trusted_referer'] = true; $_SESSION['samo_auth'] = $result; } return $response->redirect_to(Samo_Url::route('cl_refer', array('CLAIM' => Samo_Utils::ifs(Samo_Request::intval('CLAIM'), 0)))); } $is_js = $response->respond_to_js(); $paranoia = !$this->auth_paranoia(); if ($paranoia) { unset($_SESSION['paranoia']); $_SESSION['samo_auth'] = false; } if (!isset($_SESSION['samo_auth']) || $_SESSION['samo_auth'] == false) { if ($is_js && !$is_logon) { $this->_logon_popup_open(); } if ($is_logon) { $login = Samo_Request::post('login'); $password = Samo_Request::post('passwd'); $logon_key = Samo_Request::post('logon_key'); if (!isset($_SESSION['logon_key']) or $logon_key !== $_SESSION['logon_key']) { $_SESSION['auth_error'] = $this->messages['SAMO_LOGIN_AUTH_TIMEOUT']; return $response->refresh(); } try { $result = $this->model->checkAuth($login, $password); } catch (TooManyLoginFailures $e) { $_SESSION['antibot'] = false; return $this->check_antibot(); } if (false !== $result) { if (isset($_SESSION['auth_error'])) { unset($_SESSION['auth_error']); } $_SESSION['samo_auth'] = $result; if (isset($result['LoginFailures']) && $result['LoginFailures'] >= 2) { $_SESSION['antibot'] = false; return $this->check_antibot(); } } else { $_SESSION['auth_error'] = $this->messages['SAMO_LOGON_ERROR']; } if ($is_js) { if (isset($_SESSION['auth_error'])) { $this->view->js_call('samo.logon_error', $_SESSION['auth_error']); unset($_SESSION['auth_error']); $response->output(); $response->finish(); } else { $this->_logon_popup_close(); } } else { $response->refresh(); } } else { $error = isset($_SESSION['auth_error']) ? $_SESSION['auth_error'] : false; $this->logon_key(); $this->view->assignif('flash', true, $error) ->assign('flash_message', $error) ->assign('page_title', isset($this->messages['PAGE_TITLE']) ? $this->messages['PAGE_TITLE'] : false) ->module(false)->render('login'); if ($error) { unset($_SESSION['auth_error']); } $response->output(); $response->finish(); } } else { if ($is_logon) { $response->refresh(); } elseif ($paranoia && !$is_js) { $this->LOGOUT(); } if (($_SESSION['samo_auth'] !== false && $_SESSION['samo_auth']['type'] == 'agency')) { if (isset($_SESSION['samo_auth']['agreement']) && !$_SESSION['samo_auth']['agreement'] && get_class($this) != 'Profile_Controller') { $_SESSION['return_url'] = samo_request::uri(); return $response->redirect_to(Samo_Url::route('profile', array('samo_action' => 'PARTNER_AGREEMENT'))); } $this->unread_msg(); } $this->view->assign('logged', true) ->assign('LOGIN_AGENCY_OFFICIAL_NAME', $_SESSION['samo_auth']['OfficialName']) ->assign('LOGIN_OFFICIAL_NAME', (isset($_SESSION['samo_auth']['PartPassName']) && strlen(trim($_SESSION['samo_auth']['PartPassName']))) ? $_SESSION['samo_auth']['PartPassName'] : '') ->assign('LOGIN_AGENCY_PARTNER_TYPE', (Samo_Request::lang() == 'rus' ? $_SESSION['samo_auth']['ParttypeName'] : '')); } return (isset($_SESSION['samo_auth']) && $_SESSION['samo_auth'] !== false) ? $_SESSION['samo_auth']['type'] : false; } protected function unread_msg($update = false) { if ($this->allow_js()) { if (!isset($_SESSION['unread_msg'])) { $_SESSION['unread_msg'] = array('total' => 0, 'urgent' => 0, 'time' => 0); } $routes = Samo_Registry::get('routes'); if (isset($routes['messages'])) { $atime = Samo_Request::time(); if ($update || ($_SESSION['unread_msg']['time'] + 60 < $atime)) { $model = isset($_SESSION['samo_auth']['Person']) && 1 == $_SESSION['samo_auth']['Person'] ? 'Messages_Person_Model' : 'Messages_Model'; $messages = Samo_Loader::load_object($model); $current = $messages->unreadCount(); $_SESSION['unread_msg'] = [ 'time' => $atime, 'total' => $current['total'], 'urgent' => $current['urgent'], ]; } $urgent = $_SESSION['unread_msg']['urgent']; $this->view->js_call_onready('samo.unread_messages', $_SESSION['unread_msg']['total'], $urgent); } return $_SESSION['unread_msg']['total']; } } protected function allow_dynamic_ip() { return (defined('SECURITY_CHECK_DYNAMIC_IP') && SECURITY_CHECK_DYNAMIC_IP); } protected function auth_paranoia() { $is_ok = true; $remote_addr = Samo_Request::remote_addr(); $atime = Samo_Request::time(); $project = (defined('CUSTOM')) ? CUSTOM . intval(defined('CUSTOM_DB') && CUSTOM_DB) : _ROOT; if (!isset($_SESSION['paranoia'])) { $_SESSION['paranoia'] = array('ip' => $remote_addr, 'atime' => $atime, 'project' => $project); if ($ua = Samo_Request::user_agent()) { $_SESSION['paranoia']['ua'] = $ua; } return true; } else { $is_ok = ($is_ok && ($this->allow_dynamic_ip() || $_SESSION['paranoia']['ip'] === $remote_addr)); $is_ok = ($is_ok && isset($_SESSION['paranoia']['ua']) && $_SESSION['paranoia']['ua'] === Samo_Request::user_agent()); $is_ok = ($is_ok && isset($_SESSION['paranoia']['project']) && $_SESSION['paranoia']['project'] === $project); } $trusted_referer = isset($_SESSION['samo_auth']) && isset($_SESSION['samo_auth']['trusted_referer']) && $_SESSION['samo_auth']['trusted_referer']; if (SECURITY_CHECK_REFERER && $is_ok && ($r = Samo_Request::referer()) && !$trusted_referer) { $rhost = strtolower(Samo_Url::host($r)); if ($rhost !== strtolower(Samo_Request::host())) { $is_ok = false; } } if ($is_ok && ($atime - $_SESSION['paranoia']['atime']) > 1000) { session_regenerate_id(); } $_SESSION['paranoia']['atime'] = $atime; return $is_ok; } public function claim_description() { if ($info = $this->model->claim_description()) { $this->view->bulk_assign($info) ->popup_template('../claiminfo.tpl', $this->messages['CLAIM_INFO'], 700, 180); } } public function sta_action_disable() { Samo_Registry::get('response')->save_pref('_sta_action', 0); $this->view->element_remove('#sta-action-terms')->element_remove('#sta-action-congratulations'); } public function PDF_SAMOTOUR() { $res = $this->model->getExternalDocument(); $this->view->js_call('samo.download_result', array_merge($res, array('label' => ''))); return $res; } } 