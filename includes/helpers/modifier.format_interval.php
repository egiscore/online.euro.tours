<?php
 function smarty_modifier_format_interval($nights,$any_title) { if (is_null($nights)) { return '';} $nights = explode(',',$nights); if (in_array(0,$nights)) return $any_title; if (count($nights) == 1) return $nights[0]; $return = array(); sort($nights); $num = 0; $return[$num++] = $nights[0]; for ($i = 1; $i < (count($nights)); $i++) { if ((($nights[$i] - 1) == $nights[$i - 1]) && (($nights[$i] + 1) == $nights[$i + 1]) ) { if ($return[$num - 1] != '-') { $return[$num++] = '-'; } } else { if ($return[$num - 1] != '-') { $return[$num++] = ','; } $return[$num++] = $nights[$i]; } } return implode('',$return); } ?>