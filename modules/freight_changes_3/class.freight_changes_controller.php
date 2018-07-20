<?php
 class Freight_changes_Controller extends Samo_Controller { protected $is_embedable = true; public function construct() { $this->actions = array( 'INIT' => array('TOWNFROMINC', 'STATEINC', 'TOURINC'), 'TOWNFROMINC' => array('STATEINC', 'TOURINC'), 'STATEINC' => array('TOWNTOINC', 'TOURINC') ); $this->options_only = array('STATEINC', 'TOWNFROMINC', 'TOURINC'); $this->persistent = array('STATEINC', 'TOWNFROMINC'); } public function default_action() { $this->init_data(); parent::default_action(); } public function samo_action($action) { if (!isset($this->actions[$action])) { Samo_Registry::get('response')->not_found(); } foreach ($this->actions[$action] as $control) { if (false !== ($result = $this->model->loadData($control))) { if (in_array($control, $this->options_only)) { $this->view->add_options($control, $result, '../api_controls.tpl'); } else { $this->view->element_value($control, $result); } } } return true; } public function frchanges() { $this->view->assign('RESULT', $this->model->result()) ->element_update('resultset', 'resultset.tpl'); } } 