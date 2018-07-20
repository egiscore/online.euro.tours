<?php
 class Samo_Document extends Samo { public function EDOC_Types() { $inc = Samo_Utils::ifs(Samo_Request::intval('EDOC_UPLOAD_DOCTYPE'), null); $messages = Samo_Registry::get('messages'); $result = array(); $result[0] = array('id' => 0, 'name' => $messages['E_DOC_TYPE_UPLOAD_FILE'], 'nameAlt' => $messages['E_DOC_TYPE_UPLOAD_FILE'], 'note' => '', 'upload_format' => '', 'selected' => false); $sql = '<OFFICEDB>.dbo.up_WEB_3_Edoc_Types'; $upload_max_size = function () { $from = ini_get('upload_max_filesize'); $number = intval($from); $exp = strtoupper(str_replace($number, "", $from)); if (substr($exp, -1) != 'B') { $exp .= 'B'; } switch ($exp) { case "KB": return $number * 1024; case "MB": return $number * pow(1024, 2); case "GB": return $number * pow(1024, 3); case "TB": return $number * pow(1024, 4); case "PB": return $number * pow(1024, 5); default: return $from; } }; $upload_max_size = $upload_max_size(); if ($res = $this->db->fetchAll($sql)) { foreach ($res as $row) { $result[$row['Inc']] = array( 'id' => $row['Inc'], 'name' => $row['LName'], 'nameAlt' => $row['Name'], 'note' => $row['Note'], 'upload_format' => explode(', ', $row['upload_format']), 'upload_size' => (1 == $row['upload_size']) ? $upload_max_size : min($row['upload_size'] * 1024, $upload_max_size), 'selected' => $row['Inc'] == $inc, 'upload_req_people' => $row['upload_req_people'], ); } } return $result; } public function E_DOC_UPLOAD() { $messages = Samo_Registry::get('messages'); if (!empty($_FILES)) { $edoc_upload_type = Samo_Request::intval('EDOC_UPLOAD_DOCTYPE'); $CONTRACTS_DOCUMENT_INC = Samo_Utils::ifs(Samo_Request::intval('CONTRACTS_DOCUMENT_INC'), null); if (null !== $edoc_upload_type && null !== $CONTRACTS_DOCUMENT_INC) { $file_path = $_FILES["edoc_file"]["tmp_name"]; if (Samo_Request::is_uploaded_file($file_path)) { $size = $_FILES["edoc_file"]["size"]; $edoc_types = $this->EDOC_Types(); $edoc_type = $edoc_types[$edoc_upload_type]; if ($size == 0) { throw new Samo_Exception($messages['UPLOAD_ZERO_SIZE']); } if ($size > $edoc_type['upload_size']) { $limit = ceil($edoc_type['upload_size'] / 1024); $exp = 'Kb'; if ($limit > 1024) { $limit = ceil($limit / 1024); $exp = 'Mb'; } throw new Samo_Exception(sprintf($messages['UPLOAD_MAX_SIZE'], $limit . $exp)); } $type = strtolower(pathinfo($_FILES["edoc_file"]["name"], PATHINFO_EXTENSION)); if (in_array($type, $edoc_type['upload_format'])) { $file_content = file_get_contents($file_path); $sql = $this->db->formatExec( '<OFFICEDB>.[dbo].[up_WebST_Contracts_Document_Edit]', array( 'Inc' => $CONTRACTS_DOCUMENT_INC, 'Name' => $_FILES["edoc_file"]["name"], 'Content' => $file_content ? '0x' . bin2hex($file_content) : null, 'user' => $this->internet_user(), ) ); $return = false; $allDocuments = $this->db->fetchAll($sql); foreach ($allDocuments as $document) { if ($document['ContractsDocumentInc'] == $CONTRACTS_DOCUMENT_INC) { $return = $document; break; } } return $return; } throw new Samo_Exception($messages['UNSUPPORTED_FORMAT_UPLOAD_FILE']); } } throw new Samo_Exception($messages['NO_CHOOSE_UPLOAD_FILE_TYPE']); } throw new Samo_Exception($messages['ERROR_ON_SEND_FILE']); } public function E_DOC_DETACH() { $edoc_upload_type = Samo_Request::intval('EDOC_UPLOAD_DOCTYPE'); $CONTRACTS_DOCUMENT_INC = Samo_Utils::ifs(Samo_Request::intval('CONTRACTS_DOCUMENT_INC'), null); if (null !== $edoc_upload_type && null !== $CONTRACTS_DOCUMENT_INC) { $sql = $this->db->formatExec( '<OFFICEDB>.[dbo].[up_WebST_Contracts_Document_Edit]', [ 'Inc' => $CONTRACTS_DOCUMENT_INC, 'Name' => null, 'Content' => null, 'user' => $this->internet_user(), ] ); return $this->db->fetchRow($sql); } } public function E_DOC_GET_DOCUMENT($doc) { $return = false; $cwd = getcwd(); chdir(_ROOT . 'dnl/'); $prefix = 'edoc_agreement_' . $doc . '_'; $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WebST_Contracts_Document_Content', [ 'Contracts_DocumentInc' => $doc, ] ); $this->db->rawMode(true); if ($res = $this->db->fetchRow($sql)) { if (!isset($res['Url']) || empty($res['Url'])) { $filename = $this->gen_filename($prefix, $res['FileName']); if (false !== Samo_Utils::writeFile($filename, $res['Content'])) { $return = WWWROOT . 'dnl/' . $filename; } } else { $return = $res['Url']; } } $this->db->rawMode(false); chdir($cwd); return ($return) ? $return : false; } } 