<?php
 class Registration_Controller extends Samo_Controller { public function construct() { $this->auth_init(); if (isset($_SESSION['samo_auth']) && isset($_SESSION['samo_auth']['Administrator']) && $_SESSION['samo_auth']['Administrator'] == 1 && $this->model->is_module_installed('edit_agency')) { return $this->view->redirect_to(Samo_Url::route('edit_agency', [], 'PARTPASS_LIST')); } $this->actions = array('INIT' => array('FIRM_TOWN')); } public function default_action() { $this->init_data(); $this->view ->assign('fields_partpass', $this->model->get_fields_partpass()) ->assign('show_save_partpass_btn', true) ->bulk_assign($this->model->defaults); parent::default_action(); } public function SAVE_LOGIN() { $messages = $this->messages; $model = $this->model; try { if ($model->is_enabled()) { if (false !== ($res = $model->SaveEditPartpass())) { $message = $messages['SAVE_PASSWORD_OK']; if ($model->is_send_to_administrator($res)) { $message = $messages['SEND_NEW_PARTPASS_EMAIL_TO_ADMINISTRATOR_OK']; } } else { $message = $messages['INTERNAL_SERVER_ERROR']; } } else { $message = $messages['MORE_AGENCY_LOGIN']; } $this->view->js_call('samo.postPassword', $message); } catch (Samo_Exception $e) { $this->view->error($e->getMessage()); } } public function SEARCH() { try { $data = $this->model->searchRun(); $this->view->default_modifiers = array('replace:" ":"&nbsp;"', 'default:"&nbsp;"'); $this->view ->assign('result', $data) ->assign('have_administrator', $data[0]['have_administrator']) ->element_update('#resultset', 'resultset.tpl') ->js_var('samo.AGENCY_FOUND', true); } catch (Samo_Exception $e) { if ($e->getCode() > 2) { $this->view->error($e->getMessage()); } else { $this->view->element_text('#resultset', $e->getMessage()); } } } } 