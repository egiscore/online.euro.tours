<?php
 class import_cancel_claim_agreement extends UpdateModel { public $title = '������ ���������� ����� �������� �� ������ ������'; public function insert($file, $tour, $user_code) { $sql = $this->db->formatExec( $this->OFFICEDB . '.dbo.up_WEB_3_ADMIN_tour_config', [ 'Section' => 'cancel_claim', 'What' => 'agreement', 'Tour' => $tour ? $tour : null, 'Value' => file_get_contents($file), 'UserCode' => $user_code, ] ); $this->db->query($sql); } public function make() { if (!defined('INTERNET_USER')) { $sql = $this->db->formatExec( $this->OFFICEDB . '.dbo.up_WEB_3_default_usercode' ); $INTERNET_USER = $this->db->fetchOne($sql); } else { $INTERNET_USER = INTERNET_USER; } $return = 0; $dir = _ROOT . 'data/cancel_claim'; if (!(file_exists($dir) && is_dir($dir))) { return $return; } if ($handle = opendir($dir)) { while (false !== ($entry = readdir($handle))) { if ($entry != "." && $entry != "..") { if (preg_match('~^([0-9]+)\.html$~', $entry, $file)) { $this->insert($dir . '/' . $entry, $file[1], $INTERNET_USER); unlink($dir . '/' . $entry); $return++; } } } closedir($handle); } return $return; } } 