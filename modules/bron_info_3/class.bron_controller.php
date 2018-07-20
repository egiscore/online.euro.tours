<?php
 class Bron_Controller extends Samo_Controller { protected $options_only = array(); protected $val_controls = array(); protected $chlb_controls = array(); protected $skipPacketFreight = false; protected $externalFreights; public $model = null; public function construct() { if (!isset($_SESSION['samo_auth']['permissions']['bron'])) { return $this->LOGOUT(); } if (!$_SESSION['samo_auth']['permissions']['bron']) { $this->view->error($this->messages['BRON_DISABLE_BRON']); } if (!isset($_SESSION['BRONCLAIM'])) { $_SESSION['BRONCLAIM'] = array(); } if (!isset($_SESSION['FLASHMESSAGES'])) { $_SESSION['FLASHMESSAGES'] = array(); } $this->view->assign('MAXLONGINT', Samo::MAXLONGINT)->module('bron_info'); if ($this->model->defaults['CLAIMINC'] || $this->model->defaults['TICKET']) { try { $this->model->fetchClaimInfo(); $this->model->check_packet(); $bron_url = $this->bron_url(); if ($this->model->is_new_claim()) { if ($this->model->action == 'default_action') { $_SESSION['FLASHMESSAGES'][$this->model->defaults['CLAIMINC']] = $this->messages['BRON_OFFER_NOT_ACTUAL2']; $response = Samo_Registry::get('response'); return $response->redirect_to($bron_url); } else { $this->view->popup_message(sprintf($this->messages['BRON_OFFER_NOT_ACTUAL3'], $bron_url), $this->messages['BRON_CLAIM_INFO'], 300, 60, false) ->element_remove('#bron_info button') ->clear_unload(); } } else { if (isset($_SESSION['FLASHMESSAGES'][$this->model->defaults['CLAIMINC']])) { $this->view->message($_SESSION['FLASHMESSAGES'][$this->model->defaults['CLAIMINC']]); unset($_SESSION['FLASHMESSAGES'][$this->model->defaults['CLAIMINC']]); } } } catch (Bron_Exception $e) { parent::default_action(); $this->view->error($e->getMessage()); } } $this->skipPacketFreight = $this->model->skipPacketFreights(); $this->externalFreights = $this->model->hasExternalFreights(); if (Samo_Request::get('extfr') !== null) { $this->externalFreights = 2; $this->skipPacketFreight = true; } } public function default_action() { $this->view->assign('partpass_mode', $_SESSION['samo_auth']['mode']) ->js_var('samo.FIO_DELIMTER', FIO_DELIMETER) ->assign('CLAIM_NOTE_TEXT', $this->model->claim_note_text()) ->assign('OWNER', $this->model->getConfig('OWNER', 'bron', 0)) ->assign('CONTACTS', $this->model->getConfig('CONTACTS', 'bron', 0)) ->assign('REKLAMA_CONFIG', $this->model->getConfig('REKLAMA', 'bron', 0)) ->js_var('samo.claim_guid', $this->model->newid()) ->js_var('samo.external_freights', $this->externalFreights) ->assign('EXTERNALFREIGHTS', $this->externalFreights); if ($this->model->defaults['TICKET'] && is_null($this->model->defaults['CLAIMINC'])) { $controls = array('TOURINFO', 'FREIGHTS', 'TOURISTS', 'ASERVICES', 'OWNERINFO', 'REKLAMA'); } else { $this->view->assign('PAYMENTSCHEDULE', ($res = $this->model->PaymentSchedule()) && count($res) > 0) ->assign('CURRENCY_ALIAS', $this->model->getTourinfoCurrencyAlias()) ->assign('CURRENCYPRICE_ALIAS', $this->model->getTourinfoCurrencyPriceAlias()); $controls = array('TOURINFO', 'SPOGMESSAGE', 'FREIGHTSINFO', 'HOTELSINFO', 'TOURISTS', 'INSURESINFO', 'CLAIM_NOTE', 'ASERVICES', 'OWNERINFO', 'PRICECALENDAR', 'CALCULATED_CLAIM', 'REKLAMA'); } try { foreach ($controls as $control) { if (false !== ($result = $this->model->loadData($control))) { $this->view->assign($control, $result); if ($control == 'PRICECALENDAR') { $this->view->js_var('resultPrices', is_array($result['prices']) ? $result : false); } } if ($control == 'TOURISTS') { $fields = array_values($result['fields']); $fields = reset($fields); $LASTNAME = array_filter( $fields, function ($field) { return $field['Field'] == 'LASTNAME'; } ); $this->view->assign('LASTNAME_EXIST', count($LASTNAME) == 1); } } $freeinfant = $this->model->FreeInfant(); $this->view->js_var('samo.freeinfant', $freeinfant['freeinfant']); $this->view->js_var('samo.freeinfant_checked', $freeinfant['freeinfant_checked']); $this->view->assign('freeinfant_checked', $freeinfant['freeinfant_checked']); if (!$_SESSION['samo_auth']['mode'] && $result = $this->model->getCommission()) { $this->view->assign('load', 'COMMISSION') ->assign('COMMISSION', $result); } $this->view->assign('CLAIMPRICE', $this->model->claim_price()); $this->view->assign('CLAIMCONVERTPRICE', $this->model->claim_price(true)); $this->view->assign('EXISTSTPROMOACTION', $this->model->getExistsPromoAction()); if (!$this->model->priceActual()) { $this->view->js_call_onready('samo.disablePrice'); } parent::default_action(); } catch (Bron_Exception $e) { parent::default_action(); $this->view->error($e->getMessage()); } } public function STATS() { $this->view->redirect_to($this->bron_url()); } protected function bron_url() { if ($key = Samo_Request::find('KEY')) { $params = [ 'KEY' => $key, ]; } elseif ($ticket = Samo_Request::find('TICKET')) { $params = [ 'TICKET' => $ticket, ]; } else { $params = [ 'CATCLAIM' => $this->model->defaults['CLAIMINC'], 'CURRENCY' => Samo_Request::intval('CURRENCY'), ]; } return Samo_Url::route('bron', $params); } public function CALC() { $externalFreights = $this->model->hasExternalFreights(); try { $price = array(); $error = ''; if (false !== $this->model->getPrice($price, $error)) { if ($externalFreights) { $this->view ->bulk_assign($price) ->assign('load', 'EXTERNALFREIGHT') ->element_update('.EXTERNALFREIGHT', 'gds_controls.tpl'); if (array_key_exists('ExternalFreightError', $price) && $price['ExternalFreightError'] != 0) { $this->view->element_prop('calc', 'disabled', true); $this->view->element_prop('bron', 'disabled', true); $this->view->error($price['ExternalFreightMessage']); return false; } } foreach (['ExternalFreightMessage', 'ExternalFreightOrderId', 'ExternalFreightCurrency', 'ExternalFreightCost', 'ExternalFreightError', 'ExternalFreightNote', 'guid'] as $key) { if (array_key_exists($key, $price)) { unset($price[$key]); } } if (false !== $price['penalty_size_message']) { $price['penalty_size_message'] = $this->view->assign('penalty_size', $price['penalty_size_message'])->fetch('../penalty.tpl'); } if (!empty($price['result_messages'])) { $price['result_messages'] = $this->view->assign('result_messages', $price['result_messages'])->fetch('result_messages.tpl'); } $this->view->js_call('samo.post_calc', $price); } else { $this->view->js_call('samo.calc_save_error', $error); } } catch (Bron_Service_Exception $e) { $service = $e->getService(); $this->view->js_call('samo.calc_service_error', sprintf($this->messages['BRON_SERVICE_MUST_EXCLUDE_PAGE'], $this->model->service_title($service)), $service['uid']); } catch (Samo_Buyer_Exception $e) { $this->buyer_error($e); } catch (Samo_People_Exception $e) { $this->tourist_error($e); } catch (Bron_Exception $e) { $this->view->element_prop('calc', 'disabled', false); $this->view->error($e->getMessage()); } } protected function tourist_error(Samo_People_Exception $e) { $this->view->element_prop('calc', 'disabled', false); $errors = $e->getErrors(); foreach ($errors as $error => $fields) { foreach ($fields as $field) { $this->view->js_call('samo.error_tourist', $error, '[name*="' . $field['FormField'] . '"]'); } } Samo_Registry::get('response')->flush(); } protected function buyer_error(Samo_Buyer_Exception $e) { $this->view->element_prop('calc', 'disabled', false); $errors = $e->getErrors(); foreach ($errors as $error => $fields) { $this->view->message($error, 'error'); foreach ($fields as $field) { $this->view->add_class('[name*="' . $field['FormField'] . '"]', 'error'); } } Samo_Registry::get('response')->flush(); } protected function bron_result($reservation) { $this->callback_params['CLAIM'] = $reservation; $routes = Samo_Registry::get('routes'); $this->view ->assign('bron', $reservation) ->assign('buyer', isset($_POST['claimDocument']['buyer']) ? $_POST['claimDocument']['buyer'] : array()) ->assign('cl_refer', $routes['cl_refer']['url'] . 'CLAIM=' . $reservation['Claim']) ->assign('bron_again', $this->bron_url()) ->popup_template('resultset.tpl', $this->messages['BRON_BRON_COMPLETE'], 500, 100, false) ->element_remove('bron') ->element_remove('calc') ->clear_unload(); } private function _BRON() { try { $r = array(); $error = ''; if (false !== $this->model->getBron($r, $error)) { if (!$return_to = $this->model->callback()) { $this->bron_result($r); } else { $this->view->clear_unload()->redirect_to($return_to); } } else { $this->view->js_call('samo.calc_save_error', $error); } } catch (Samo_Buyer_Exception $e) { $this->buyer_error($e); } catch (Samo_People_Exception $e) { $this->tourist_error($e); } catch (Bron_Exception $e) { $this->view->element_prop('calc', 'disabled', false); $this->view->error($e->getMessage()); } } public function BRON() { if (!$this->model->checkContacts()) { $this->view->element_prop('calc', 'disabled', false); $this->view->element_prop('bron', 'disabled', false); $this->view->js_call('samo.field.error', $this->messages['BRON_CONTACTS_EMPTY'], '[name="CONTACTS"]'); return; } if (!$this->model->checkReklama()) { $this->view->element_prop('calc', 'disabled', false); $this->view->element_prop('bron', 'disabled', false); $this->view->js_call('samo.field.error', $this->messages['BRON_REKLAMA_EMPTY'], '[name="ORIGIN"]'); return; } if ($tpl = $this->model->show_agreement()) { $this->view->assign('content', $tpl) ->popup_template('agreement.tpl', $this->messages['BRON_AGREEMENT'], 700, 415, true) ->js_call('samo.agreement') ->element_prop('calc', 'disabled', false); } else { $this->_BRON(); } } public function AGREE() { if (!$this->model->check_agreement()) { throw new Samo_Exception('Internal server error'); } $this->model->construct(); $this->model->fetchClaimInfo(); $this->model->check_packet(); $this->view->popup_close(); return $this->_BRON(); } public function TOFREIGHTINC() { try { $load = 'BACKFREIGHTS'; if ($externalFreights = $this->model->hasExternalFreights()) { $gds = $this->model->externalFreightHandler(); $DIRECTFREIGHT = Samo_Request::intval('TOFREIGHTINC'); if (2 == $externalFreights || !$gds->isSelfFreight($DIRECTFREIGHT)) { $freights = $gds->getBackFreights($DIRECTFREIGHT); Samo_Registry::get('logger')->dump($freights); $load = 'EXTERNAL_BACKFREIGHTS'; } else { $freights = $this->model->getBackFreights(); } } else { $freights = $this->model->getBackFreights(); } $this->view ->assign('load', $load) ->assign('BACKFREIGHTS', $freights) ->element_update('BACKFREIGHTS', 'controls.tpl'); } catch (Bron_Exception $e) { $this->view->message($e->getMessage(), 'error'); } } public function RELOADSERVICES() { $old = array(); $new = array(); $services = $this->model->ReloadPageServices($old, $new); $this->view ->assign('CURRENCYPRICE_ALIAS', $this->model->getTourinfoCurrencyPriceAlias()) ->assign('CURRENCY_ALIAS', $this->model->getTourinfoCurrencyAlias()) ->assign('ASERVICES', $services) ->assign('load', 'ASERVICES') ->element_update('ASERVICES', 'controls.tpl'); $messages = $this->messages; foreach ($old as $service) { $this->view->message(sprintf($messages['BRON_SERVICE_EXCLUDE_PAGE'], $service), 'message'); } foreach ($new as $service) { $this->view->message(sprintf($messages['BRON_SERVICE_INCLUDE_PAGE'], $service), 'notice'); } } public function SHOW_ADDITIONAL_SERVICES() { try { $services = $this->model->ShowServicesByPeople(); $this->view ->assign('load', 'ADDITIONAL_SERVICES') ->assign('ADDITIONAL_SERVICES', $services) ->assign('CURRENCY_ALIAS', $this->model->getTourinfoCurrencyAlias()) ->assign('CURRENCYPRICE_ALIAS', $this->model->getTourinfoCurrencyPriceAlias()) ->popup_template('controls.tpl', $this->messages['BRON_ADDITIONAL_SERVICE_POPUP'], $width = 800, $height = 0); } catch (Samo_People_Exception $e) { $this->tourist_error($e); } catch (Bron_Exception $e) { $this->view->element_prop('calc', 'disabled', false); $this->view->error($e->getMessage()); } } public function SHOW_ADDITIONAL_INSURES() { $max_inscusts = 0; try { $insures = $this->model->ShowInsuresByPeople($max_inscusts); if (count($insures)) { $this->view ->assign('load', 'ADDITIONAL_INSURES') ->assign('ADDITIONAL_INSURES', $insures) ->assign('max_inscusts', $max_inscusts) ->assign('CURRENCY_ALIAS', $this->model->getTourinfoCurrencyAlias()) ->popup_template('controls.tpl', $this->messages['BRON_ADDITIONAL_INSURE_POPUP'], $width = 800, $height = 400); } else { $this->view->popup_message($this->messages['BRON_ADDITIONAL_INSURE_IS_EMPTY'], $this->messages['BRON_ADDITIONAL_INSURE_POPUP']); } } catch (Samo_People_Exception $e) { $this->tourist_error($e); } catch (Bron_Exception $e) { $this->view->element_prop('calc', 'disabled', false); $this->view->error($e->getMessage()); } } public function REDRAW_INSURE() { $result = $this->model->RedrawInsure(); $this->view ->assign('load', 'INSURESINFO') ->assign('INSURESINFO', $result) ->element_update('INSURESINFO', 'controls.tpl'); } public function PAYMENTSCHEDULE() { if ($paymentschedule = $this->model->paymentschedule()) { $this->view->assign('paymentschedule', $paymentschedule)->popup_template('../paymentschedule.tpl', $this->messages['PAYMENT_SCHEDULE_TITLE'], 500, 50); } else { $this->view->message($this->messages['NO_DATA']); } } public function CHOOSE_FRPLACEMENT() { $boarding = $this->model->freightBoarding(); if ($boarding) { $width = max(min((count($boarding['boarding'][0][0]) + 2) * 20, Samo_Request::intval('maxWidth')), 940); $height = max(min((count($boarding['boarding'][0]) + count($boarding['peoples'])) * 20, Samo_Request::intval('maxHeight')), 760); $this->view ->assign('control', 'FRPLACEMENT') ->assign('FrPlacementClass', $boarding['FrPlacementClass']) ->bulk_assign($boarding) ->popup_template('../controls.tpl', $this->messages['FRPLACEMENT_CHOOSE_POPUP'], $width, $height) ->js_call('samo.frplacement'); } } public function EXTERNAL_FREIGHTS() { $packetInfo = $this->model->fetchClaimInfo(); if (!$packetInfo) { return false; } $routes = $this->model->getPacketFreights(); if (!$routes || count($routes) != 2 && !$this->model->skipPacketFreights()) { return false; } $gds = $this->model->externalFreightHandler(); $fClass = (($tmp = Samo_Request::get('fClass')) && 'Business' == $tmp) ? 'Business' : 'Econom'; $infant = (int)Samo_Request::get('inf'); $params = [ 'args' => [ 'query' => [ 'class' => $fClass, 'inf' => $infant, ] ] ]; try { if ($res = $gds->doSearch($params)) { $filter = $filterData = []; $currency = false; if ($this->skipPacketFreight) { $loadTpl = 'EXTERNAL_FREIGHTS_4_TABLE'; $selector = '.FREIGHTSINFO tbody.freightTable:eq(' . Bron_Model::FREIGHT_ROUTE_DIRECT . ')'; $freights = $gds->getFreightsList($filter, $filterData, $currency); if ($currency) { $currency = Samo_String::getCurrencySign($currency); } $str = $this->view ->assign('filter', $filter) ->assign('filterData', $filterData) ->assign('load', 'EXTERNAL_FREIGHTS_4_TABLE_FILTERS') ->assign('currency', $currency) ->fetch('controls.tpl'); $this->view ->element_append('.freightsFilter', $str) ->element_text('.freightsTableBlock .external_freight_note', $this->model->getFreightExternalNote()); } else { $loadTpl = 'EXTERNAL_FREIGHTS'; $selector = '.FREIGHTSINFO select.freight:eq(' . Bron_Model::FREIGHT_ROUTE_DIRECT . ')'; $freights = $gds->getFreightsByRoute(Bron_Model::FREIGHT_ROUTE_DIRECT); } $str = $this->view ->assign('freights', $freights) ->assign('load', $loadTpl) ->fetch('controls.tpl'); $this->view ->element_append($selector, $str); } } catch (Samo_Exception $e) { $this->view->error($e->getMessage()); } } } 