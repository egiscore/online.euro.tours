<?php
 class All_Prices_Model extends Search_Tour_Model { public function __construct(Samo_Config $config = null) { if (($townfrom = Samo_Request::intval('TOWNFROMINC')) && $townfrom === Samo::TOWNFROMHOTELINC) { $this->api_name = 'Search_Hotel_Api'; } parent::__construct($config); } public function construct() { $this->defaults['CATCLAIM'] = Samo_Request::hexval('CATCLAIM'); $this->defaults['CATCLAIM_INFO'] = null; $mindate = Samo_Datetime::today(); $maxdate = Samo_Datetime::today()->add_days(730); $this->defaults['CHECKIN_BEG'] = Samo_Request::date('CHECKIN_BEG', $mindate, $maxdate); $this->defaults['CHECKIN_END'] = Samo_Request::date('CHECKIN_END', $mindate, $maxdate); $this->defaults['NIGHTS'] = []; if ($this->defaults['CATCLAIM']) { $this->catclaimInfo(); } else { $this->defaults['HOTELS'] = Samo_Request::intval('HOTELINC'); } $this->defaults['SORT_TYPE'] = 2; $this->defaults['MAXRECORD'] = 30000; $this->defaults['REC_ON_PAGE'] = 30000; $this->defaults['NIGHTS_FROM'] = 1; $this->defaults['NIGHTS_TILL'] = 31; $this->defaults['ADULT'] = null; $this->defaults['CHILD'] = null; $this->defaults['SPOINC'] = null; $this->defaults['SHOW_THEBEST'] = 0; $this->defaults['PARTITION_PRICE'] = Search_Api::PARTITION_BY_NIGHTS + Search_Api::PARTITION_BY_MEAL + Search_Api::PARTITION_BY_ROOM + Search_Api::PARTITION_BY_HTPLACE; } public function getPrices() { $prices = $nights = $return = []; if ($this->defaults['HOTELS'] && $data = $this->api()->getPRICES()) { foreach ($data['prices'] as $row) { $row['selected'] = $row['id'] == $this->defaults['CATCLAIM']; $prices[$row['meal']][$row['room'] . '/' . $row['htPlace']][$row['nights']] = $row; $nights[] = $row['nights']; } $nights = array_unique($nights); sort($nights); foreach ($prices as $meal => $htplaces) { foreach ($htplaces as $htplace => $_nights) { foreach ($nights as $night) { $return[$meal][$htplace][$night] = (isset($_nights[$night])) ? $_nights[$night] : array(); } } } $this->defaults['NIGHTS'] = $nights; } return (count($return)) ? $return : false; } public function nights() { return $this->defaults['NIGHTS']; } public function catclaimInfo() { if (is_null($this->defaults['CATCLAIM_INFO'])) { $sql = $this->db->formatExec('<ONLINEDB>.dbo.up_WEB_3_catclaim_info', ['Cat_Claim' => $this->defaults['CATCLAIM']]); if ($return = $this->db->fetchRow($sql)) { $this->defaults['CATCLAIM_INFO'] = $return; $this->defaults['PACKET'] = $return['Packet']; $this->defaults['HOTELS'] = $return['HotelInc']; $this->defaults['CHECKIN_BEG'] = $this->defaults['CHECKIN_BEG']->is_null() ? $return['CheckIn'] : $this->defaults['CHECKIN_BEG']; $this->defaults['CHECKIN_END'] = $this->defaults['CHECKIN_BEG']; $this->defaults['STATEFROM'] = $return['StateFrom']; $this->defaults['TOURINC'] = $return['TourInc']; $this->defaults['PROGRAMINC'] = $return['PtypeInc']; $this->state($return['StateInc']); $this->townFrom($return['TownFrom']); } } else { $return = $this->defaults['CATCLAIM_INFO']; } return $return; } public function setStopNote(& $value) { $this->_setStopNote($value); } public function checkPrice($value) { $value = parent::checkPrice($value); $value['selected'] = ($value['Cat_Claim'] == $this->defaults['CATCLAIM']); return $value; } public function getCURRENCY() { $tourinc = $this->defaults['TOURINC']; $this->defaults['TOURINC'] = null; $return = parent::getCURRENCY(); $this->defaults['TOURINC'] = $tourinc; return $return; } } 