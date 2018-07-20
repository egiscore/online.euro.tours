<?php
 class Freight_Time_Model extends Samo_Tourinfo { public function construct() { parent::construct(); $this->defaults['TOWNTOINC'] = Samo_Request::intval('TOWNTOINC'); } public function getTOWNFROMINC() { $sql = $this->db->formatExec($this->ONLINEDB . '.dbo.up_WEB_4_frtime_TownFrom', ['TOWN_ORDER_BY_NAME' => $this->getConfig('TOWN_ORDER_BY_NAME')]); $towns = Samo_Utils::ifs($this->db->fetchAll($sql), array()); foreach ($towns as $row) { $row['selected'] = $row['id'] == $this->townFrom(); } return $towns; } public function getSTATEINC() { $cache_key = __METHOD__ . $this->TOWNFROMINC; if (!$return = $this->cache->get($cache_key)) { $sql = $this->db->formatExec( $this->ONLINEDB . '.dbo.up_WEB_3_frtime_State', [ 'TownFrom' => $this->townFrom(), 'Order_by_name' => $this->getConfig('ORDER_BY_NAME'), ] ); $return = $this->stateinc($sql); $return = array_filter( $return, function ($state) { return (bool)$state['Inc']; } ); $this->cache->set($cache_key, $return); } foreach ($return as &$row) { $row['selected'] = ($row['Inc'] == $this->defaults['STATEINC'] || 1 == count($return)); } return $return; } public function getTOWNTOINC() { $cache_key = __METHOD__ . $this->defaults['STATEINC'] . '_' . $this->TOWNFROMINC; if (!$return = $this->cache->get($cache_key)) { $sql = $this->db->formatExec( $this->ONLINEDB . '.dbo.up_WEB_3_frtime_TownTo', [ 'TownFrom' => $this->townFrom(), 'State' => $this->defaults['STATEINC'], 'Order_by_name' => $this->getConfig('ORDER_BY_NAME'), ] ); $return = Samo_Utils::ifs($this->db->fetchAll($sql), []); $return = array_map( function ($res) use ($return) { $a = $res; return [ 'Inc' => $res['TownInc'], 'Name' => $res['TownName'], 'LName' => $res['TownLName'], 'altName' => $res['TownAltName'], 'selected' => ($res['TownInc'] == $this->defaults['TOWNTOINC'] || 1 == count($return)), ]; }, $return ); array_unshift($return, ['Inc' => 0, 'LName' => '----', 'Name' => '----', 'selected' => false]); $this->cache->set($cache_key, $return); } foreach ($return as &$row) { $row['selected'] = ($row['Inc'] == $this->defaults['TOWNTOINC'] || 1 == count($return)); } return $return; } public function getFreightTime() { $cache_key = __METHOD__ . $this->defaults['STATEINC'] . '_' . $this->townFrom() . '_' . $this->db->quote($this->defaults['TOWNTOINC']); if (!$return = $this->cache->get($cache_key)) { $return = array(); $sql = $this->db->formatExec( $this->ONLINEDB . '.dbo.up_WEB_3_frtime_List', [ 'TownFrom' => $this->townFrom(), 'State' => $this->defaults['STATEINC'], 'TownTo' => $this->defaults['TOWNTOINC'], ] ); if (false !== ($res = $this->db->query($sql))) { if ($this->db->numRows($res) > 0) { while (false !== ($row = $this->db->fetchRow($res))) { $day_delta = ((intval($row['DTrgTime']) - intval($row['DSrcTime'])) < 0) ? 1 : 0; $row['DSrcTimeDelta'] = $row['DDelay']; $tmp = (int)$row['DDelay'] + (int)$row['DDays']; $row['DTrgTimeDelta'] = ($tmp) ? $tmp : $day_delta; $day_delta = ((intval($row['BTrgTime']) - intval($row['BSrcTime'])) < 0) ? 1 : 0; $row['BSrcTimeDelta'] = $row['BDelay']; $tmp = (int)$row['BDelay'] + (int)$row['BDays']; $row['BTrgTimeDelta'] = ($tmp) ? $tmp : $day_delta; $return[] = $row; } } $this->db->freeResult($res); } $this->cache->set($cache_key, $return, $this->price_cache); } return $return; } } 