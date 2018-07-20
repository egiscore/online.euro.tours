<?php
 class Check_Passport_Controller extends Samo_Controller { public function construct() { $this->actions = [ 'INIT' => ['TOWNFROMINC', 'STATEINC', 'VISAINC', 'CITIZENSHIP', 'BORNPLACE', 'NIGHTS', 'CHECKIN'], 'TOWNFROMINC' => ['STATEINC', 'VISAINC'], 'STATEINC' => ['VISAINC'], ]; } public function default_action() { foreach ($this->actions['INIT'] as $control) { $data = $this->model->loadData($control); $this->view->assign($control, $data); } return parent::default_action(); } public function samo_action($action) { if (!isset($this->actions[$action])) { Samo_Registry::get('response')->not_found(); } foreach ($this->actions[$action] as $control) { if (false !== ($result = $this->model->loadData($control))) { $this->view->add_options($control, $result, '../api_controls.tpl'); } } return true; } public function CHECK() { $result = $this->model->check(); if (!$result['allow']) { $this->view->js_call('samo.showResultCheck', $this->messages['CHECK_PASSPORT_INVALID'], true); } else { $this->view->js_call('samo.showResultCheck', $this->messages['CHECK_PASSPORT_VALID'], false, $result['ruleNote'] ?: false); } } } 