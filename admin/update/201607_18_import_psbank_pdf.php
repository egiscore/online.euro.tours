<?php
 class import_psbank_pdf extends UpdateModel { public $title = '������ PDF ��������'; public function make() { $return = 0; $dir = _ROOT . 'data/psbank/'; if (!(file_exists($dir) && is_dir($dir))) { return $return; } if ($handle = opendir($dir)) { while (false !== ($entry = readdir($handle))) { if ($entry != "." && $entry != "..") { if (preg_match('~^platezhka_?([0-9]+)?\.fpdf$~', $entry, $file)) { if (!isset($file[1])) { $file[1] = 'null'; } $this->db->query("insert into " . $this->OFFICEDB . ".settings.printform (doccategory, legacy_form_name, print_form_inc, online_bank) values (20, '" . $file[0] . "', null," . $file[1] . ")"); } } } closedir($handle); } return $return; } } 