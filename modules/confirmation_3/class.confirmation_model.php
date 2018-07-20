<?php
 class Confirmation_Model extends Samo_Claim { public function markIssued($claim = null, $people = null, $order = null, $opeople = null, $docum = '') { $this->defaults['CLAIM'] = $claim; $this->claimInfo(); return $this->SaveConfirmation(); } public function SaveConfirmation() { if (false !== ($result = $this->confirmation())) { $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_4_confirmation_Save', [ 'Claim' => $this->defaults['CLAIM'], 'UserCode' => $this->internet_user(), 'Partpass' => $this->getPartPassInc(), ] ); if (false !== ($res = $this->db->query($sql))) { return $result; } } return false; } public function confirmation() { $booklet = Samo_Loader::load_object('Booklet_Model', $this->config); $booklet->construct($this->defaults['CLAIM']); $this->claimInfo(); $sql = $this->db->formatExec('<OFFICEDB>.dbo.up_WEB_3_claim_Confirmation', ['Claim' => $this->defaults['CLAIM']]); if (false !== ($res = $this->db->fetchRow($sql)) && false !== ($result = $booklet->booklet()) && $cost = $this->claimCost()) { $messages = Samo_Registry::get('messages'); $res['documents'] = ($res['ClaimIssued']) ? $messages['DOCUMENT_ISSUED'] : (($res['ready_document']) ? $messages['DOCUMENT_READY'] : $messages['DOCUMENT_NOT_READY']); $res['phones'] = array(); if (strlen(trim($res['PPhone']))) { $res['phones'][] = $res['PPhone']; }; unset($res['PPhone']); if (strlen(trim($res['PPhone1']))) { $res['phones'][] = $res['PPhone1']; }; unset($res['PPhone1']); if (strlen(trim($res['PPhone2']))) { $res['phones'][] = $res['PPhone2']; }; unset($res['PPhone2']); $res['faxes'] = array(); if (strlen(trim($res['PFax']))) { $res['faxes'][] = $res['PFax']; }; unset($res['PFax']); if (strlen(trim($res['PFax1']))) { $res['faxes'][] = $res['PFax1']; }; unset($res['PFax1']); if (isset($cost[0])) { $res['ClaimCatalog'] = $cost[0]['Catalog']; $res['ClaimPrice'] = $cost[0]['Amount']; $res['ClaimCommission'] = $cost[0]['Commiss']; $res['ClaimCurrency'] = $cost[0]['CurrencyAlias']; $res['ClaimDebt'] = $cost[0]['Debt']; $res['ClaimPaid'] = $cost[0]['Paid']; $res['ClaimDiscount'] = $cost[0]['Discount']; } $cost_rub = (isset($cost[1])) ? $cost[1] : ((CURRENCYINC == $cost[0]['CurrencyInc']) ? $cost[0] : false); if ($cost_rub) { $res['Catalog_Document'] = $cost_rub['Catalog']; $res['Amount_Document'] = $cost_rub['Amount']; $res['Commission_Document'] = $cost_rub['Commiss']; $res['AliasCurrency_Document'] = $cost_rub['CurrencyAlias']; $res['Debt_Document'] = $cost_rub['Debt']; $res['Paid_Document'] = $cost_rub['Paid']; $res['Discount_Document'] = $cost_rub['Discount']; } $result['claim_info'] = $res; $result['owner_info'] = $this->getPartnerInfo($this->defaults['claim_info']['OwnerInc']); return $result; } return false; } public function get_template_confirmation() { if (empty($this->defaults['TourInc']) || empty($this->defaults['StateInc']) || empty($this->defaults['OwnerInc'])) { if (false !== ($tmp = $this->claimInfo())) { $this->defaults['TourInc'] = $tmp['TourInc']; $this->defaults['StateInc'] = $tmp['StateInc']; $this->defaults['OwnerInc'] = $tmp['OwnerInc']; } else { return false; } } $res = $this->get_settings_printform($doccategory = 11, $partner = $this->defaults['OwnerInc'], $tour = $this->defaults['TourInc'], $state = $this->defaults['StateInc'], $inszone = null, $contracttype = null, $agreement_year = null, $email_type = null, $online_bank = null, $owner = $this->defaults['OwnerInc']); if ($res) { return true; } return $this->messages['TEMPLATE_NOT_INSTALL']; } public function is_enabled() { $clRefer = Samo_Loader::load_object('Cl_Refer_Model', $this->config); $clRefer->construct(); $documents = $clRefer->documentList(null, null, DocCategory::CONFIRMATION); if (count($documents)) { $document = reset($documents); $data = $document['data']; if ($data['Enabled'] && !$data['ExternalDocument']) { return true; } } return false; } protected function getExternalDocumentInit() { if ($this->defaults['CLAIM']) { return $this->getExternalDocumentJob(sprintf('confirmation_%d.pdf', $this->defaults['CLAIM']), sprintf('confirmation_%d_%%s_%%s.pdf', $this->defaults['CLAIM'])); } throw new Samo_Exception($this->messages['CANNOT_PRINT']); } protected function getExternalDocumentParams() { if (false == $this->is_enabled() || true !== $this->get_template_confirmation()) { throw new Samo_Exception($this->messages['CANNOT_PRINT']); } $params = array( 'claim' => $this->defaults['CLAIM'], 'template' => $this->defaults['template'] ); return $params; } } 