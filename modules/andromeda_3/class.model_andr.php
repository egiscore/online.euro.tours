<?php
 class model_andr { public $version = 5; public $lng = 'rus'; protected $_cache = null; public $_db = null; protected $_form = 'andr'; protected $_config = null; protected $_errors = array(); protected $_variables = array(); protected $_user = array( 'ClientId' => null, 'Title' => null, 'Alias' => 'ANDR', ); protected $log_priority = 'andromeda'; protected $claimcost_rate_type = 2; protected $claimcost_currtype = 'PayCurr'; protected $claimcost_datetype = ''; protected $claimcost_rate_date = 'null'; protected $online_modules = null; protected $internet_user = null; public function __construct($TOWNFROM = null, $USER = null, $STATE = null) { if ($TOWNFROM === false) { $TOWNFROM = null; } if ($STATE === false) { $STATE = null; } $this->setVar('TOWNFROM', $TOWNFROM); $this->setVar('STATE', $STATE); if (method_exists($this, '_construct')) { $this->_construct(); } $this->_user($USER); $this->_cache = Samo_Registry::find('cache') ? Samo_Registry::get('cache') : Samo_Registry::load('cache', 'Samo_Cache'); $this->_db = connect_db($TOWNFROM, $STATE); $this->_config = Samo_Config::factory(); if (defined('CLAIMCOST_DATETYPE')) { $this->claimcost_datetype = CLAIMCOST_DATETYPE; } return $this; } public function setVar($varName, $varValue = null) { if (is_array($varName)) { foreach ($varName as $name => $value) { $this->setVar($name, $value); } } else { $varValue = $this->preprocVar($varName, $varValue); $this->_variables[$varName] = $varValue; } return true; } public function preprocVar($varName, $varValue) { switch ($varName) { case 'peoples': foreach ($varValue as $key => $row) { if (!isset($row['MALE'])) { if (isset($row['HUMAN'])) { if ($row['HUMAN'] == 'MR') { $row['MALE'] = 1; } elseif ($row['HUMAN'] == 'MRS') { $row['MALE'] = 0; } } } if (!isset($row['MALE'])) { if (!isset($row['SEX']) || ($row['SEX'] == 'MALE') || (strval($row['SEX']) == '1')) { $row['MALE'] = 1; } else { $row['MALE'] = 0; } } $defaults = array( 'VEXPIRE' => '20350101', 'PLACEBORNDETAIL' => Samo_People::BLANK, 'INN' => Samo_People::BLANK, ); foreach ($defaults as $field => $value) { if (!isset($row[$field]) || !$row[$field]) { $row[$field] = $value; } } $varValue[$key] = $row; } break; default: break; } return $varValue; } public function issetVar($varName) { return array_key_exists($varName, $this->_variables); } public function getVar($varName) { if (true === $this->issetVar($varName)) { return $this->_variables[$varName]; } else { return null; } } public function unsetVar($varName) { if (true === $this->issetVar($varName)) { $return = $this->_variables[$varName]; unset($this->_variables[$varName]); return $return; } else { return null; } } public function raiseError($code = 0, $message = '', $options = array()) { throw new Andr_Exception($code, $message); } public function popError() { if (count($this->_errors) > 0) { return array_pop($this->_errors); } return false; } public function getErrors() { if (count($this->_errors) > 0) { return $this->_errors; } return false; } public function getConfig($what = false, $section = 'online_config') { return $this->_config->find($what, $section); } public function getPartnerCode($Login, $Password) { if (isset($_SESSION['PARTNER']) && ($_SESSION['PARTNER']['PartPassAlias'] == $Login)) { $this->partner = $_SESSION['PARTNER']; } else { $qres = $this->_db->exec(ANDR_SQLSERVER . '.' . ANDR_DB_OFFICE . '.dbo.up_WEB_3_Partner_Code', array('Alias' => $Login, 'PSW' => $Password), true); if ($this->_db->numRows($qres) != 0) { $row = $this->_db->fetchRow($qres); $this->partner = $this->_partner_($row); } else { $this->partner = false; } } return $this->partner; } public function getPartnerInc($Partner, $PartPass = null) { if (isset($_SESSION['PARTNER']) && ($_SESSION['PARTNER']['PartPassInc'] == $PartPass)) { $this->partner = $_SESSION['PARTNER']; } else { $qres = $this->_db->exec(ANDR_SQLSERVER . '.' . ANDR_DB_OFFICE . '.dbo.up_andr_partner_code', array('Partner' => $Partner, 'PartPass' => $PartPass), true); if ($this->_db->numRows($qres) != 0) { $row = $this->_db->fetchRow($qres); $this->partner = $this->_partner_($row); } else { $this->partner = false; } } return $this->partner; } protected function _authPartner($Partner, $PartPass = null) { if (!isset($_SESSION['PARTNER'])) { return $this->getPartnerInc($Partner, $PartPass); } return $this->partner; } private function _partner_($row) { if ($row['Partner'] > 0) { $row['PARTNERGROUP'] = ($row['PARTNERGROUP'] > 0) ? $row['PARTNERGROUP'] : null; $_SESSION['PARTNER'] = $row; $_SESSION['samo_auth'] = $row; } else { $row = false; } return $row; } public function authPartner($Login, $Password) { $partner = $this->getPartnerCode($Login, $Password); if ($partner === false) { return $this->raiseError(1000); } else { return $partner; } } public function getCountry() { $sql = $this->_db->formatExec( '<ONLINEDB>.dbo.up_WEB_3_people_StateBorn', [ 'UserCode' => $this->internetUser(), ] ); $return = $this->_db->fetchAll($sql); return ($return) ? $return : $this->raiseError(1109); } protected function _fixServiceType($type) { if (!isset($this->servtypemap)) { $tr = $this->getConfig('ANDR_TRANSF', 'andromeda'); $ex = $this->getConfig('ANDR_EXCURS', 'andromeda'); if (!($tr) && !($ex)) { $this->servtypemap = __serviceType(); } else { $this->servtypemap = array(); if ($tr) { $tr = explode(',', $tr); foreach ($tr as $key) { $this->servtypemap[$key] = 3; } } if ($ex) { $ex = explode(',', $ex); foreach ($ex as $key) { $this->servtypemap[$key] = 4; } } } } if (array_key_exists($type, $this->servtypemap)) { return $this->servtypemap[$type]; } else { return 5; } } protected function _internetPartner() { $INTERNET_PARTNER = $this->getConfig('INTERNET_PARTNER'); if ($INTERNET_PARTNER < 0) { $INTERNET_PARTNER = null; } return $INTERNET_PARTNER; } public function uid($type, &$row) { $val = array($type, $row['inc']); switch ($type) { case 'H': array_push($val, getDate112($row['DateBeg']), getDate112($row['DateEnd']), $row['RoomInc'], $row['HtPlaceInc'], $row['MealInc']); break; case 'F': array_push($val, getDate112($row['DateBeg']), getDate112($row['DateEnd']), $row['ClassInc'], $row['FrPlaceInc'], $row['FreightInc'], isset($row['OfferId']) ? $row['OfferId'] : ''); break; case 'S': array_push($val, 'stOther', getDate112($row['DateBeg']), getDate112($row['DateEnd']), $row['HotelInc'], $row['MealInc'], $row['SrcTownInc'], $row['TrgTownInc'], $row['AirlineInc'], $row['ClassInc'], $row['RouteIndex']); if ($row['RoomInc']) { array_push($val, $row['RoomInc']); } break; case 'I': if ($row['Medical']) { array_push($val, getDate112($row['DateBeg'])); } array_push($val, getDate112($row['DateEnd'])); break; default: array_push($val, getDate112($row['DateBeg']), getDate112($row['DateEnd'])); break; } $uid = $row['uid'] = md5(implode('|', $val)); return $uid; } protected function _agentUser() { $INTERNET_USER = $this->getConfig('INTERNET_USER'); if (trim($INTERNET_USER == '') || ($INTERNET_USER < 1)) { return $this->raiseError('1201', array('INTERNET_USER')); } return $INTERNET_USER; } protected function _mediator() { if ($id = $this->_user['ClientId']) { if ($mediator = intval($this->getConfig('mediator_' . $id, 'andromeda'))) { return $mediator; } } return null; } public function getClaimPrice($claim = null) { $return = array(); if (is_null($claim)) { $claim = $this->getVar('claim'); } $qres = $this->_db->exec( ANDR_SQLSERVER . '.' . ANDR_DB_OFFICE . '.dbo.up_WEB_4_claim_Cost', [ 'Claim' => $claim, 'RateType' => $this->claimcost_rate_type, 'CurrType' => $this->claimcost_currtype, 'DateType' => $this->claimcost_datetype, 'RateDate' => $this->claimcost_rate_date, 'UserCode' => $this->internetUser(), 'Partner' => $this->partner['Partner'], ], true ); if ($this->_db->numRows($qres) != 0) { while ($row = $this->_db->fetchRow($qres)) { $return[] = $row; } } return $return; } public function currencyRates() { $cross_rates = array(); if ($this->version > 4) { $qres = $this->_db->exec(ANDR_DB_ONLINE . '.dbo.up_WEB_3_CurrencyRates', array(), true); if ($this->_db->numRows($qres) != 0) { while ($row = $this->_db->fetchRow($qres)) { if (!isset($cross_rates[$row['curr_from']])) { $cross_rates[$row['curr_from']] = array('Inc' => $row['curr_from'], 'Name' => $row['alias_from']); } $cross_rates[$row['curr_from']][$row['curr_to']] = $row['rate']; } } ksort($cross_rates); } return $cross_rates; } protected function _convertPrice($price, $from, $to, $precision = 0) { static $rates = null; $rate = null; if ($from == $to) { $rate = 1; } else { if (is_null($rates)) { $rates = $this->currencyRates(); } if (!is_null($from) && !is_null($to) && isset($rates[$from]) && isset($rates[$from][$to])) { $rate = $rates[$from][$to]; } } if (is_null($rate)) { return null; } else { return round($price * $rate, $precision); } } public function getTouristFields($tour) { return $this->_tourist_fields($tour); } protected function _tourist_edit_enabled() { return $this->isModuleInstall('edit_tourist'); } protected function _tourist_fields($tour = null) { $return = array(); if ($this->version > 4) { $editable = $this->_tourist_edit_enabled(); $return = array( 'age' => array('required' => true, 'readonly' => !$editable, 'visible' => true), 'sex' => array('required' => true, 'readonly' => !$editable, 'visible' => true), ); $packetInfo = Samo_Loader::load_object('Packet_Info', $this->_config); $packetInfo['TourInc'] = $tour; $packetInfo['CheckIn'] = Samo_Datetime::today(); $packetInfo['CheckOut'] = Samo_Datetime::today(); $people = Samo_Loader::load_object('Samo_People', $this->_config, $packetInfo, false); $fields = $people->fields(); foreach ($fields as $field) { $return[$field['ClaimField']] = array( 'required' => (bool)$field['Required'], 'readonly' => !((bool)$editable && (bool)$field['Editable']), 'visible' => (bool)$field['Visible'], 'pattern' => $field['Pattern'], 'patternTitle' => $field['PatternTitle'], ); } } return $return; } public function NEWGUID() { $qres = $this->_db->exec(ANDR_SQLSERVER . '.' . ANDR_DB_OFFICE . '.[dbo].[up_WEB_3_newid]', array(), true); if ($this->_db->numRows($qres) != 0) { $row = $this->_db->fetchRow($qres); return $row['guid']; } throw new Andr_Exception(800); } protected function getOnlineModules() { if (!defined('ROUTES_PATH')) { define('ROUTES_PATH', ANDR_FOLDER_SITE . 'routes.php'); } if (is_null($this->online_modules)) { include ROUTES_PATH; $this->online_modules = isset($routes) ? $routes : array(); } return $this->online_modules; } protected function isModuleInstall($module) { $routes = $this->getOnlineModules(); return (isset($routes[$module])); } public function calc_stats($client, $module, $action) { $sql = $this->_db->formatExec( ANDR_DB_ONLINE . '.dbo.up_WEB_3_online_stats', [ 'Module' => $module, 'Action' => $action, 'Client' => $client, ] ); $this->_db->lazyFetch( $sql, function ($return) { return true; } ); } public function partnerCommission($tour = null) { $qres = $this->_db->exec( ANDR_SQLSERVER . '.' . ANDR_DB_OFFICE . '.[dbo].[up_WEB_3_partner_Discount]', [ 'Partner' => $this->partner['Partner'], 'Tour' => $tour, 'UserCode' => $this->internetUser(), ], true ); $res = $this->_db->fetchOne($qres); return $res; } protected function _user($USER = null) { if (null !== $USER) { if (is_array($USER)) { $this->_user = array_merge($this->_user, $USER); } else { $this->_user['Alias'] = strval($USER); } } return $this->_user; } public function internetUser() { return $this->_config->internet_user(); } protected function _api($name) { static $apis = []; if (!isset($apis[$name])) { $apis[$name] = Samo_Loader::load_object(ucwords($name, '_'), $this->_config); } return $apis[$name]; } } 