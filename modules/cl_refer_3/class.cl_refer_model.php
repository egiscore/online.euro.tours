<?php
 class Cl_Refer_Model extends Samo_Claim { protected $auth_required = array('agency'); public $edoc_confirm = false; private $errors = array(); private $crypto = null; protected $decrypted_params = null; protected $show_calculated = true; public function construct($claim = null, $people = null, $order = null) { parent::construct($claim, $people, $order); $this->defaults['PARTTYPE'] = $_SESSION['samo_auth']['Parttype']; $this->defaults['OFFICIAL_NAME'] = $_SESSION['samo_auth']['OfficialName']; $this->defaults['LIMIT_EDOC'] = $this->getConfig('LIMIT_EDOC'); } public function getPages($max) { return $this->pager($max, $this->defaults['CLAIMPAGE'], CL_REFER_LINKS_ON_PAGE); } public function uploadedFiles() { $res = []; $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_3_claim_Documents', [ 'Claim' => $this->defaults['CLAIM'], 'upload_online' => 1, ] ); if ($links = $this->db->fetchAll($sql)) { foreach ($links as $link) { if ($link['is_file']) { $vars = [ 'm' => 'cl_refer', 'd' => $link['DocInc'], ]; $url = $this->documentLink('cl_refer', 'DOWNLOAD', $vars); $type = 'external'; } else { $type = ''; $url = Samo_Url::parse($link['DocUrl']); } $res[] = array( 'td' => (($link['PeopleName']) ? $link['PeopleName'] . '<br>' : '') . $link['DocName'], 'a' => $url, 'module' => 'claim_documents', 't' => $link['DocTypeName'], 'type' => $type, 'error' => '', 'document_status_inc' => $link['DocumentStatusInc'], 'document_status' => $link['DocumentStatusName'], 'status_note' => $link['StatusNote'], 'DocInc' => $link['DocInc'], ); } } return $res; } public function E_DOC_UPLOAD() { $messages = Samo_Registry::get('messages'); if (!empty($_FILES)) { $edoc_upload_type = Samo_Request::intval('EDOC_UPLOAD_DOCTYPE'); if (null !== $edoc_upload_type) { $file_path = $_FILES["edoc_file"]["tmp_name"]; if (Samo_Request::is_uploaded_file($file_path)) { $size = $_FILES["edoc_file"]["size"]; $samo_document = Samo_Loader::load_object('Samo_Document'); $samo_document->construct(); $edoc_types = $samo_document->EDOC_Types(); $edoc_type = $edoc_types[$edoc_upload_type]; if ($size == 0) { throw new Samo_Exception($messages['UPLOAD_ZERO_SIZE']); } if ($size > $edoc_type['upload_size']) { $limit = ceil($edoc_type['upload_size'] / 1024); $exp = 'Kb'; if ($limit > 1024) { $limit = ceil($limit / 1024); $exp = 'Mb'; } throw new Samo_Exception(sprintf($messages['UPLOAD_MAX_SIZE'], $limit . $exp)); } $filename = explode(".", strtolower($_FILES["edoc_file"]["name"])); $type = end($filename); if (in_array($type, $edoc_type['upload_format'])) { if (!$edoc_type['upload_req_people'] || ($edoc_type['upload_req_people'] && $this->defaults['PEOPLE'] > 0)) { $file_content = file_get_contents($file_path); $sql = $this->db->formatExec( $this->OFFICE_SQLSERVER . '.' . $this->OFFICEDB . '.dbo.up_external_document_edit', array( 'Inc' => null, 'Claim' => $this->defaults['CLAIM'], 'People' => $this->defaults['PEOPLE'], 'Name' => $_FILES["edoc_file"]["name"], 'MimeType' => $_FILES["edoc_file"]["type"], 'Content' => $file_content ? '0x' . bin2hex($file_content) : null, 'FileName' => $_FILES["edoc_file"]["name"], 'Doctype' => $edoc_type['id'], 'IP' => Samo_Request::remote_addr(), 'PARTPASS' => $this->getPartPassInc(), 'USER' => $this->internet_user(), 'Incoming' => 1, ) ); return $this->db->fetchRow($sql); } else { throw new Samo_Exception($messages['UPLOAD_EMPTY_TOURIST']); } } throw new Samo_Exception($messages['UNSUPPORTED_FORMAT_UPLOAD_FILE']); } } throw new Samo_Exception($messages['NO_CHOOSE_UPLOAD_FILE_TYPE']); } throw new Samo_Exception($messages['ERROR_ON_SEND_FILE']); } public function cl_refer_claimCost() { $return = array(); $return['now'] = $this->claimCost(); $this->claimcost_datetype = 'DATE'; $tomorrow_date = Samo_Datetime::parse('tomorrow'); $this->claimcost_rate_date = $tomorrow_date; $return['tomorrow'] = $this->claimCost(); if (isset($return['tomorrow'][1]) && $return['tomorrow'][1]['rate_dateex']->ne($tomorrow_date)) { $return['tomorrow'][0]['rate_dateex'] = $tomorrow_date; $return['tomorrow'][1]['rate_dateex'] = $tomorrow_date; $return['tomorrow'][1]['Catalog'] = ''; $return['tomorrow'][1]['Amount'] = ''; $return['tomorrow'][1]['Paid'] = ''; $return['tomorrow'][1]['Debt'] = ''; $return['tomorrow'][1]['Commiss'] = ''; } return $return; } public function auth_required() { if (in_array($this->action, array('E_DOC', 'document', 'PEOPLES', 'PDF_SAMOTOUR', 'DOWNLOAD', 'REDIRECT', 'UPLOAD_EDOC', 'E_DOC_TAB_ADD', 'CLAIM_CONFIRM_PREORDER', 'CHOOSE_FRPLACEMENT', 'SAVE_FRPLACEMENT'))) { return array_unique(array_merge($this->auth_required, array('person'))); } return $this->auth_required; } public function GetPaymentSchedule() { if ($this->defaults['claim_info']['paymentschedule']) { $sql = "exec " . $this->OFFICE_SQLSERVER . "." . $this->OFFICEDB . ".dbo.up_WEB_3_get_claim_paymentschedule @CLAIM=" . $this->defaults['CLAIM']; return $this->db->fetchAll($sql); } return false; } public function andr_document($doc, $type) { $return = false; $old_db_error = $this->db->errorField(); $this->db->errorField('error'); $sql = "exec " . $this->OFFICE_SQLSERVER . "." . $this->OFFICEDB . ".[dbo].[sl_andr_GetDocById] @Claim=" . $this->defaults['CLAIM'] . ', @id =' . $this->db->quote($doc) . ', @json_soap = ' . $this->db->quote($type == 'soap'); if ($row = $this->db->fetchRow($sql)) { if ($row['id'] == $doc && !empty($row['url'])) { $fname = basename($row['url']); $tmp = explode('.', $fname); $ext = end($tmp); $file = 'dnl/ext_' . md5($doc) . '.' . $ext; if (!file_exists(_ROOT . $file)) { $document = file_get_contents($row['url']); if (Samo_Utils::writeFile(_ROOT . $file, $document)) { $return = $file; } } else { $return = $file; } } } $this->db->errorField((null === $old_db_error) ? false : $old_db_error); if (!$return) { $messages = Samo_Registry::get('messages'); throw new Samo_Exception($messages['CL_DOC_CANNOT_FETCH'], 503); } return $return; } final public function documentList($claim = null, $partpass = null, $docCategory = null) { $claim = (null === $claim) ? $this->defaults['CLAIM'] : $claim; $partpass = (null === $partpass) ? $this->getPartPassInc() : $partpass; $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_3_claim_DocCategoryList', [ 'Claim' => $claim, 'PartPass' => $partpass, 'DocCategory' => $docCategory, 'UserCode' => $this->internet_user(), 'LangId' => Samo_Request::langid(), 'Developer' => (APPMODE == 'dev') ? 1 : 0, ] ); $query = $this->db->query($sql); $rows = Samo_Utils::ifs($this->db->fetchAll($query), []); $rows = $this->preFilterDocuments($rows); $res = []; foreach ($rows as $document) { if (1 == $document['Visible'] && (null != $docCategory || !in_array($document['Module'], ['invoice', 'psbank']))) { $type = ''; $link = ''; $error = ''; $module = $document['Module']; if (!$document['Enabled']) { if ($document['Reason']) { $error = ErrorCode::toString($document['Reason']); if (!$document['ErrorText']) { $document['ErrorText'] = $error; } switch ($document['Reason']) { case 1000045: if (is_array($error)) { if (intval($document['DaysBeforeTour']) < floatval($document['DaysBeforeTour'])) { $idx = 1; } else { $n = abs($document['DaysBeforeTour']) % 100; $n1 = $n % 10; if ($n > 10 && $n < 20) { $idx = 2; } else { if ($n1 > 1 && $n1 < 5) { $idx = 1; } else { if ($n1 == 1) { $idx = 0; } else { $idx = 2; } } } } $error = isset($error[$idx]) ? $error[$idx] : reset($error); } $error = sprintf($error, $document['DaysBeforeTour']); break; default: $error = (is_array($error)) ? reset($error) : $error; break; } } } else { if ($document['ExternalUrl']) { if ($document['ExternalDocument']) { $vars = [ 'm' => $document['Module'], 'd' => $document['ExternalDocument'], 'dc' => $document['DocCategory'], 'o' => $document['Order'], 'p' => $document['People'], 'op' => $document['OPeople'], 's' => $document['SetIssued'], ]; $link = $this->documentLink('cl_refer', 'REDIRECT', $vars); } else { $link = $document['ExternalUrl']; } } elseif ($document['ExternalDocument']) { $vars = [ 'm' => $document['Module'], 'd' => $document['ExternalDocument'], 'dc' => $document['DocCategory'], 'o' => $document['Order'], 'p' => $document['People'], 'op' => $document['OPeople'], 's' => $document['SetIssued'], ]; $link = $this->documentLink('cl_refer', 'DOWNLOAD', $vars); $type = 'external'; } elseif (($document['PrintType'] == 2) && !in_array($module, ['voucher', 'insurance']) && !$this->is_module_installed($module)) { continue; } elseif ($document['Template']) { if (1 == $document['TemplateFastReport']) { $vars = [ 'tpl' => $document['TemplateVars'] . ';template=' . $document['Template'], 'm' => $document['Module'], 'dc' => $document['DocCategory'], 'op' => $document['OPeople'], 's' => $document['SetIssued'], ]; $link = $this->documentLink('cl_refer', 'PDF_SAMOTOUR', $vars); $error = ''; $type = 'external'; } else { if (!$this->lookupLegacyTemplate($document['DocCategory'], $document['Template'])) { $link = ''; $error = $this->messages['TEMPLATE_NOT_INSTALL']; } else { if ($this->is_module_installed($module)) { parse_str(str_replace(';', '&', $document['TemplateVars']), $vars); switch ($document['Module']) { case 'aviaticket': $vars['ORDERINC'] = $vars['ORDER']; $vars['PEOPLEINC'] = $vars['PEOPLE']; if (!empty($vars['DOCUM'])) { $vars['TICKET'] = (string)Samo_String::set($vars['DOCUM'])->utf8(); } $vars['samo_action'] = 'PDF_TICKET'; unset($vars['ORDER'], $vars['PEOPLE']); break; case 'insurance': $vars['ORDERINC'] = $vars['ORDER']; unset($vars['ORDER']); break; case 'voucher': $vars['ORDERINC'] = $vars['ORDER']; $vars['VOUCHER_PEOPLES'] = $vars['PEOPLE']; $vars['samo_action'] = 'PDF_DOCUMENT'; unset($vars['ORDER'], $vars['PEOPLE']); break; default: break; } unset($vars['DOCUM'], $vars['OPEOPLE']); if ($proxy_action = Samo_Request::get('proxy_action')) { $vars['target'] = $document['Module']; $vars['proxy_action'] = isset($vars['samo_action']) ? $vars['samo_action'] : 'default_action'; $vars['samo_action'] = 'proxy_action'; $route = 'cl_refer_person'; } else { $route = $document['Module']; } $link = Samo_Url::route($route, $vars); } else { $error = $this->messages['MODULE_NOT_INSTALLED']; } } } } else { $error = $this->messages['TEMPLATE_NOT_CONFIGURE']; } } $doc = [ 't' => $document['DocumentCategoryName'], 'td' => $document['PeopleLName'] . (($document['PeopleLName']) ? PHP_EOL : '') . $document['DocumentName'], 'a' => $link, 'module' => $module, 'type' => $type, 'error' => $error, 'odate' => $document['ODate'], 'data' => $document, ]; $res[] = $doc; } } $res = $this->postFilterDocuments($res); return $res; } protected function crypto() { if (null == $this->crypto) { $aes = new Samo_CryptAes(TOOLSPROTECT . SAMOGUID); $this->crypto = $aes; } return $this->crypto; } protected function documentLink($module, $action, $vars) { $data = base64_encode( $this->crypto()->encrypt( gzcompress( http_build_query($vars) ) ) ); $vars = [ 'CLAIM' => $this->defaults['CLAIM'], 'samo_action' => $action, 'data' => $data, ]; $route = (Samo_Request::get('proxy_action')) ? 'cl_refer_person' : $module; if ($route == 'cl_refer_person') { $vars['target'] = $module; $vars['proxy_action'] = $vars['samo_action']; $vars['samo_action'] = 'proxy_action'; } return Samo_Url::route($route, $vars); } public function preFilterDocuments($rows) { return $rows; } public function postFilterDocuments($documents) { return $documents; } protected function decryptParams() { if (null === $this->decrypted_params) { $data = Samo_Request::get('data'); if (null !== $data) { $aes = $this->crypto(); $data = $aes->decrypt(base64_decode($data)); if ($data) { $data = gzuncompress($data); if ($data) { parse_str($data, $vars); if (is_array($vars) && array_key_exists('tpl', $vars)) { $params = str_replace(';', '&', $vars['tpl']); parse_str($params, $tpl); $vars['tpl'] = $tpl; } $this->decrypted_params = $vars; } } if (!$this->decrypted_params) { throw new Samo_Exception('Broken link', 400); } } } return $this->decrypted_params; } public function linkedDocument() { $return = false; $params = $this->decryptParams(); if ($params) { if (array_key_exists('u', $params)) { $return = $params['u']; } else { $document = array_key_exists('d', $params) ? $params['d'] : null; if ($document) { $prefix = array_key_exists('m', $params) ? $params['m'] : 'edoc'; $prefix .= '_' . $this->defaults['CLAIM']; $prefix .= '_' . $document; $file = Samo_Utils::findFile(_ROOT . 'dnl', $prefix . '*'); if ($file) { $return = WWWROOT . 'dnl/' . $file; $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_5_claim_document', [ 'Claim' => $this->defaults['CLAIM'], 'Document' => $document, 'UserCode' => $this->internet_user(), 'Partpass' => $this->getPartPassInc(), 'OnlyHistory' => 1, ] ); $this->db->query($sql); $this->db->freeResult(); } else { $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_5_claim_document', [ 'Claim' => $this->defaults['CLAIM'], 'Document' => $document, 'UserCode' => $this->internet_user(), 'Partpass' => $this->getPartPassInc(), 'OnlyHistory' => 0, ] ); $this->db->rawMode(true); if ($res = $this->db->fetchRow($sql)) { if (!isset($res['Url']) || empty($res['Url'])) { $return = Samo_Utils::tempFile($prefix, $res['FileName'], $res['Content']); } else { $return = $res['Url']; } } $this->db->rawMode(false); } if ($return) { $module = array_key_exists('m', $params) ? $params['m'] : null; $claim = $this->defaults['CLAIM']; $order = array_key_exists('o', $params) ? $params['o'] : null; $people = array_key_exists('p', $params) ? $params['p'] : null; $opeople = array_key_exists('op', $params) ? $params['op'] : null; if (in_array($params['dc'], [DocCategory::VOUCHER, DocCategory::INSURANCE_MEDICAL, DocCategory::INSURANCE_CANCEL])) { $this->setDistributedDocum($params['dc'], $claim, $people, $order, $opeople); } elseif ($module && $this->is_module_installed($module)) { $model = Samo_Loader::load_object(ucwords($module . '_Model', '_'), $this->config); if (method_exists($model, 'markIssued')) { $model->construct($claim, $people, $order); $model->defaults['DOCCATEGORY'] = $params['dc']; $model->markIssued($claim, $people, $order, null, null); } } } } } } return $return; } public function setDistributedDocum($doccategory, $claim = null, $peoples = null, $orders = null, $opeople = null) { $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_4_setDistributedDocum', [ 'Doccategory' => $doccategory, 'Claim' => $claim, 'Peoples' => $peoples, 'Orders' => $orders, 'OPeople' => $opeople, 'LangId' => samo_request::langid(), 'SetDistributedDocum' => 1, 'UserCode' => $this->internet_user(), 'Partpass' => $this->getPartPassInc(), ] ); $result = $this->db->fetchRow($sql); if (isset($result['error'])) { throw new Samo_Exception($result['error'], $result['error_code']); } return true; } protected function getExternalDocumentInit($claim = null) { $params = $this->decryptParams(); $key = md5(serialize($params)); if ($params) { $doccategory = array_key_exists('m', $params) ? $params['m'] : 'cl_refer'; $claim = (null === $claim) ? $this->defaults['CLAIM'] : $claim; if ($params['dc'] == DocCategory::UNKNOWN) { $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_3_claim_CustomDocument', [ 'Claim' => $claim, 'UserCode' => $this->internet_user(), 'LangId' => Samo_Request::langid(), 'Template' => $params['tpl']['template'], ] ); if (!$this->db->fetchOne($sql)) { $messages = Samo_Registry::get('messages'); throw new Samo_Exception($messages['CANNOT_PRINT']); } } else { if (!isset($_SESSION['external_job']) || !isset($_SESSION['external_job'][$key])) { if ($this->is_module_installed($doccategory)) { $tpl = array_key_exists('tpl', $params) ? $params['tpl'] : []; $order = array_key_exists('ORDER', $tpl) ? $tpl['ORDER'] : null; $people = array_key_exists('PEOPLE', $tpl) ? $tpl['PEOPLE'] : null; $opeople = array_key_exists('OPEOPLE', $tpl) ? $tpl['OPEOPLE'] : null; $docum = array_key_exists('DOCUM', $tpl) ? $tpl['DOCUM'] : ''; if (in_array($params['dc'], [DocCategory::UNKNOWN, DocCategory::VOUCHER, DocCategory::SERVICE_VOUCHER, DocCategory::INSURANCE_MEDICAL, DocCategory::INSURANCE_CANCEL])) { $this->setDistributedDocum($params['dc'], $this->defaults['CLAIM'], $people, $order, $opeople); } else { $model = Samo_Loader::load_object(ucwords($doccategory . '_Model', '_'), $this->config); if (method_exists($model, 'markIssued')) { $model->construct($this->defaults['CLAIM'], $people, $order); $model->defaults['DOCCATEGORY'] = $params['dc']; $model->markIssued($this->defaults['CLAIM'], $people, $order, $opeople, $docum); } } } } } return $this->getExternalDocumentJob($key, sprintf('%s_%s_%%d_%%s.pdf', $doccategory, $claim)); } $messages = Samo_Registry::get('messages'); throw new Samo_Exception($messages['CANNOT_PRINT']); } protected function getExternalDocumentParams() { $params = $this->decryptParams(); $params = array_key_exists('tpl', $params) ? $params['tpl'] : null; if (null === $params) { $messages = Samo_Registry::get('messages'); throw new Samo_Exception($messages['CANNOT_PRINT']); } return $params; } private function freightPeoples() { $this->claimInfo(); $claimPeoples = $this->claimPeoples(); $peoples_by_order = $this->peoples_by_order(); $peoples_without_add_infant = array_filter( $peoples_by_order, function ($people) { return $people['AddInfant'] == 0; } ); $peoples = array_filter( $claimPeoples, function ($people) use ($peoples_without_add_infant) { return array_key_exists($people['Inc'], $peoples_without_add_infant); } ); $add_infant = false; if (count($peoples_by_order) > count($peoples_without_add_infant)) { $infants = array_filter( $peoples_by_order, function ($people) { return $people['AddInfant'] == 1; } ); $infants = array_filter( $claimPeoples, function ($people) use ($infants) { return array_key_exists($people['Inc'], $infants); } ); $add_infant = reset($infants); } $peoples = array_map( function ($people) use ($peoples_without_add_infant, $add_infant) { $people['key'] = $people['Inc']; $people['name'] = $people['Name'] . ($add_infant ? ', INF ' . $add_infant['Name'] : ''); $people['lname'] = $people['LName'] . ($add_infant ? ', INF ' . $add_infant['LName'] : ''); $people['human'] = $people['Human']; $people['born'] = $people['Born']; $people['opeople'] = $peoples_without_add_infant[$people['Inc']]['OPeopleInc']; return $people; }, $peoples ); return $peoples; } public function freightBoarding() { $this->claimInfo(); $freight = Samo_Request::post('freight'); $frplacement = Samo_Loader::load_object('FreightBoarding'); $frplacement->setTour($this->defaults['claim_info']['TourInc']); $frplacement->setCdate($this->defaults['claim_info']['CDate']); $frplacement->setFreight($freight['key']); $frplacement->setDateBeg(Samo_Datetime::parse($freight['datebeg'])); $frplacement->setDateEnd(Samo_Datetime::parse($freight['dateend'])); $frplacement->setClass($freight['classKey']); $frplacement->setPeoples($this->freightPeoples()); $frplacement->setClaim($this->defaults['CLAIM']); return $frplacement->boarding(); } public function saveBoarding() { $result = []; $seats = Samo_Request::post('seats'); if (is_array($seats)) { $peoples = $this->freightPeoples(); $frplacement = Samo_Loader::load_object('FreightBoarding'); foreach ($peoples as $people) { if (array_key_exists($people['opeople'], $seats)) { if (false !== $frplacement->save($people['opeople'], $seats[$people['opeople']])) { if ($seats[$people['opeople']]) { $result[$people['opeople']] = $seats[$people['opeople']]; } } else { $this->errors[] = $frplacement->getLastError(); } unset($seats[$people['opeople']]); } } } if (count($seats)) { $this->errors[] = 'Unknown opeople -> seat: ' . var_export($seats, true); } return $result; } public function getClaims() { $return = parent::getClaims(); if (count($return) > 0) { $claims = array(); foreach ($return as $row) { $claims[] = $row['Inc']; if ($row['cl_getBonus']) { $getBonus[] = $row['Inc']; } } $orderByName = $this->config('ORDER_BY_NAME'); $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_5_claim_Banner', [ 'claims' => implode(',', $claims), 'UserCode' => $this->internet_user(), 'ORDER_BY_NAME' => $orderByName, ] ); if (false !== ($res = $this->db->fetchAll($sql))) { foreach ($return as &$row) { foreach ($res as $row2) { if ($row['Inc'] == $row2['claim']) { $row['Banner'][] = $row2; } } } } if (!empty($getBonus)) { $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_Online_calc_bonus_claim', [ 'ClaimList' => $getBonus, ] ); if (false !== ($res = $this->db->fetchAll($sql))) { foreach ($return as &$row) { foreach ($res as $row2) { if ($row['Inc'] == $row2['claim']) { if ((double)$row2['bonus_value'] > 0) { $row['BonusList'] = $row2; } } } } } } } return $return; } public function ClaimConfirmPreOrder() { $claim = $this->defaults['CLAIM']; $partpass = Samo_Utils::ifs($this->getPartPassInc(), 'null'); $bron = Samo_Utils::ifs(Samo_Request::intval('CLAIM_CONFIRM_PREORDER_BRON'), false); $test = !$bron; $price = Samo_Utils::ifs(Samo_Request::intval('CLAIM_CONFIRM_PREORDER_PRICE'), null); $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_3_Claim_Confirm_Preorder', [ 'Claim' => $claim, 'test' => $test, 'price' => $price, 'CustomerType' => $_SESSION['samo_auth']['type'], 'LangId' => Samo_Request::langid(), 'PartPass' => $partpass, 'UserCode' => $this->internet_user(), ] ); $log = array( 'partpass' => $partpass, 'sql' => $sql, 'claim' => $claim, 'message' => ($test) ? 'CHECK' : 'SAVE', 'priority' => 'ClaimConfirmPreOrder', ); $msgid = $this->db->web_log_table($log); try { $row = $this->db->fetchRow($sql); $log['result']['resultset'] = $row; } catch (Samo_Exception $e) { $row = false; $log['result']['error'] = ($e instanceof Database_Exception) ? $this->db->lastError() : $e->getMessage(); } $this->db->web_log_table($log, $msgid); return $row; } public function getErrors() { return $this->errors; } public function showCalculated() { return $this->show_calculated; } public function getPartnerClaim() { $result = false; $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_3_claim_PartnerClaim', array( 'partpass' => $this->defaults['PARTPASS'], 'UserCode' => $this->internet_user(), ) ); if (false !== ($res = $this->db->fetchAll($sql))) { if (count($res) > 1) { $result[] = array( 'inc' => 0, 'name' => '---', 'tags' => '', ); foreach ($res as $row) { $result[] = array( 'inc' => $row['inc'], 'name' => $row['name'], 'tags' => $row['name'], ); } } } return $result; } public function getStateClaim() { $result = false; $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_3_claim_StateClaim', array( 'partpass' => $this->defaults['PARTPASS'], 'UserCode' => $this->internet_user(), ) ); if (false !== ($res = $this->db->fetchAll($sql))) { if (count($res) > 1) { $result[] = array( 'inc' => 0, 'name' => '---', 'tags' => '', ); foreach ($res as $row) { $result[] = array( 'inc' => $row['inc'], 'name' => $row['name'], 'tags' => $row['name'], ); } } } return $result; } public function getManagerClaim() { $result = false; $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_5_claim_Manager', array( 'partpass' => $this->defaults['PARTPASS'], 'UserCode' => $this->internet_user(), ) ); if (false !== ($res = $this->db->fetchAll($sql))) { if (count($res) > 1) { $result[] = array( 'inc' => 0, 'name' => '---', 'tags' => '', ); foreach ($res as $row) { $result[] = array( 'inc' => $row['inc'], 'name' => $row['name'], 'tags' => $row['name'], ); } } } return $result; } } 