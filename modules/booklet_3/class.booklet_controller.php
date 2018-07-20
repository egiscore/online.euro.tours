<?php
 class Booklet_Controller extends Samo_Controller { protected function allow_js() { return false; } public function admin_action() { if (false !== ($result = $this->model->SaveBooklet())) { $this->view->assign('CLAIM', $this->model->defaults['CLAIM']) ->bulk_assign($result); } } public function default_action() { if ($this->model->is_enabled()) { try { if (true == $this->model->get_template_booklet()) { if (false !== ($result = $this->model->SaveBooklet())) { $this->view->assign('CLAIM', $this->model->defaults['CLAIM']) ->bulk_assign($result); $tpl = $this->model->defaults['template']; $ext = pathinfo($tpl, PATHINFO_EXTENSION); if ('tpl' == $ext) { $booklet = $this->view->fetch($tpl); $this->view->assign('content_for_layout', $booklet)->render('layout'); } else { $code = uniqid(); $pdf_file = sprintf('dnl/booklet_%s.pdf', $code); $this->view->render_fpdf($tpl, $pdf_file); $pdf_url = WWWROOT . $pdf_file; Samo_Registry::get('response')->redirect_to($pdf_url); } } } else { $this->view->error($this->messages['TEMPLATE_NOT_CONFIGURE']); } } catch (Samo_Exception $e) { $this->view->error($e->getMessage()); } } else { $this->view->window_close($this->messages['DISABLE_PRINT_BY_LOGIN']); } } public function PDF_SAMOTOUR() { $res = parent::PDF_SAMOTOUR(); if (isset($res['url'])) { $this->model->SaveBooklet(); } } } 