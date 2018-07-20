<?php
 class Warrant_Controller extends Samo_Controller { public function default_action() { $this->view->assign('PERSONAL_AREA', Profile_Model::links()); $this->view->assign('URL', Samo_Url::route('warrant')) ->assign('RESULT', $this->model->people_warrants()); parent::default_action(); } public function dover() { try { if ($this->model->defaults['peop'] != null) { $this->model->get_template_warrant(); if ($this->model->external) { $this->PDF_SAMOTOUR(); } else { $this->render_pdf($this->model->defaults['template']); } } } catch (Samo_Exception $e) { $this->view->js_call('samo.download_result', array('guid' => Samo_Request::find('guid'), 'error' => $e->getMessage())); } } public function ADD_WARANT() { $this->model->get_warrant_fields(); $this->view ->assign('fields', $this->model->fields) ->popup_template('form.tpl', $this->messages['POPUP_TITLE'], $width = 360, $height = 80) ->js_call('samo.warrant_initform'); } public function SAVE_WARRANT() { try { $this->model->Save_Warrant(); $this->view->popup_close(); $routes = Samo_Registry::get('routes'); if ($src = Samo_Request::get('SOURCE')) { if ($url = Samo_Url::parse($src)) { $this->view->redirect_to($url); } } else { $this->view->redirect_to($routes['warrant']['url']); } } catch (Samo_Exception $e) { $this->view->js_call('alert', $e->getMessage()); } } public function render_pdf($fpdf_tpl_data = false) { $model = $this->model; $model->people_warrants($this->model->defaults['peop']); if (false !== $this->model->warrant) { $code = uniqid(); $pdf_file = sprintf('dnl/warrant_%s_%s.pdf', $this->model->defaults['peop'], $code); if (false !== $fpdf_tpl_data) { $this->view ->assign('warrant', $this->model->warrant[0]) ->render_fpdf($fpdf_tpl_data, $pdf_file); $this->view->js_call('samo.download_result', array('guid' => Samo_Request::find('guid'), 'label' => '', 'url' => WWWROOT . $pdf_file)); } else { $this->view->error($this->messages['ACCESS_DENIED'], 401); } } else { $this->view->error($this->messages['ACCESS_DENIED'], 401); } } } 