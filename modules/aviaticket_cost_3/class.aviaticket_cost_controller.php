<?php
 class Aviaticket_Cost_Controller extends Samo_Controller { public function default_action() { $this->model->get_template_aviaticket_cost(); if ($this->model->external) { $this->PDF_SAMOTOUR(); } else { try { $this->model->is_enabled(); $content = $this->view->assign('data', $this->model->SaveAviaTicket_Cost()) ->fetch($this->model->defaults['template']); $this->view->assign('content_for_layout', $content) ->render('layout'); } catch (Samo_Exception $e) { $this->view->error($e->getMessage()); } } } } 