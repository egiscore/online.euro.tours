<?php
 class Bonus_Manager_Model extends Samo_EPlatez { protected $auth_required = array('agency'); public function bonus_info() { $result = array(); $sql = $this->db->formatExec( '<OFFICEDB>.[dbo].[up_get_bonus_all]', [ 'Partpass' => $this->getPartPassInc(), 'phys_buyer' => (isset($_SESSION['samo_auth']['PhysBuyerInc']) ? $_SESSION['samo_auth']['PhysBuyerInc'] : null), ] ); if (false !== ($res = $this->db->query($sql))) { while (false !== ($row = $this->db->fetchRow($res))) { if (!isset($result[$row['id']])) { $result[$row['id']] = array('detail' => array(), 'currency' => array()); } if (!isset($result[$row['id']]['currency'][$row['currency']]['total'])) { $result[$row['id']]['currency'][$row['currency']]['total'] = array('value' => 0, 'alias' => $row['currency_alias']); } if (!isset($result[$row['id']]['currency'][$row['currency']]['available'])) { $result[$row['id']]['currency'][$row['currency']]['available'] = array('value' => 0, 'alias' => $row['currency_alias']); } if (1 == $row['type']) { if (!isset($result[$row['id']]['currency'][$row['currency']]['add'])) { $result[$row['id']]['currency'][$row['currency']]['add'] = array('value' => 0, 'alias' => $row['currency_alias']); } $result[$row['id']]['currency'][$row['currency']]['add']['value'] += $row['value']; $result[$row['id']]['currency'][$row['currency']]['total']['value'] += $row['value']; if (1 == $row['status']) { $result[$row['id']]['currency'][$row['currency']]['available']['value'] += $row['value']; } } elseif (2 == $row['type']) { if (!isset($result[$row['id']]['currency'][$row['currency']]['delete'])) { $result[$row['id']]['currency'][$row['currency']]['delete'] = array('value' => 0, 'alias' => $row['currency_alias']); } $result[$row['id']]['currency'][$row['currency']]['delete']['value'] += $row['value']; $result[$row['id']]['currency'][$row['currency']]['total']['value'] -= $row['value']; $result[$row['id']]['currency'][$row['currency']]['available']['value'] -= $row['value']; } $result[$row['id']]['detail'][] = $row; } } foreach ($result as &$row) { foreach ($row['currency'] as &$row2) { $row2['total']['value'] = round($row2['total']['value'], 2) + 0; } } return $result; } public function bonus_claim($claim) { if ($id = $this->getManagerId()) { $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_get_bonus_byId', [ 'Id' => $id, 'Claim' => $claim, ] ); if (($bonus = $this->db->fetchRow($sql)) && 0 == $bonus['result']) { $bonus['MAX_AMOUNT'] = min($bonus['bonus_sum'], $bonus['claim_amount']); return ($bonus['bonus_sum'] > 0) ? $bonus : false; } } return false; } public function getManagerId() { return isset($_SESSION['samo_auth']['ManagerId']) && !empty($_SESSION['samo_auth']['ManagerId']) ? $_SESSION['samo_auth']['ManagerId'] : false; } public function use_bonus() { $claim = Samo_Request::intval('CLAIM'); if ($claim) { $this->defaults['CLAIM'] = $claim; $bonus = $this->pay_variant($this->defaults['CLAIM']); if (false == $bonus) { $messages = Samo_Registry::get('messages'); throw new Samo_Exception($messages['PAY_VARIANT_DISABLED'], 1); } if ($claim_amount = Samo_Request::floatval('AMOUNT', 0, $bonus['MAX_AMOUNT'])) { $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_pay_from_bonus', [ 'Id' => $this->getManagerId(), 'Claim' => $claim, 'Claim_Amount' => $claim_amount, 'Claim_Currency' => $bonus['claimcurrency'], 'User' => $this->internet_user(), ] ); $result = $this->db->fetchOne($sql); return (0 == $result); } } return false; } public function pay_variant($claim) { $bonus = false; if ($this->is_module_installed('bonus_manager')) { if (false !== ($bonus = $this->bonus_claim($claim))) { if (!$this->pay_variant_check_owner($claim, 'bonus_manager')) { $bonus = false; } } if (false !== ($res = $this->future_bonus($claim))) { $bonus['future_bonus'] = $res; } } return $bonus; } public function future_bonus($claim) { $sql = $this->db->formatExec( '<OFFICEDB>.dbo.up_WEB_3_calc_bonus_by_claim', [ 'Claim' => $claim, ] ); $result = $this->db->fetchRow($sql); return (isset($result['bonus_value']) && $result['bonus_value'] > 0) ? $result : false; } } 