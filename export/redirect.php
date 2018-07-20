<?php
chdir(dirname(__DIR__)); include 'properties.php'; if (!defined('FRIENDLY_URLS')) { define('FRIENDLY_URLS', isset($_SERVER['FRIENDLY_URLS']) && $_SERVER['FRIENDLY_URLS'] == 1); } $action = (isset($_GET['samo_action'])) ? $_GET['samo_action'] : 'unexpected'; ini_set('default_charset', 'utf-8'); ini_set('html_errors', 0); include _ROOT . 'includes/classes/class.samo_config.php'; include _ROOT . 'includes/db.php'; Samo_Debug_Helper::proctitle('Samo_Redirector::' . $action); Samo_Loader::register_autoload(); Samo_Registry::set('logger', Log::singleton(LOG_TYPE)); Samo_Registry::load('response', 'Samo_Response'); Samo_Registry::load('cache', 'Samo_Cache'); $response = Samo_Registry::get('response'); try { $db = db_connect(TOWNFROMINC, null); $samo = new Samo(); $code = Samo_Request::strval('code', 32, 32); if ($code) { $codeinfo = $samo->checkCodeAuth($code); if (false !== $codeinfo) { if (!headers_sent() && !isset($_SESSION)) { $cookie_path = defined('COOKIE_PATH') ? COOKIE_PATH : WWWROOT; ini_set('session.cookie_path', $cookie_path); ini_set('session.cookie_domain', COOKIE_DOMAIN); session_name(SESSION_NAME); session_start(); $target = $codeinfo['redirect_uri']; unset($codeinfo['redirect_uri']); if (isset($codeinfo['auth'])) { $_SESSION['samo_auth'] = $codeinfo['auth']; } parse_str($codeinfo['scope'], $scope); if ($scope) { if (isset($scope['ip']) && $scope['ip'] != Samo_Request::remote_addr()) { throw new Exception('Unauthorized', 401); } if (!$target) { if (isset($scope['entity'])) { $additionalParams = $scope; foreach (['inc', 'entity', 'partner', 'USER'] as $unset) { if (array_key_exists($unset, $additionalParams)) { unset($additionalParams[$unset]); } } switch (strtoupper($scope['entity'])) { case 'CLAIM': if (isset($scope['inc'])) { $vars = array_merge_recursive(['CLAIM' => $scope['inc']], $additionalParams); $target = Samo_Url::route('cl_refer', $vars); } break; case 'CLAIM_PHYS_BUYER': if (isset($scope['inc'])) { $vars = array_merge_recursive(['CLAIM' => $scope['inc']], $additionalParams); $target = Samo_Url::route('cl_refer_person', $vars); } break; case 'PARTNER': $target = Samo_Url::route('edit_agency', $additionalParams); break; case 'HOTEL': if (isset($scope['inc'])) { $vars = array_merge_recursive(['samo_action' => 'hotel', 'HOTELINC' => $scope['inc']], $additionalParams); $target = Samo_Url::route('hotels', $vars); } break; case 'CONFIRM_EMAIL_PARTPASS': $vars = array_merge_recursive(['samo_action' => 'confirm_email'], $additionalParams); $target = Samo_Url::route('profile', $vars); break; case 'CONFIRM_EMAIL_PERSON': $vars = array_merge_recursive(['samo_action' => 'confirm_email'], $additionalParams); $target = Samo_Url::route('profile_person', $vars); break; case 'REPLROUTE': $tools = Samo_Loader::load_object('Samo_Tools'); $result = $tools->create_servers_cache(); $response->respond_to('xml'); $response->output('<status>' . ($result ? '1' : '0') . '</status>'); return; break; case 'CHECK_PARTNER_INN': $token = $samo->getConfig('DaDataRuToken', 'Online'); $inn = $scope['Inc']; $dadataClient = Samo_Loader::load_object('DadataClient'); try { $dadataClient->init($inn, 'xml'); $data = $dadataClient->getByInn(); $xmlWriter = Samo_Loader::load_object('Samo_XmlWriter', 'result', $data); $response->respond_to('xml'); $response->output(mb_convert_encoding($xmlWriter->__toString(), 'windows-1251', 'utf-8')); } catch (DadataClientException $e) { $e->getError('xml'); } break; case 'HOLD_ACTION': include_once _ROOT . '/modules/wspay_4/lib.php'; $iNumber = $scope['INumber']; $action = $scope['Action']; $TransactionId = isset($scope['TransactionId']) ? $scope['TransactionId'] : null; $RubSum = isset($scope['RubSum']) ? floatval($scope['RubSum']) : null; $bank = isset($scope['BankLogin']) ? $scope['BankLogin'] : null; $result = false; $message = ''; try { if (!$bank) { $res = Samo_Acquiring::getInvoiceInfo($iNumber); $bank = $res['BankLogin']; } if (defined('SBERBANK_SAMO_LOGIN') && $bank == SBERBANK_SAMO_LOGIN) { $messages = []; include _ROOT . 'includes/messages/messages_' . Samo_Request::lang() . '.php'; include _ROOT . 'modules/sberbank/lang/messages_' . Samo_Request::lang() . '.php'; Samo_Registry::set('messages', $messages); $sb = Samo_Loader::load_object('Sberbank_Model'); $sb->holdAction($iNumber, $action, $TransactionId, $RubSum); } else { $model = Samo_Acquiring::factory($bank); if ($action == 'deposit') { $model->capture($iNumber); } else { $model->reverse($iNumber); } } $result = true; } catch (Exception $e) { if ($e instanceof Sberbank_Exception || $e instanceof Samo_Exception || $e instanceof WSPAY_exception) { $message = $e->getMessage(); } else { $message = 'Internal error'; } } $response->respond_to('xml'); $response->output('<result><status>' . ($result ? '1' : '0') . '</status><message>' . htmlspecialchars($message, ENT_XML1, 'windows-1251') . '</message></result>'); break; case 'ADMIN': $target = Samo_Url::route('admin'); include_once _ROOT . 'admin/properties.php'; $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.dbo.[up_WEB_3_ADMIN_passwordless]', array( 'USER' => $scope['USER'], 'SES' => session_id(), 'Session_time' => SESSION_TIME, ) ); $result = $db->fetchOne($sql); if ($result > 0) { $sql = $db->formatExec( OFFICE_SQLSERVER . '.' . OFFICEDB . '.[dbo].[up_WEB_3_settings_value]', [ 'Section' => 'Common', 'What' => 'Language', 'UserCode' => $scope['USER'], 'Default' => 0, ] ); $defaultLanguage = $db->fetchOne($sql); $_SESSION['samo_admin'] = array( 'Inc' => $result, 'User' => $scope['USER'], 'LNG' => (0 == $defaultLanguage) ? 'rus' : 'eng', ); } else { $_SESSION['samo_admin'] = null; } break; case 'TESTUPLOAD': if (Samo_Request::is_post() && count($_FILES) > 0) { $response->respond_to('json'); $response->output(json_encode($_FILES)); } break; default: $target = Samo_Url::route('menu'); break; } } } $_SESSION['params'] = $scope; } session_write_close(); $response->redirect_to($target); } } else { throw new Exception('Unauthorized', 401); } } } catch (Exception $e) { if (401 == $e->getCode()) { $registry = Samo_Registry::instance(); if (!isset($registry['view'])) { Samo_Registry::load('view', 'Samo_View'); } if (!isset($registry['messages'])) { include _ROOT . 'includes/messages/messages_' . Samo_Request::lang() . '.php'; Samo_Registry::set('messages', $messages); } $content = Samo_Registry::get('view')->assign('page', 'redirect')->assign('WWWROOT', WWWROOT)->fetch('unauthorized.tpl'); $response->unauthorized($content); } } $response->finish(); 