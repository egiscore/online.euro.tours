<?php
 class Fast_Search_Controller extends Search_Tour_Controller { private $mode = 'search_tour'; public function __construct() { $this->mode = ($mode = Samo_Request::get('mode')) ? $mode : ((($townfrom = Samo_Request::intval('TOWNFROMINC')) && $townfrom == Samo::TOWNFROMHOTELINC) ? 'search_hotel' : 'search_tour'); $module = Samo_Registry::get('module'); $module['model'] = $this->mode . '_model'; try { $model = Samo_Loader::load_object(ucwords($module['model'], '_')); } catch (Samo_Exception $e) { $model = Samo_Loader::load_object('Search_Tour_Model'); } $modes = $model->SEARCHMODE(); if (!array_key_exists(str_replace('search_', '', $this->mode), $modes)) { $mode = reset($modes); $this->mode = 'search_' . $mode['id']; $module['model'] = $this->mode . '_model'; } Samo_Registry::set('module', $module); try { parent::__construct(); } catch (DatabaseServer_Exception $e) { unset($_GET['STATEINC'], $_GET['TOWNFROMINC']); parent::__construct(); } if ($this->mode == 'search_hotel') { $this->persistent = array_diff($this->persistent, ['TOWNFROMINC']); } } public function default_action() { $this->view->assign('search_mode', $this->mode); try { parent::default_action(); } catch (DatabaseServer_Exception $e) { if (2000004 != $e->getCode()) { $this->view->error($e->getMessage()); } $this->empty_form(true); } } public function samo_action($action) { try { parent::samo_action($action); } catch (DatabaseServer_Exception $e) { if (2000004 != $e->getCode()) { $this->view->error($e->getMessage()); } if ('INIT' == $action) { unset($_GET['STATEINC'], $_COOKIE['pSTATEINC']); parent::samo_action($action); } $this->empty_form(true); } } public function construct() { parent::construct(); $this->options_only[] = 'STARS'; $this->chlb_controls = array_diff($this->chlb_controls, ['STARS']); $this->actions = [ 'INIT' => ['TOWNFROMINC', 'STATEINC', 'TOURINC', 'PACKET', 'STARS', 'HOTELS', 'ADULT', 'CHILD', 'CHECKIN_BEG', 'COSTMAX', 'CURRENCY', 'NIGHTS_FROM', 'NIGHTS_TILL'], 'TOWNFROMINC' => ['STATEINC', 'TOURINC', 'PACKET', 'STARS', 'HOTELS', 'ADULT', 'CHILD', 'CHECKIN_BEG', 'CURRENCY', 'NIGHTS_FROM', 'NIGHTS_TILL'], 'STATEINC' => ['TOURINC', 'PACKET', 'STARS', 'HOTELS', 'ADULT', 'CHILD', 'CHECKIN_BEG', 'CURRENCY', 'NIGHTS_FROM', 'NIGHTS_TILL'], 'TOURINC' => ['PACKET', 'STARS', 'HOTELS', 'ADULT', 'CHILD', 'CHECKIN_BEG', 'CURRENCY', 'NIGHTS_FROM', 'NIGHTS_TILL'], 'STARS' => ['HOTELS'], 'ADULT' => ['CHECKIN_BEG'], 'CHILD' => ['CHECKIN_BEG'], ]; } public function STARS() { $data = $this->model->getHOTELS(); $return = [ ['Inc' => 0, 'LName' => '-----', 'selected' => false], ]; $groupStar = Samo_Request::intval('STARS'); $selectedHotel = Samo_Request::intval('HOTELS'); foreach ($data as $hotel) { if (null == $groupStar || $hotel['starGroupList'] == $groupStar) { $return[] = ['Inc' => $hotel['id'], 'LName' => sprintf("%s %s", $hotel['name'], $hotel['star']), 'selected' => ($hotel['id'] == $selectedHotel)]; } } $this->view->add_options('HOTELS', $return); } } 