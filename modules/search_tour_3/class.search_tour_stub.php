<?php
 class Search_Tour_Stub extends Search_Tour_Model { protected $api_name = 'Search_Tour_Api'; protected $blank_row = ['id' => 0, 'name' => '-----', 'nameAlt' => '-----', 'selected' => true, 'statefromKey' => 0, 'statefromname' => '-----', 'statefromnameAlt' => '-----']; public function __construct() { $cache = Samo_Registry::get('cache'); $cache->driver('Internal'); $cache->set( 'config_online_config___', array( 'TOWN_ORDER_BY_NAME' => array('Value' => -1), 'STATE_ORDER_BY_NAME' => array('Value' => -1), 'STATE_DEFAULT' => array('Value' => 0), 'ORDER_BY_NAME' => array('Value' => 0), 'INTERNET_USER' => array('Value' => 0), ) ); $stub = new Database_Stub(); Samo_Registry::set('db', $stub); parent::__construct(); $this->defaults['COSTMIN'] = null; $this->defaults['COSTMAX'] = null; $this->defaults['ADULT'] = null; $this->defaults['CHILD'] = null; $this->defaults['NIGHTS_FROM'] = null; $this->defaults['NIGHTS_TILL'] = null; } public function getTOWNFROMINC() { $result = parent::getTOWNFROMINC(); return $this->blank_row(($result) ? $result : [], Samo_Request::get('TOWNFROMINC')); } public function getSTATEINC() { $result = parent::getSTATEINC(); return $this->blank_row(($result) ? $result : [], Samo_Request::get('STATEINC')); } private function blank_row($array, $id) { $exists = false; foreach ($array as $row) { $exists = (!$exists && $row['id'] == $id) ? true : $exists; } if (!$exists) { $array[] = $this->blank_row; } return $array; } public function getTOURINC() { return $this->blank_row(array(), 0); } public function defaults($param) { return null; } } 