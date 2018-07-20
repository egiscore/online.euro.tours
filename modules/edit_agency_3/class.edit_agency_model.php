<?php
 class Edit_Agency_Model extends Samo_Partner { protected $auth_required = array('agency'); public function METROSTATION() { $this->PARTNER_TOWN = Samo_Utils::ifs(Samo_Request::intval('TOWN'), $this->PARTNER_TOWN); $this->PARTNER_METROSTATION = Samo_Utils::ifs(Samo_Request::intval('PARTNER_METROSTATION'), $this->PARTNER_METROSTATION); return parent::METROSTATION(); } public function partpassInList($logins, $inc) { foreach ($logins as $login) { if ($login['inc'] == $inc) { return true; } } return false; } public function getSaveAccess() { if ($this->has_permission('edit_partner', 'Edit')) { return true; } return false; } public function notEditableFields() { $groups = $this->get_fields_partner(); foreach ($groups as $group => $fields) { foreach ($fields as $field => $data) { if ($data['Editable'] || $data['Group'] == 'System') { unset($groups[$group][$field]); } else { $groups[$group][$field]['Editable'] = true; } } } return $groups; } public function enable_request_changes() { return $this->config('ENABLE_REQUEST_CHANGES', 'edit_agency'); } public function send_request($request, $fields) { if ($this->enable_request_changes()) { $params = []; foreach ($fields as &$fgroup) { foreach ($fgroup as $field) { if (array_key_exists($field['Field'], $request)) { $value = trim($request[$field['Field']]); if ('string' == $field['Type']) { $field['Value'] = htmlspecialchars_decode($field['Value'], ENT_QUOTES); } if ('date' == $field['Type']) { $value = Samo_Datetime::parse($value)->format('sql'); } if ($value != $field['Value']) { $params[$field['EntityField']] = $value; } } } } if (count($params)) { $params['Inc'] = $this->defaults['PARTNER']; $mailInc = $this->samotourMail(self::MAIL_CHANGE_REQUEST, $params); if ($mailInc) { return $mailInc; } else { throw new Samo_Exception('Error occurred while send message', 500); } } else { throw new Samo_Exception('No changes found', 400); } } else { throw new Samo_Exception('Email not configures', 405); } } } 