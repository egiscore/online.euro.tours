<?php
 function smarty_modifier_ucfirst($string){ $o_locale = setlocale(LC_ALL,0); setlocale(LC_ALL,array('ru_RU.cp1251','ru_RU','russian')); $string = ucfirst($string); setlocale(LC_ALL,$o_locale); return $string; } ?>
