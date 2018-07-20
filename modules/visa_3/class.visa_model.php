<?php
 class Visa_Model extends Samo_Claim { protected $auth_required = array('agency', 'person'); protected $messages = null; public $SetDistributedDocum = 1; public function construct($claim = null, $people = null, $order = null) { parent::construct($claim, $people, $order); $this->messages = Samo_Registry::get('messages'); $this->defaults['ORDERINC'] = Samo_Utils::ifs(Samo_Request::intval('ORDERINC'), 0); $this->defaults['PEOPLE'] = Samo_Request::intval('PEOPLE'); $this->defaults['URL'] = isset($_GET['URL']) ? $_GET['URL'] : ''; } public function markIssued($claim = null, $people = null, $order = null, $opeople = null, $docum = '') { $this->defaults['ORDERINC'] = $order; $this->defaults['PEOPLE'] = $people; return $this->SaveVisa(); } public function is_enabled() { $clRefer = Samo_Loader::load_object('Cl_Refer_Model', $this->config); $clRefer->construct(); $documents = $clRefer->documentList(null, null, DocCategory::VISA); $defaults = $this->defaults; $documents = array_filter( $documents, function($document) use ($defaults){ $data = $document['data']; return $data['Order'] == implode(',', $defaults['ORDERINC']) && $data['People'] == implode(',', $defaults['PEOPLE']); } ); if (count($documents)) { $document = reset($documents); $data = $document['data']; if ($data['Enabled']) { return true; } } return false; } public function SaveVisa() { if ($res = $this->SetDistributed()) { if ($res = $this->SetIssuedDocum()) { $res = true; } } return $res; } public function SetDistributed() { if ($this->claimInfo()) { $error = ''; if (!$this->has_permission('visa')) { $messages = Samo_Registry::get('messages'); $error = $messages['CL_DOC_PRINT_DISABLED']; } if ($error === '') { $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_3_Visa_SetDistributed', [ 'Claim' => $this->defaults['CLAIM'], 'Order' => $this->defaults['ORDERINC'], 'People' => $this->defaults['PEOPLE'], 'SetDistributedDocum' => $this->SetDistributedDocum, 'UserCode' => $this->internet_user(), 'Partpass' => $this->getPartPassInc(), ] ); if ($res = $this->db->fetchRow($sql)) { if (isset($res['error'])) { $error = $res['error']; } } } if ($error !== '') { throw new Samo_Exception($error); } return true; } return false; } } 