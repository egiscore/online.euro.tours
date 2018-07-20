<?php
 class Cancel_Claim_Controller extends Samo_Controller { public function construct() { $this->view->page_container('#cl_refer'); } public function default_action() { try { $model = $this->model; $model->is_enable(); $penalty = $this->model->PenaltyMessage(); if ($penalty) { $this->view->assign('penalty_size', $penalty); } $this->view->assign('content', $this->model->agreement()) ->assign('info', $model->claimInfo()) ->assign('peoples', $this->model->claimPeoples()) ->assign('hotels', $this->model->claimHotels()) ->assign('reason', $this->model->reason()) ->popup_template('layout.tpl', $this->messages['CANCEL_CLAIM_POPUP_TITLE'], 700, 215, true)->js_call('samo.cancel_claim', $this->model->defaults['CLAIM']); } catch (Samo_Exception $e) { $this->view ->element_remove('#cl_' . $this->model->defaults['CLAIM'] . ' a.cancel_claim') ->error($e->getMessage()); } } public function request() { $messages = $this->messages; $this->view->popup_close(); try { if (Samo_Request::is_post()) { $this->model->is_enable(); if ($this->model->request()) { $this->view->element_remove('#cl_' . $this->model->defaults['CLAIM'] . ' span.cancel_claim') ->element_text('#cl_' . $this->model->defaults['CLAIM'] . ' td.status', '<span class="red bold">' . $messages['CL_R_RES_CANCEL_REQUEST'] . '</span>') ->element_data('#cl_' . $this->model->defaults['CLAIM'], 'request-cancel-date', Samo_Datetime::today()->format('sql')) ->popup_message($this->model->get_msg_for_cancel_claim_popup(), $messages['CANCEL_CLAIM_POPUP_TITLE'], 512, 80); $this->callback_params['CLAIM'] = $this->model->defaults['CLAIM']; } else { $this->view->popup_message($messages['CANCEL_CLAIM_DENIED'], $messages['CANCEL_CLAIM_POPUP_TITLE'], 512, 80); } } else { throw new Samo_Exception($messages['CANCEL_CLAIM_DENIED'], 401); } } catch (Samo_Exception $e) { $this->view ->element_remove('#cl_' . $this->model->defaults['CLAIM'] . ' a.cancel_claim') ->error($e->getMessage()); } } } 