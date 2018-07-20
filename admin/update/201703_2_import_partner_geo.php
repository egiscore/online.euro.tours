<?php
 class import_partner_geo extends UpdateModel { public $title = '������ ��������� �������� ��� ������ "��� ������"'; public $modules_required = array('sale'); private $requestCount = 0; const REQUEST_LIMIT = 10; public function make() { if (!defined('INTERNET_USER')) { $sql = $this->db->formatExec( $this->OFFICEDB . '.dbo.up_WEB_3_default_usercode' ); $INTERNET_USER = $this->db->fetchOne($sql); } else { $INTERNET_USER = INTERNET_USER; } if (!defined('MAP_KEY')) { $sql = $this->db->formatExec( $this->OFFICEDB . '.dbo.up_WEB_3_tour_config', ['Section' => 'online_config', 'What' => 'MAP_KEY', 'UserCode' => $INTERNET_USER] ); $MAP_KEY = $this->db->fetchOne($sql); } else { $MAP_KEY = MAP_KEY; } if ($MAP_KEY) { $page = 1; while ($this->requestCount < self::REQUEST_LIMIT) { $sql = $this->db->formatExec( $this->OFFICEDB . '.dbo.up_WEB_3_sale_List', [ 'Town' => null, 'Page' => $page, 'UserCode' => $INTERNET_USER, ] ); $partners = $this->db->fetchAll($sql); if ($partners !== false && count($partners)) { foreach ($partners as $partner) { if ($partner['latitude'] == null && $partner['address']) { $this->fetchAndSaveGeo($partner, $MAP_KEY); } } $page++; } else { return 0; } } } return -1; } private function fetchAndSaveGeo($partner, $apiKey) { $this->requestCount++; $params = [ 'key' => $apiKey, 'sensor' => false, 'language' => 'ru', 'address' => mb_convert_encoding(sprintf('%s, %s', $partner['TownName'], $partner['address']), 'utf-8', 'windows-1251'), ]; $url = 'https://maps.googleapis.com/maps/api/geocode/json?' . http_build_query($params); if ($json = @file_get_contents($url)) { $data = @json_decode($json, true); if ($data && isset($data['results'])) { foreach ($data['results'] AS $address) { if (isset($address['geometry'])) { $latitude = $address['geometry']['location']['lat']; $longitude = $address['geometry']['location']['lng']; $sql = $this->db->formatQuery("EXEC " . $this->OFFICEDB . ".dbo.sp_executesql N'UPDATE [dbo].[partner] SET [latitude] = @lat, [longitude] = @lon WHERE [inc] = @inc', N'@inc INT, @lat decimal(9, 6), @lon decimal(9, 6)', %d, %s, %s", array($partner['Inc'], $latitude, $longitude)); $this->db->query($sql); } } } } } } 