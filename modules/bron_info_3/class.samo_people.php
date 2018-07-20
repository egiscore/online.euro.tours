<?php
 class Samo_People extends Samo_EnvLoader { const BLANK = '�'; public $inc = null; public $HUMAN = null; public $MALE = null; public $NAME = null; public $LNAME = null; public $BORN = null; public $PLACEBORN = Samo::MAXLONGINT; public $PLACEBORNDETAIL = null; public $PSERIE = null; public $PNUMBER = null; public $PVALID = null; public $VEXPIRE = null; public $NATIONALITY = Samo::MAXLONGINT; public $PGIVEN = null; public $PGIVENORG = null; public $ADDRESS = null; public $PHONE = null; public $EMAIL = null; public $MOBILE = null; public $INN = null; public $ADDITIONAL = false; private $_states = array(); private $fields = null; private $_is_exists = false; protected $_errors = array(); protected $infant_age = 2; protected $child_age = 12; private $mustBeAdultPassport = false; private $settings = null; private $age = null; protected function required() { $empty_required_fields = array(); $people = ($this->is_exists()) ? $this->inc : null; foreach ($this->fields($people) as $field) { if ($field['Required'] && $field['Field'] !== 'VEXPIRE') { switch ($field['Type']) { case 'date': $is_empty = (null === $this->{$field['Field']} || $this->{$field['Field']}->is_null()); break; case 'sex': $is_empty = (null === $this->{$field['Field']}); break; case 'state': $is_empty = ($this->{$field['Field']} <= 0); break; default: $is_empty = empty($this->{$field['Field']}); break; } if ($is_empty) { $empty_required_fields[] = $this->format_error_field($field['Field'], $field['Title']); } } } $empty_fields = count($empty_required_fields); if ($empty_fields) { if (Samo_Request::is_api()) { foreach ($empty_required_fields as $field) { $this->add_error_fields('EMPTY_REQUIRED_FIELD', array($field)); } } else { $message_idx = 'TOURIST_EMPTY_FIELD' . (($empty_fields > 1) ? 'S' : ''); $this->add_error_fields($message_idx, $empty_required_fields); } return false; } return true; } public function add_error($message, $field) { $this->add_error_fields($message, array($this->format_error_field($field))); } protected function add_error_fields($msg, $fields = array()) { $people = ($this->LNAME) ? $this->LNAME : (($this->NAME) ? $this->NAME : $this->inc); $format = $this->messages($msg); if ($format != $msg) { $_fields = array(); foreach ($fields as $field) { if (isset($field['Title'])) { $_fields[] = $field['Title']; } } $msg = sprintf($format, $people, implode(', ', $_fields)); } $this->_errors[$msg] = $fields; } protected function format_error_field($field, $title = null) { return array( 'Field' => $field, 'FormField' => sprintf('[People][%d][%s]', $this->inc, $field), 'Title' => $title, ); } public function self_test() { if ($this->strict_check) { $this->required(); $people = ($this->is_exists()) ? $this->inc : null; $states = array_map( function ($el) { return $el['StateInc']; }, $this->states() ); array_push($states, Samo::MAXLONGINT); if (!in_array($this->PLACEBORN, $states)) { $this->add_error('TOURIST_INCORRECT_STATE', 'PLACEBORN'); } if (!in_array($this->NATIONALITY, $states)) { $this->add_error('TOURIST_INCORRECT_STATE', 'NATIONALITY'); } if ($this->HUMAN == 'MRS' && $this->MALE == 1) { $this->add_error('TOURIST_INCORRECT_SEX', 'MALE'); } if ($this->HUMAN == 'MR' && $this->MALE == 0) { $this->add_error('TOURIST_INCORRECT_SEX', 'MALE'); } $today = Samo_Datetime::today(); if ($this->BORN->not_null() && $this->BORN->gt($today)) { $this->add_error('TOURIST_INCORRECT_BORN', 'BORN'); } if (('MRS' == $this->HUMAN || 'MR' == $this->HUMAN) && $this->is_child_age()) { $this->add_error('TOURIST_INCORRECT_ADULT_AGE', 'BORN'); } if (('INF' == $this->HUMAN && !$this->is_infant_age())) { $this->add_error('TOURIST_INCORRECT_INFANT_AGE', 'BORN'); } if (('CHD' == $this->HUMAN || 'INF' == $this->HUMAN)) { if (null !== $people && $this->is_adult_age()) { $this->add_error('TOURIST_INCORRECT_HUMAN', 'BORN'); } } if ($this->PGIVEN->not_null() && $this->PGIVEN->gt($today)) { $this->add_error('TOURIST_INCORRECT_PGIVEN', 'PGIVEN'); } if ($this->PGIVEN->not_null() && $this->BORN->not_null() && $this->PGIVEN->lt($this->BORN)) { if (in_array($this->HUMAN, ['CHD', 'INF']) && $this->age() < 14) { $this->mustBeAdultPassport = true; if ($this->PGIVEN->copy()->modify('+5 year')->lt($this->BORN)) { $this->add_error('TOURIST_INCORRECT_PGIVEN', 'PGIVEN'); } if ($this->PVALID->not_null() && $this->PGIVEN->copy()->modify('+5 year')->lt($this->PVALID)) { $this->add_error('TOURIST_INCORRECT_PGIVEN', 'PGIVEN'); } } else { $this->add_error('TOURIST_INCORRECT_PGIVEN', 'PGIVEN'); } } if ($this->PVALID->not_null() && $this->PVALID->lte($today)) { $this->add_error('TOURIST_INCORRECT_PVALID', 'PVALID'); } if ($this->VEXPIRE->not_null() && $this->VEXPIRE->lte($today)) { $this->add_error('TOURIST_INCORRECT_VEXPIRE', 'VEXPIRE'); } $people = ($this->is_exists()) ? $this->inc : null; foreach ($this->fields($people) as $field) { if ($field['Editable'] && $field['Visible']) { $len = strlen($this->{$field['Field']}); if ($len) { if ((isset($field['MinLength']) && $field['MinLength']) || (isset($field['MaxLength']) && $field['MaxLength'])) { if (isset($field['MinLength']) && $field['MinLength'] && $len < $field['MinLength']) { $format = $this->messages('FIELD_FILTER_MIN_LENGTH'); $message = sprintf($format, $field['Title'], $field['MinLength']); $this->add_error($message, $field['Field']); } if (isset($field['MaxLength']) && $field['MaxLength'] && $len > $field['MaxLength']) { $format = $this->messages('FIELD_FILTER_MAX_LENGTH'); $message = sprintf($format, $field['Title'], $field['MaxLength']); $this->add_error($message, $field['Field']); } } if ($field['Pattern']) { if (in_array($field['Field'], array('NAME', 'LNAME'))) { if (strpos($this->{$field['Field']}, FIO_DELIMETER)) { $lastname = substr($this->{$field['Field']}, 0, strpos($this->{$field['Field']}, FIO_DELIMETER)); $firstname = substr($this->{$field['Field']}, strpos($this->{$field['Field']}, FIO_DELIMETER) + strlen(FIO_DELIMETER)); } else { $firstname = ''; $lastname = $this->{$field['Field']}; } if ($field['Pattern'] && !preg_match($field['Pattern'], $lastname)) { $this->add_error_fields($field['PatternTitle'], array($this->format_error_field('LAST' . $field['Field']))); } if ($field['Pattern'] && !preg_match($field['Pattern'], $firstname)) { $this->add_error_fields($field['PatternTitle'], array($this->format_error_field('FIRST' . $field['Field']))); } } else { if (!preg_match($field['Pattern'], $this->{$field['Field']}) && !($this->{$field['Field']} == Samo_People::BLANK && in_array($field['Field'], array('PGIVENCODE', 'PGIVENORG', 'ADDRESS', 'PHONE', 'EMAIL', 'MOBILE')))) { $this->add_error_fields($field['PatternTitle'], array($this->format_error_field($field['Field']))); } } } $validator = Samo_Loader::load_object('Samo_Validate'); if ($field['Field'] == 'EMAIL' && $this->{$field['Field']} != Samo_People::BLANK && !call_user_func([$validator, 'email'], $this->{$field['Field']})) { $this->add_error('TOURIST_INCORRECT_EMAIL', 'TOURIST_INCORRECT_EMAIL'); } if ($field['Field'] == 'INN' && $this->{$field['Field']} != Samo_People::BLANK && !call_user_func([$validator, 'partner_inn'], $this->{$field['Field']})) { $this->add_error('TOURIST_INCORRECT_INN', 'INN'); } } if (in_array($field['Field'], ['BORN', 'PGIVEN', 'PVALID', 'VEXPIRE']) && $this->{$field['Field']} != Samo_People::BLANK && !$this->{$field['Field']}->is_smalldatetime()) { $message = $this->messages('CHECK_DATA'); $this->add_error($message, $field['Field']); } } } $this->customer_rules(); } return $this->errors(); } public function errors() { if (count($this->_errors)) { throw new Samo_People_Exception($this->messages('TOURIST_FILL_ERROR'), $this->_errors); } } public function clearErrors() { $this->_errors = []; } public function age() { if (null === $this->age && null !== $this->BORN && $this->BORN->not_null()) { $CalcAgeFrom = isset($this->settings['CalcAgeFrom']) ? $this->settings['CalcAgeFrom'] : 'CheckIn'; $date = isset($this->packetinfo[$CalcAgeFrom]) ? $this->packetinfo[$CalcAgeFrom]->copy() : Samo_Datetime::today(); $this->age = ($this->BORN->format('md') > $date->format('md')) ? $date->format('Y') - $this->BORN->format('Y') - 1 : $date->format('Y') - $this->BORN->format('Y'); } return $this->age; } public function set_age($age) { $CalcAgeFrom = isset($this->settings['CalcAgeFrom']) ? $this->settings['CalcAgeFrom'] : 'CheckIn'; $date = isset($this->packetinfo[$CalcAgeFrom]) ? $this->packetinfo[$CalcAgeFrom]->copy() : Samo_Datetime::today(); $date->modify('-' . $age . ' year'); $this->BORN = $date; } public function is_adult_age() { return !$this->is_child_age(); } public function is_child_age() { $age = $this->age(); return (null !== $age && $age < $this->child_age) ? true : false; } public function is_infant_age() { $age = $this->age(); return (null !== $age && $age < $this->infant_age) ? true : false; } public function xmlage() { return ($this->HUMAN == 'MRS' || $this->HUMAN == 'MR') ? 'ADL' : $this->HUMAN; } protected function field_empty(array $field) { switch ($field['Type']) { case 'state': $return = $field['Value'] < 0; break; case 'sex': $return = (null === $field['Value']); break; case 'date': $return = (null === $field['Value'] || $field['Value']->is_null()); break; default: $return = empty($field['Value']); break; } return $return; } public function init($people) { $this->is_exists($people); $this->fields($people); return $this; } public function fields($people = null) { if (null === $this->fields) { $db = $this->db(); $tour = $this->packetinfo['TourInc']; $sql = $db->formatExec( '<OFFICEDB>.dbo.up_WEB_6_people_params', [ 'Tour' => $tour, 'UserCode' => $this->internet_user(), 'People' => $people, 'LangId' => $this->langId(), ] ); $query = $db->query($sql); $this->fields = $db->fetchAll($query); if ($this->fields) { foreach ($this->fields as &$field) { $current_value = $this->{$field['Field']}; $field['Value'] = (isset($field['Value'])) ? $field['Value'] : null; if ('date' == $field['Type']) { $value = Samo_Loader::load_object('Samo_Datetime', $field['Value']); } else { $value = ($field['Type'] == 'sex' && null == $field['Value']) ? 0 : $field['Value']; } $this->{$field['Field']} = $field['Value'] = $field['OldValue'] = (null !== $current_value && (!isset($field['Value']) || empty($field['Value']))) ? $current_value : $value; if (('state' == $field['Type']) && null !== $field['Value']) { $field['Value'] = $field['OldValue'] = intval($field['Value']); } } unset($field); if ($settings = $db->fetchRow($query)) { $this->settings($settings); } $db->freeResult($query); } else { throw new Samo_Exception('People not found (Inc=' . $people . ')'); } } return $this->fields; } private function settings($settings) { if (isset($settings['MaxInfantAge'])) { $this->infant_age($settings['MaxInfantAge']); unset($settings['MaxInfantAge']); } $ages = []; foreach (['MaxChildAge', 'MaxAge1', 'MaxAge2', 'MaxAge3'] as $option) { if (isset($settings[$option])) { if ($settings[$option] > 0) { $ages[] = $settings[$option]; } unset($settings[$option]); } } foreach (['TourInc', 'ClaimInc'] as $option) { if ((!array_key_exists($option, $this->packetinfo) || empty($this->packetinfo[$option])) && !empty($settings[$option])) { $this->packetinfo[$option] = $settings[$option]; } } foreach (['CheckIn', 'CheckOut'] as $option) { if ((!array_key_exists($option, $this->packetinfo) || empty($this->packetinfo[$option]) || ($this->packetinfo[$option] instanceof Samo_Datetime && $this->packetinfo[$option]->is_null())) && $settings[$option]->not_null()) { $this->packetinfo[$option] = $settings[$option]; } } if (count($ages)) { $age = max($ages); $this->child_age(floatval($age)); } $this->settings = $settings; } public function is_exists($inc = null) { if (null !== $inc) { $this->_is_exists = true; $this->inc = $inc; } return $this->_is_exists; } public function load_from_cl_wizard($people) { foreach (array('NAME', 'LNAME') as $name) { if (isset($people['LAST' . $name])) { $people[$name] = $people['LAST' . $name] . FIO_DELIMETER . $people['FIRST' . $name]; unset($people['LAST' . $name], $people['FIRST' . $name]); } } $date_fields = array('BORN', 'PVALID', 'PGIVEN', 'VEXPIRE'); foreach ($date_fields as $date_field) { $this->{$date_field} = $people[$date_field] = isset($people[$date_field]) ? Samo_Loader::load_object('Samo_Datetime', $people[$date_field]) : Samo_Datetime::null(); } $selectedState = $this->packetinfo['StateFromInc']; foreach ($people as $field => $value) { if (!in_array($field, $date_fields)) { $this->{$field} = (strlen($value)) ? trim($value) : ((in_array($field, array('PLACEBORN', 'NATIONALITY'))) ? $selectedState : null); } } $this->chid2infant(); $this->lname2name(); $this->self_test(); } public function load_from_array(array $_people) { $this->inc = intval($_people['key']); $this->HUMAN = isset($_people['human']) ? trim($_people['human']) : null; $this->MALE = isset($_people['sex']) ? intval($_people['sex']) : 0; $this->NAME = isset($_people['name']) ? trim($_people['name']) : null; $this->LNAME = isset($_people['lname']) ? trim($_people['lname']) : null; $this->BORN = Samo_Loader::load_object('Samo_Datetime', isset($_people['born']) ? $_people['born'] : null); $this->PSERIE = isset($_people['pserie']) ? trim($_people['pserie']) : null; $this->PNUMBER = isset($_people['pnumber']) ? trim($_people['pnumber']) : null; $this->PVALID = Samo_Loader::load_object('Samo_Datetime', isset($_people['pexpire']) ? $_people['pexpire'] : null); $stateFields = array('bornplaceKey' => 'PLACEBORN', 'nationalityKey' => 'NATIONALITY'); $defaultState = ($this->strict_check || !array_key_exists('StateFromInc', $this->packetinfo)) ? Samo::MAXLONGINT : $this->packetinfo['StateFromInc']; foreach ($stateFields as $inputField => $peopleField) { $this->{$peopleField} = (isset($_people[$inputField]) && $state = intval($_people[$inputField])) ? $state : $defaultState; } $this->PGIVEN = Samo_Loader::load_object('Samo_Datetime', isset($_people['pgiven']) ? $_people['pgiven'] : null); $this->PGIVENORG = isset($_people['pgivenorg']) ? trim($_people['pgivenorg']) : null; $this->ADDRESS = isset($_people['address']) ? trim($_people['address']) : null; $this->PHONE = isset($_people['phone']) ? trim($_people['phone']) : null; $this->EMAIL = isset($_people['email']) ? trim($_people['email']) : null; $this->MOBILE = isset($_people['mobile']) ? trim($_people['mobile']) : null; $this->VEXPIRE = Samo_Loader::load_object('Samo_Datetime', isset($_people['vexpire']) ? $_people['vexpire'] : null); $this->PLACEBORNDETAIL = isset($_people['bornplaceDetail']) ? trim($_people['bornplaceDetail']) : null; $this->INN = isset($_people['inn']) ? trim($_people['inn']) : null; $this->ADDITIONAL = (isset($_people['additional']) && $_people['additional']) ? true : false; $this->chid2infant(); $this->lname2name(); $this->self_test(); } public function lname2name() { if ($this->need_sync_names()) { $lnameIsEmpty = empty($this->LNAME); $nameIsEmpty = empty($this->NAME); if ($lnameIsEmpty || $nameIsEmpty) { $value = ($nameIsEmpty) ? $this->LNAME : $this->NAME; $this->NAME = $this->LNAME = $value; } } } public function chid2infant() { if ('CHD' === $this->HUMAN && $this->is_infant_age()) { $this->HUMAN = 'INF'; } } public function load($people, $filter = array()) { $return = array(); $fields = $this->fields($people); $exist = $this->is_exists($people); $_filter = count($filter); foreach ($fields as $field) { if (!$_filter || count(array_intersect_assoc($filter, $field)) === $_filter) { $field['attributes']['autocomplete'] = "off"; $field['css_classes'] = array($field['Type']); if (isset($field['Class']) && !empty($field['Class'])) { $field['css_classes'][] = $field['Class']; } if (!isset($return[$field['Group']])) { $return[$field['Group']] = array(); } if ('state' == $field['Type']) { $selectedState = $field['Value']; if ($selectedState == Samo::MAXLONGINT && isset($this->packetinfo['StateFromInc'])) { $selectedState = $this->packetinfo['StateFromInc']; } $field['Variants'] = $this->states($selectedState); } if ('state' == $field['Type'] || 'human' == $field['Type']) { if ($field['Value']) { $field['attributes']['data-loaded-value'] = $field['Value']; } } if ($field['Required']) { $field['css_classes'][] = 'required'; } if (isset($field['Mask']) && !empty($field['Mask'])) { $field['attributes']['data-mask'] = $field['Mask']; } if (!$field['HelpAlt'] && $field['PatternTitle']) { $field['attributes']['title'] = Samo_String::set($field['PatternTitle'])->safehtml(); } if (!$field['Visible']) { if ($field['Editable'] && $exist) { $field['Visible'] = 1; } } if ($field['Field'] == 'LNAME' || $field['Field'] == 'NAME') { $name = $field['Field']; $override_placeholder = !isset($field['attributes']['placeholder']); if (strpos($field['Value'], FIO_DELIMETER)) { $lastname = substr($field['Value'], 0, strpos($field['Value'], FIO_DELIMETER)); $firstname = substr($field['Value'], strpos($field['Value'], FIO_DELIMETER) + strlen(FIO_DELIMETER)); } else { $firstname = ''; $lastname = $field['Value']; } $field['Field'] = 'LAST' . $name; $field['Value'] = $lastname; $field['Title'] = $this->messages('TOURIST_LAST' . $name); if ($name == 'NAME') { $field['attributes']['data-translit_to'] = "LASTLNAME"; $field['css_classes'][] = "lastname"; $field['css_classes'][] = 'rus'; } else { $field['css_classes'][] = "lastlname"; } if ($override_placeholder) { $field['attributes']['placeholder'] = Samo_String::set($field['Title'])->upper()->safehtml(); } $return[$field['Group']][] = $field; $field['Field'] = 'FIRST' . $name; $field['Value'] = $firstname; $field['Title'] = $this->messages('TOURIST_FIRST' . $name); if ($name == 'NAME') { $field['attributes']['data-translit_to'] = "FIRSTLNAME"; $field['css_classes'][] = "firstname"; $field['css_classes'][] = 'rus'; } else { $field['css_classes'][] = "firstlname"; } if ($override_placeholder) { $field['attributes']['placeholder'] = Samo_String::set($field['Title'])->upper()->safehtml(); } $return[$field['Group']][] = $field; } else { if (!isset($field['attributes']['placeholder'])) { $field['attributes']['placeholder'] = Samo_String::set(('date' == $field['Type']) ? $this->messages('DATE_FORMAT') : $field['Title'])->upper()->safehtml(); } $return[$field['Group']][] = $field; } } } return $return; } public function states($defaultState = null) { $key = (null === $defaultState) ? '-1' : $defaultState; if (!isset($this->_states[$key])) { $sql = $this->db()->formatExec( '<ONLINEDB>.dbo.up_WEB_3_people_StateBorn', [ 'Selected' => $defaultState, 'UserCode' => $this->internet_user(), ] ); $states = $this->db()->fetchAll( $sql, function ($state) { $state['attributes'][] = sprintf('data-search-string="%s"', $state['searchTerms']); return $state; } ); $this->_states[$key] = ($states) ? $states : []; } return $this->_states[$key]; } protected function need_sync_names() { try { return $this->config('SYNC_NAME_LNAME', 'people'); } catch (Samo_Exception $e) { $e; } return true; } public function save($inc, array $people) { if (!intval($inc) || $inc < 0) { throw new Samo_Exception('People cannot be saved'); } $this->inc = $inc; foreach (array('NAME', 'LNAME') as $name) { if (isset($people['LAST' . $name])) { $people[$name] = $people['LAST' . $name] . (strlen($people['FIRST' . $name]) ? FIO_DELIMETER . $people['FIRST' . $name] : ''); unset($people['LAST' . $name], $people['FIRST' . $name]); } } $return = true; $check_unread = 0; $fields = array(); $__fields = $this->fields($inc); $_changes = array(); $name_changed = false; $lname_changed = false; foreach ($__fields as $field) { if (isset($people[$field['Field']])) { if ($field['Editable']) { $this->{$field['Field']} = $field['Value'] = isset($people[$field['Field']]) ? (('date' == $field['Type']) ? Samo_Loader::load_object('Samo_Datetime', $people[$field['Field']]) : ('state' == $field['Type'] ? intval($people[$field['Field']]) : $people[$field['Field']])) : null; if (Samo_People::BLANK !== $field['Value'] && ( ('date' == $field['Type'] && $field['OldValue']->ne($field['Value'])) || ('date' != $field['Type'] && $field['OldValue'] != $field['Value']) ) ) { $check_unread += $field['CheckUnread']; $name_changed = (!$name_changed && $field['Field'] == 'NAME') ? true : $name_changed; $lname_changed = (!$lname_changed && $field['Field'] == 'LNAME') ? true : $lname_changed; $_changes[$field['Field']] = $field; } } } $fields[$field['Field']] = $field; } if (($name_changed || $lname_changed) && $this->need_sync_names()) { if ($name_changed) { if (empty($fields['NAME']['Value'])) { $this->NAME = $fields['NAME']['Value'] = $fields['LNAME']['Value']; $_changes['NAME'] = $fields['NAME']; } elseif ((empty($fields['LNAME']['Value'])) || (!$fields['LNAME']['Editable'] && $fields['LNAME']['OldValue'] == $fields['NAME']['OldValue'])) { $this->LNAME = $fields['LNAME']['Value'] = $fields['NAME']['Value']; $_changes['LNAME'] = $fields['LNAME']; } } else { if (empty($fields['LNAME']['Value'])) { $this->LNAME = $fields['LNAME']['Value'] = $fields['NAME']['Value']; $_changes['LNAME'] = $fields['LNAME']; } elseif ((empty($fields['NAME']['Value'])) || (!$fields['NAME']['Editable'] && $fields['LNAME']['OldValue'] == $fields['NAME']['OldValue'])) { $this->NAME = $fields['NAME']['Value'] = $fields['LNAME']['Value']; $_changes['NAME'] = $fields['NAME']; } } } unset($__fields, $field); $db = $this->db(); $this->self_test(); if (count($_changes)) { $return = false; $proc_params = array(); $changes = array(); foreach ($_changes as $field) { $proc_params[$field['EntityField']] = $field['Value']; $changes[$field['EntityField']] = array('old' => $field['OldValue'], 'new' => $field['Value']); } $proc_params['people'] = $this->inc; $proc_params['ProcTestInternal'] = PROC_TESTPEOPLE_INTERNEL; $proc_params['check_unread'] = $check_unread > 0 ? 1 : 0; $proc_params['skip_claim_check'] = intval(!$this->strict_check); $proc_params['UserCode'] = $this->internet_user(); $proc_params['LangId'] = $this->langId(); $proc_params['PartPass'] = $this->packetinfo->PARTPASS; $log = array( 'partpass' => $this->packetinfo->PARTPASS, 'claim' => $this->packetinfo->ClaimInc, 'message' => 'edit_tourist', 'result' => array('changes' => $changes), 'priority' => 'edit_tourist', ); $msgid = $db->web_log_table($log); $errorMsg = false; try { $query = $db->exec('<OFFICEDB>.dbo.up_WEB_5_people_Edit', $proc_params); } catch (Database_Exception $e) { $query = false; $log['priority'] = 'err'; $log['result']['db_error'] = $db->lastError(); $errorMsg = $this->messages('DATABASE_ERROR'); } $log['sql'] = $db->getSql(); if ($query) { if ($result = $db->fetchRow()) { if (isset($result['error'])) { $errorMsg = $result['error']; $log['priority'] = 'warning'; $log['result']['proc_error'] = $errorMsg; } elseif ($result['Inc'] > 0) { $return = true; } else { $log['priority'] = 'warning'; $log['result']['return'] = $result; } } else { $log['priority'] = 'err'; $log['result']['db_error'] = $db->lastError(); $errorMsg = $this->messages('DATABASE_ERROR'); } $db->freeResult(); } $db->web_log_table($log, $msgid); if ($errorMsg) { throw new Samo_Exception($errorMsg, 1); } } return $return; } public function customer_rules() { } public function __toString() { if (DEBUG) { $result = array(); foreach (array('inc', 'HUMAN', 'MALE', 'NAME', 'LNAME', 'BORN', 'PSERIE', 'PNUMBER', 'PVALID', 'PLACEBORN', 'NATIONALITY', 'PGIVEN', 'PGIVENORG', 'ADDRESS', 'PHONE', 'EMAIL', 'MOBILE', 'VEXPIRE', 'PLACEBORNDETAIL', 'INN') as $field) { $result[] = sprintf("\t\t%s => %s", $field, (string)$this->{$field}); } return PHP_EOL . implode(PHP_EOL, $result); } else { return sprintf("%s %s", $this->HUMAN, $this->LNAME); } } public function infant_age($age = null) { if (null !== $age) { $this->infant_age = $age; } return $this->infant_age; } public function child_age($age = null) { if (null !== $age) { $this->child_age = $age; } return $this->child_age; } public function mustBeAdultPassport() { return $this->mustBeAdultPassport; } } class Samo_People_Exception extends Samo_Exception { protected $errors; public function __construct($message, array $errors) { $this->errors = $errors; parent::__construct($message, 2); } public function getErrors() { return $this->errors; } } 