<?php
function smarty_modifier_spo2link($fullNumber, $ext = 'xls') { $fileURL = 'data/spo/' . preg_replace('~[^a-z0-9]~i', '_', $fullNumber) . '.' . $ext; $filePath = _ROOT . '/' . $fileURL; $smarty = Samo_Registry::get('view'); $HOST = (defined('ASSETS_HOST')) ? ASSETS_HOST : $_SERVER['HTTP_HOST']; $WWWROOT = ($smarty->full_paths()) ? 'http://' . $HOST . $smarty->getTemplateVars('WWWROOT') : $smarty->getTemplateVars('WWWROOT'); if (file_exists($filePath) && is_file($filePath) && is_readable($filePath)) { return '<a href="' . $WWWROOT . $fileURL . '"><img src="' . $WWWROOT . 'public/pict/' . $ext . '.gif"></a>'; } return ' '; } 