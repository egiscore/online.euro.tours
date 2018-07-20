<?php
 class Cl_Refer_Controller extends Samo_Controller { public function default_action() { $rules = $this->model->permissions(); $this->view->js_var('samo.print', $rules)->assign('rules', $rules); $claim = $this->model->defaults['CLAIM']; $this->view->assign('ALL', $this->model->showCalculated()); if ($claim) { $this->model->defaults['CLAIMBEG'] = $this->model->defaults['CLAIMEND'] = $claim; $this->model->defaults['CLAIMTYPE'] = 1; if ($result = $this->model->getClaims()) { $result[0]['orders'] = array( 'hotels' => $this->model->claimHotels(), 'freights' => $this->model->claimFreights(), 'services' => $this->model->claimServices(), 'insures' => $this->model->claimInsures(), 'visas' => $this->model->claimVisas(), 'peoples' => $this->model->claimPeoples(), ); $this->view ->assign('cl_refer', $result) ->assign('claim', $claim); } if (Samo_Request::get('EDOC')) { $this->view->js_call_onready('samo.e_doc', $claim); } } $this->view->assign('PERSONAL_AREA', Profile_Model::links()); $this->view->assign('PARTNERCLAIM', $this->model->getPartnerClaim()); $this->view->assign('STATECLAIM', $this->model->getStateClaim()); $this->view->assign('MANAGERCLAIM', $this->model->getManagerClaim()); if (isset($_SESSION['flash']) && isset($_SESSION['flash']) && is_array($_SESSION['flash']) && count($_SESSION['flash'])) { foreach ($_SESSION['flash'] as $message) { $this->view->message($message, 'info', true); } unset($_SESSION['flash']); } parent::default_action(); } public function RESULT() { if ($result = $this->model->getClaims()) { if ($pages = $this->model->getPages($result[0]['pages'])) { $this->view->assign('pages', $pages) ->assign('current_page', $this->model->defaults['CLAIMPAGE']); } } $this->view->assign('cl_refer', $result) ->element_update('resultset', 'resultset.tpl') ->js_call('samo.claim_modules'); } public function COST() { if ($result = $this->model->cl_refer_claimCost()) { if ($this->model->claimInfo()) { if ($paymentschedule = $this->model->GetPaymentSchedule()) { $this->view->assign('claim_paymentschedule', $paymentschedule); } $routes = Samo_Registry::get('routes'); if (isset($routes['bonus_manager'])) { $bonus_model = Samo_Loader::load_object('Bonus_Manager_Model'); if ($bonus = $bonus_model->future_bonus($this->model->defaults['CLAIM'])) { $this->view->assign('future_bonus', $bonus); } } $this->view->assign('cost', $result) ->assign('claim_info', $this->model->defaults['claim_info']) ->assign('partpass_mode', $_SESSION['samo_auth']['mode']) ->popup_template('controls.tpl', sprintf($this->messages['CL_R_COST_TITLE'], $this->model->defaults['CLAIM']), $width = 500, $height = 80) ->js_call('samo.claim_cost'); } } } public function CLAIMORDERS() { $claim = $this->model->defaults['CLAIM']; $orders_tag = '#orders_' . $claim; $this->view->assign('hotels', $this->model->claimHotels()) ->assign('freights', $this->model->claimFreights()) ->assign('services', $this->model->claimServices()) ->assign('insures', $this->model->claimInsures()) ->assign('visas', $this->model->claimVisas()) ->assign('peoples', $this->model->claimPeoples()) ->assign('claim', $claim) ->element_update($orders_tag . ' .orders', 'orders.tpl') ->element_show($orders_tag . ' .orders') ->js_call('samo.claim_orders', $claim); } public function E_DOC() { $model = $this->model; $links = $model->documentList(); $links = array_merge($links, $model->uploadedFiles()); $samo_document = Samo_Loader::load_object('Samo_Document'); $samo_document->construct(); $edoc_types = $samo_document->EDOC_Types(); $this->view ->assign('edoc_confirm', $model->edoc_confirm) ->assign('CLAIM', $model->defaults['CLAIM']) ->assign('links', $links) ->assign('TAB', 1) ->assign('ENABLE_UPLOAD', (count($edoc_types) > 1 ? 1 : 0)) ->popup_close() ->popup_template('e_doc_form.tpl', $this->messages['E_DOC_BTN_PRINT'] . ' ' . strtolower($this->messages['CL_R_E_DOC']), $width = 800, $height = 300) ->js_call('samo.e_doc_post'); } public function E_DOC_TAB_ADD() { $model = $this->model; $links = $model->uploadedFiles(); $samo_document = Samo_Loader::load_object('Samo_Document'); $samo_document->construct(); $edoc_types = $samo_document->EDOC_Types(); $peoples = array(); $peoples[0] = array('Inc' => 0, 'Human' => '', 'LName' => '---'); $peoples = array_merge($peoples, $model->claimPeoples()); $this->view ->assign('CLAIM', $model->defaults['CLAIM']) ->assign('links', $links) ->assign('edoc_types', $edoc_types) ->assign('peoples', $peoples) ->assign('TAB', 2) ->assign('ENABLE_UPLOAD', (count($edoc_types) > 1 ? 1 : 0)) ->popup_close() ->popup_template('e_doc_form.tpl', $this->messages['E_DOC_BTN_ADD'] . ' ' . strtolower($this->messages['CL_R_E_DOC']), $width = 800, $height = 300) ->js_call('samo.e_doc_post'); } public function UPLOAD_EDOC() { try { $model = $this->model; $response = Samo_Registry::get('response'); $response->respond_to('iframe-js'); $response->headers('Vary', 'Accept'); $last_upload = $model->E_DOC_UPLOAD(); $this->view->assign('last_upload', $last_upload) ->message(sprintf($this->messages['E_DOC_UPLOAD_SUCCESS'], $last_upload['Name'])); return $this->E_DOC_TAB_ADD(); } catch (Samo_Exception $e) { $this->view->error($e->getMessage()); } } public function document() { $response = Samo_Registry::get('response'); $doc = Samo_Request::intval('DOC'); if ($doc && false !== ($doc_file = $this->model->external_document($doc))) { $response->redirect_to($doc_file); } else { $response->not_found(); } } public function andr_document() { $response = Samo_Registry::get('response'); $doc = Samo_Request::strval('DOC'); $type = ifs(Samo_Request::strval('type'), 'json'); if ($doc && false !== ($doc_file = $this->model->andr_document($doc, $type))) { $response->redirect_to(WWWROOT . $doc_file); } else { $response->not_found(); } } public function CHOOSE_FRPLACEMENT() { $boarding = $this->model->freightBoarding(); if ($boarding) { $width = max(min((count($boarding['boarding'][0][0]) + 2) * 20, Samo_Request::intval('maxWidth')), 940); $height = max(min((count($boarding['boarding'][0]) + count($boarding['peoples'])) * 20, Samo_Request::intval('maxHeight')), 760); $this->view ->assign('control', 'FRPLACEMENT') ->assign('CLAIM', $this->model->defaults['CLAIM']) ->assign('ORDER', $this->model->defaults['ORDER']) ->bulk_assign($boarding) ->popup_template('../controls.tpl', $this->messages['FRPLACEMENT_CHOOSE_POPUP'], $width, $height) ->js_call('samo.frplacement'); } } public function SAVE_FRPLACEMENT() { $seats = $this->model->saveBoarding(); $this->view->js_var('samo.seats', $seats); $errors = $this->model->getErrors(); if (empty($errors)) { $claim = $this->model->defaults['CLAIM']; if ($result = $this->model->getClaims()) { $result[0]['orders'] = array( 'hotels' => $this->model->claimHotels(), 'freights' => $this->model->claimFreights(), 'services' => $this->model->claimServices(), 'insures' => $this->model->claimInsures(), 'visas' => $this->model->claimVisas(), 'peoples' => $this->model->claimPeoples(), ); $this->view->assign('cl_refer', $result) ->assign('claim', $claim) ->element_replace('#cl_' . $claim, 'resultset.tpl') ->js_call('samo.claim_modules', $claim); } $this->view ->popup_close() ->message($this->messages['FRPLACEMENT_SAVED']); } else { $msg = reset($errors); $this->view->error($msg); } } public function DOWNLOAD() { $model = $this->model; $res = ['guid' => Samo_Request::get('guid')]; try { if (false !== ($file = $model->linkedDocument())) { $res['url'] = $file; } else { $res['error'] = 'File not found'; } } catch (Samo_Exception $e) { $res['error'] = $e->getMessage(); } $this->view->js_call('samo.download_result', $res); } public function REDIRECT() { $model = $this->model; try { if (false !== ($file = $model->linkedDocument())) { Samo_Registry::get('response')->redirect_to($file); } else { Samo_Registry::get('response')->not_found(); } } catch (Samo_Exception $e) { $this->view->error($e->getMessage()); } } public function PDF_SAMOTOUR() { $res = $this->model->getExternalDocument(); $this->view->js_call('samo.download_result', $res); return $res; } public function CLAIM_CONFIRM_PREORDER() { if ($this->model->claimInfo()) { if ($result = $this->model->ClaimConfirmPreOrder()) { if (!$result['Bron'] && $result['result'] == 1 && is_null($result['price'])) { $_GET['CLAIM_CONFIRM_PREORDER_BRON'] = 1; $this->CLAIM_CONFIRM_PREORDER(); } else { $this->view->assign('result', $result) ->assign('claim_info', $this->model->defaults['claim_info']) ->popup_template('claim_confirm_preorder.tpl', sprintf($this->messages['CLAIM_CONFIRM_PREORDER_TITLE'], $this->model->defaults['CLAIM']), $width = 500, $height = 80) ->js_call('samo.claim_confirm_preorder'); } if ($result['Bron']) { $this->view->element_hide('#cl_' . $this->model->defaults['CLAIM'] . ' .ClaimConfirmPreOrder'); } } } } } 