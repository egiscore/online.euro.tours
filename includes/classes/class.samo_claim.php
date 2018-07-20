<?php
 class Samo_Claim extends Samo { protected $auth_required = array('agency', 'person'); protected $ignore_author_login = true; protected $claimcost_rate_type = 2; protected $claimcost_currtype = 'PayCurr'; protected $claimcost_datetype = null; protected $claimcost_rate_date = 'null'; public $SetIssuedDocum = 1; protected $messages = null; const STATUS_PAID = 1; const STATUS_UNPAID = 2; const STATUS_CANCELED = 3; const STATUS_PENALTY = 4; const STATUS_PAID_PENALTY = 5; const STATUS_PAID_PARTLY = 6; const STATUS_CALCULATED = 7; const MAIL_CANCEL_CLAIM_TOUROPERATOR = 4; const MAIL_CANCEL_CLAIM_AGENT = 5; public function construct($claim = null, $people = null, $order = null) { $this->messages = Samo_Registry::get('messages'); $this->defaults['CLAIM'] = Samo_Utils::ifs($claim, Samo_Request::intval('CLAIM'), 0); $this->defaults['BUYER'] = isset($_SESSION['samo_auth']['PhysBuyerInc']) ? $_SESSION['samo_auth']['PhysBuyerInc'] : null; $this->defaults['CLAIMLIST'] = null; $this->defaults['CLAIMTYPE'] = $this->defaults['CLAIM'] ? 1 : Samo_Utils::ifs(Samo_Request::intval('CLAIMTYPE'), 2); $this->defaults['CLAIMBEG'] = $this->defaults['CLAIMEND'] = Samo_Request::intval('CLAIMBEGIN'); $min_date = Samo_Datetime::parse('-10 year'); $max_date = Samo_Datetime::parse('+2 year'); foreach (array('CHECKINBEG', 'CHECKINEND', 'CDATEBEG', 'CDATEEND') as $field) { $this->defaults[$field] = Samo_Request::date($field, $min_date, $max_date); } $this->defaults['ADMINISTRATOR'] = (int)$_SESSION['samo_auth']['Administrator']; $this->defaults['PARTNER'] = (int)$_SESSION['samo_auth']['Partner']; $this->defaults['PARTPASS'] = (int)$_SESSION['samo_auth']['PartPassInc']; $this->defaults['PARTNERGROUP'] = (int)$_SESSION['samo_auth']['PARTNERGROUP']; $this->defaults['ORDER'] = Samo_Utils::ifs($order, Samo_Request::intval('ORDER', 1), Samo_Request::intval('ORDERINC', 1)); $this->defaults['FIO'] = Samo_Utils::ifs(Samo_Request::strval('FIO'), null); $this->defaults['CLAIMPAGE'] = Samo_Utils::ifs(Samo_Request::intval('CLAIMPAGE', 1), 1); $this->defaults['PEOPLE'] = Samo_Utils::ifs($people, Samo_Request::intval('PEOPLE', 1), Samo_Request::intval('PEOPLEINC', 1)); $this->ignore_author_login = (isset($_SESSION['samo_auth']['ignore_author_login'])) ? $_SESSION['samo_auth']['ignore_author_login'] : $this->ignore_author_login; $this->claimcost_datetype = (defined('CLAIMCOST_DATETYPE') ? CLAIMCOST_DATETYPE : null); $this->defaults['PAYTYPE'] = $this->defaults['CLAIM'] ? null : Samo_Utils::ifs(Samo_Request::intval('PAYTYPE'), null); $this->defaults['PARTNERCLAIM'] = $this->defaults['CLAIM'] ? null : Samo_Utils::ifs(Samo_Request::intval('PARTNERCLAIM'), null); $this->defaults['STATECLAIM'] = $this->defaults['CLAIM'] ? null : Samo_Utils::ifs(Samo_Request::intval('STATECLAIM'), null); $this->defaults['MANAGERCLAIM'] = $this->defaults['CLAIM'] ? null : Samo_Utils::ifs(Samo_Request::intval('MANAGERCLAIM'), null); if ($this->defaults['CLAIM']) { return $this->check_permission(); } } public function check_permission() { if (!$this->defaults['CLAIM']) { throw new InvalidArgumentException('Required parameter @Claim not set'); } if ($_SESSION['samo_auth']['type'] == 'person') { if (isset($_SESSION['samo_auth']['CLAIM']) && $_SESSION['samo_auth']['CLAIM'] != $this->defaults['CLAIM']) { throw new Samo_Exception('Access Denied', 403); } if (isset($_SESSION['samo_auth']['ClaimList']) && !in_array($this->defaults['CLAIM'], $_SESSION['samo_auth']['ClaimList'])) { throw new Samo_Exception('Access Denied', 403); } } if (!isset($_SESSION['samo_auth']['claim'])) { $_SESSION['samo_auth']['claim'] = []; } $params = [ 'Partpass' => $this->defaults['PARTPASS'], 'Claim' => $this->defaults['CLAIM'], 'People' => $this->defaults['PEOPLE'], 'Order' => $this->defaults['ORDER'], 'UserCode' => $this->internet_user(), ]; $cacheKey = json_encode($params); if (!isset($_SESSION['samo_auth']['claim'][$cacheKey]) || (defined('FORCE_CHECK_PERMISSION') && FORCE_CHECK_PERMISSION == 1)) { $sql = $this->db->formatExec('<OFFICEDB>.dbo.up_WEB_5_claim_Permission', $params); $_SESSION['samo_auth']['claim'][$cacheKey] = $this->db->fetchOne($sql); } if (!$_SESSION['samo_auth']['claim'][$cacheKey]) { throw new Samo_Exception('Access Denied', 403); } return true; } public function permissions() { $return = $_SESSION['samo_auth']['permissions']; return $return; } public function claimCost($currencyInc = null) { $showMinus = $this->getConfig('ShowMinusDebt','Online',0); $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_4_claim_Cost', [ 'Claim' => $this->defaults['CLAIM'], 'RateType' => $this->claimcost_rate_type, 'CurrType' => $this->claimcost_currtype, 'DateType' => $this->claimcost_datetype, 'RateDate' => $this->claimcost_rate_date, 'UserCode' => $this->internet_user(), 'Partner' => $this->getPartner(), ] ); if (null !== $currencyInc) { $result = $this->db->fetchAllWithKey($sql, 'CurrencyInc'); } else { $result = $this->db->fetchAll($sql); } if ($result) { if (!$showMinus) { $floatvals = array('Catalog', 'Amount', 'Amount_to_pay_person', 'Debt', 'Debt_person', 'Commiss', 'Discount', 'Supplement', 'Paid'); foreach ($result as $idx => $res) { foreach ($res as $fld => $val) { if (in_array($fld, $floatvals)) { if ($res[$fld] < 0) { $res[$fld] = 0; } } } $result[$idx] = $res; } } } else { $messages = Samo_Registry::get('messages'); throw new Samo_Exception($messages['CALC_CLAIM_COST_ERROR'], 503); } if (null !== $currencyInc) { return (isset($result[$currencyInc])) ? $result[$currencyInc] : false; } return array_values($result); } protected function _claimHotels() { $return = array(); $sql = $this->db->formatExec('<OFFICEDB>.dbo.up_WEB_3_claim_Hotel', ['Claim' => $this->defaults['CLAIM'],]); if (false !== ($res = $this->db->query($sql))) { if ($this->db->numRows($res) > 0) { while (false !== ($row = $this->db->fetchRow($res))) { $row['HotelCheckinTime'] = $row['HotelCheckinTime']->format('time'); $row['HotelCheckoutTime'] = $row['HotelCheckoutTime']->format('time'); $row['HotelTimeBeg'] = $row['HotelTimeBeg']->format('time'); $row['HotelTimeEnd'] = $row['HotelTimeEnd']->format('time'); $row['HotelUrl'] = Samo_Url::parse($row['HotelUrl']); $row['TimeLimit'] = isset($row['TimeLimit']) ? $row['TimeLimit'] : Samo_Datetime::null(); $return[$row['OrderInc']] = $row; } } $this->db->freeResult($res); } return $return; } protected function _claimFreights() { $return = array(); $sql = $this->db->formatExec('<OFFICEDB>.dbo.up_WEB_3_claim_Freight', ['Claim' => $this->defaults['CLAIM'],]); if (false !== ($res = $this->db->query($sql))) { if ($this->db->numRows($res) > 0) { while (false !== ($row = $this->db->fetchRow($res))) { $day_delta = ((intval($row['TrgTime']) - intval($row['SrcTime'])) < 0) ? 1 : 0; $row['RealDateBeg'] = $row['DateBeg']->copy()->add_days($row['delay']); $row['SrcTimeDelta'] = $row['delay']; $tmp = (int)$row['delay'] + (int)$row['days']; $row['TrgTimeDelta'] = ($tmp) ? $tmp : $day_delta; $row['RealDateEnd'] = $row['DateEnd']->copy()->add_days($row['TrgTimeDelta']); $row['TimeLimit'] = isset($row['TimeLimit']) ? $row['TimeLimit'] : Samo_Datetime::null(); $return[$row['OrderInc']] = $row; } } $this->db->freeResult($res); } return $return; } protected function _claimServices() { $sql = $this->db->formatExec('<OFFICEDB>.dbo.up_WEB_3_claim_Service', ['Claim' => $this->defaults['CLAIM'],]); return Samo_Utils::ifs( $this->db->fetchAllWithKey( $sql, 'OrderInc', function($row) { $row['TimeLimit'] = isset($row['TimeLimit']) ? $row['TimeLimit'] : Samo_Datetime::null(); return $row; } ), array() ); } protected function _claimInsures() { $sql = $this->db->formatExec('<OFFICEDB>.dbo.up_WEB_4_claim_Insure', ['Claim' => $this->defaults['CLAIM'],]); return Samo_Utils::ifs( $this->db->fetchAllWithKey( $sql, 'OrderInc', function($row) { $row['TimeLimit'] = isset($row['TimeLimit']) ? $row['TimeLimit'] : Samo_Datetime::null(); return $row; } ), array() ); } protected function _claimVisas() { $sql = $this->db->formatExec('<OFFICEDB>.dbo.up_WEB_3_claim_Visa', ['Claim' => $this->defaults['CLAIM'],]); return Samo_Utils::ifs( $this->db->fetchAllWithKey( $sql, 'OrderInc', function($row) { $row['TimeLimit'] = isset($row['TimeLimit']) ? $row['TimeLimit'] : Samo_Datetime::null(); return $row; } ), array() ); } protected function _claimPeoples($peopleinc = null) { $return = array(); $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_4_claim_People', [ 'Claim' => $this->defaults['CLAIM'], 'People' => $peopleinc, 'UserCode' => $this->internet_user(), ] ); if (false !== ($res = $this->db->query($sql))) { if ($this->db->numRows($res) > 0) { while (false !== ($row = $this->db->fetchRow($res))) { foreach (array('Born', 'PValid', 'PIssue') as $field) { $row[$field] = $data = Samo_Loader::load_object('Samo_Datetime', $row[$field]); } if (strpos($row['Name'], FIO_DELIMETER)) { $row['LastName'] = substr($row['Name'], 0, strpos($row['Name'], FIO_DELIMETER)); $row['FirstName'] = substr( $row['Name'], strpos($row['Name'], FIO_DELIMETER) + strlen(FIO_DELIMETER) ); $row['LastLName'] = substr($row['LName'], 0, strpos($row['LName'], FIO_DELIMETER)); $row['FirstLName'] = substr( $row['LName'], strpos($row['LName'], FIO_DELIMETER) + strlen(FIO_DELIMETER) ); } else { $row['FirstName'] = $row['FirstLName'] = ''; $row['LastName'] = $row['Name']; $row['LastLName'] = $row['LName']; } $return[$row['index']] = $row; } } $this->db->freeResult($res); } return $return; } protected function _claimBuyer() { $return = false; if ($this->defaults['claim_info']['PhysBuyer']) { $_buyer = Samo_Loader::load_object('Samo_Buyer', $this->config); if ($buyer = $_buyer->load($this->defaults['claim_info']['PhysBuyer'])) { $buyer = array_shift($buyer); $return = array(); foreach ($buyer as $field) { $return[$field['EntityField']] = $field['Value']; } $return['Inc'] = $_buyer->inc; } } return $return; } protected function __claimInfo() { $this->defaults['CLAIMBEG'] = $this->defaults['CLAIMEND'] = $this->defaults['CLAIM']; $this->defaults['CLAIMTYPE'] = 1; if (false !== ($tmp = $this->getClaims())) { return array_shift($tmp); } return false; } public function getClaims() { $return = array(); $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_5_claim_List', array( 'Partner' => $this->defaults['PARTNER'], 'PartnerGroup' => $this->defaults['PARTNERGROUP'], 'CLAIMLIST' => $this->defaults['CLAIMLIST'], 'CLAIMTYPE' => $this->defaults['CLAIMTYPE'], 'CLAIMBEG' => $this->defaults['CLAIMBEG'], 'CLAIMEND' => $this->defaults['CLAIMEND'], 'DATEBEG' => $this->defaults['CHECKINBEG'], 'DATEEND' => $this->defaults['CHECKINEND'], 'FIO' => $this->defaults['FIO'], 'partpass' => $this->defaults['PARTPASS'], 'rec_on_page' => intval(CL_REFER_REC_ON_PAGE), 'page' => intval($this->defaults['CLAIMPAGE']), 'CDATEBEG' => $this->defaults['CDATEBEG'], 'CDATEEND' => $this->defaults['CDATEEND'], 'PAYTYPE' => $this->defaults['PAYTYPE'], 'PARTNERCLAIM' => $this->defaults['PARTNERCLAIM'], 'STATECLAIM' => $this->defaults['STATECLAIM'], 'MANAGERCLAIM' => $this->defaults['MANAGERCLAIM'], 'Buyer' => $this->defaults['BUYER'], 'UserCode' => $this->internet_user(), ) ); if (false !== ($query = $this->db->query($sql))) { if ($this->db->numRows($query) > 0) { $messages = Samo_Registry::get('messages'); $access = isset($_SESSION['claim']) ? $_SESSION['claim'] : []; while (false !== ($row = $this->db->fetchRow($query))) { $row['DocumentsStatusInc'] = 0; $row['DocumentsStatus'] = null; $row['CanPrintDocument'] = 1; $row['InvoiceNumber'] = trim($row['InvoiceNumber']); $row['show_cost_link'] = ($row['Status'] != Samo_Claim::STATUS_CANCELED); $row['cl_status'] = $this->getClaimStatus($row); $row['cl_getBonus'] = false; if ($this->is_module_installed('bonus_manager') && $row['Status'] == self::STATUS_UNPAID) { $row['cl_getBonus'] = true; } $access[$row['Inc']] = true; $return[] = $row; } $_SESSION['claim'] = $access; } } $this->db->freeResult($query); return $return; } private function getClaimStatus($row) { $status = false; if ($row['Status'] == self::STATUS_PAID) { $status = 'paid'; } elseif ($row['Status'] == self::STATUS_UNPAID) { if ($row['Partpayment'] == 1) { $status = 'partpaid'; } else { $status = 'unpaid'; } } elseif ($row['Status'] == self::STATUS_CANCELED) { $status = 'cancel'; } elseif ($row['Status'] == self::STATUS_PENALTY) { if ($row['Partpayment'] == 1) { $status = 'penaltypart'; } else { $status = 'penalty'; } } elseif ($row['Status'] == self::STATUS_PAID_PENALTY) { $status = 'penaltypaid'; } elseif ($row['Status'] == self::STATUS_CALCULATED) { $status = 'calc'; } return $status; } public function peoples_by_order() { $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_3_claim_PeopleByOrder', [ 'Order' => $this->defaults['ORDER'], ] ); return $this->db->fetchAllWithKey($sql, 'Inc'); } public function SetIssuedDocum() { if ($this->SetIssuedDocum) { $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_4_Set_Issued_AIV_Claim', [ 'Claim' => $this->defaults['CLAIM'], 'UserCode' => $this->internet_user(), ] ); $this->db->query($sql); } return true; } protected function log($source, $message, $rawdata = '', $priority = 'info', $partpass = null) { $data = array( 'priority' => $priority, 'message' => $message, 'partpass' => $partpass, 'sql' => $rawdata, 'result' => $source, 'claim' => $this->defaults['CLAIM'], 'claiminc' => -3, 'ip' => Samo_Request::remote_addr(), 'claimdocument' => null, ); $sql = $this->db->formatExec('<OFFICEDB>.[dbo].[up_WEB_3_log]', $data); $this->db->query($sql); } public function partner_info() { return parent::getPartnerInfo($this->defaults['PARTNER']); } public function claimInfo() { if (false !== ($claim = $this->_claimInfo())) { $this->defaults['claim_info'] = $claim; $this->defaults['TOURINC'] = $claim['TourInc']; } return $claim; } public function peopleInfo($people) { if (false !== ($people = $this->_claimPeoples($people))) { $this->defaults['people_info'] = array_shift($people); return $this->defaults['people_info']; } return false; } public function tourinc() { if (!isset($this->defaults['TOURINC'])) { $this->claimInfo(); } return $this->defaults['TOURINC']; } public function __call($method, $params) { $storage = Samo_Registry::instance(); $cache = (isset($storage['claimInfo'])) ? $storage['claimInfo'] : array(); $real_method = '_' . $method; if (empty($params) && $this->defaults['CLAIM'] && method_exists($this, $real_method)) { $key = $method . $this->defaults['CLAIM']; if (!isset($cache[$key])) { $cache[$key] = call_user_func(array($this, $real_method)); $storage['claimInfo'] = $cache; } return $cache[$key]; } if (method_exists($this, $real_method) && $real_method != '_claimInfo') { throw new Samo_Exception('Before call ' . $method . ' you need execute ' . __CLASS__ . '::' . 'claimInfo'); } throw new Samo_Exception('Unknown method: ' . $method); } public function external_document($doc) { $prefix = 'edoc_' . $doc . '_'; $return = Samo_Utils::findFile(_ROOT . 'dnl', $prefix . '*'); if (!$return) { $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_4_claim_document', [ 'Claim' => $this->defaults['CLAIM'], 'Document' => $doc, 'UserCode' => $this->internet_user(), ] ); $this->db->rawMode(true); if ($res = $this->db->fetchRow($sql)) { if (!isset($res['Url']) || empty($res['Url'])) { $return = Samo_Utils::tempFile($prefix, $res['FileName'], $res['Content']); } else { $return = $res['Url']; } } $this->db->rawMode(false); } return ($return) ? $return : false; } protected function tour_config($param, $section = null, $server = null, $tour = null) { if (null === $section) { $section = 'print'; } return parent::tour_config($param, $section, '<OFFICEDB>', $tour); } } 