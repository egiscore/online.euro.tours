<?php
 namespace Samo\Config; use Phalcon\Di; use \Samo\DB\DB; class Settings { protected $db; protected $userCode; public $params; public $langSort; public $lang; public function __construct($params, DB $db) { $this->db = $db; $this->params = $params; $this->getUserCode(); $this->setLangSort(); $this->lang = \Samo_Request::langid(); } private function setLangSort() { $tourConfig = new TourConfig('online_config'); $tourConfig->userCode = $this->userCode; $tourConfig->what = 'ORDER_BY_NAME'; $result = $tourConfig->result(false); $this->langSort = $result->Value; } public function getUserCode() { $param = false; if ($this->params && isset($this->params->INTERNET_USER) && APPMODE == 'dev') { $param = (int)$this->params->INTERNET_USER; } $this->_setUserCode($param); return $this->userCode; } private function _setUserCode($param = 0) { if ((bool)$param) { return ($this->userCode = $param); } if (!(defined('INTERNET_USER'))) { $query = $this->db->prepare('up_WEB_3_default_usercode', [], 'SLAVE'); return ($this->userCode = $this->db->result($query, DB::FETCH_ONE)); } return ($this->userCode = INTERNET_USER); } public function getLangNameField($name = 'Name', $lName = 'LName') { return $this->langSort == 1 ? $name : $lName; } } 