<?php
 function smarty_modifier_inflect($n,$form1, $form2, $form5) { $num = strval($n); if (intval($n) < floatval($n)) { return $num.' '.$form2; } $n = abs($n) % 100; $n1 = $n % 10; if ($n > 10 && $n < 20) return $num.' '.$form5; if ($n1 > 1 && $n1 < 5) return $num.' '.$form2; if ($n1 == 1) return $num.' '.$form1; return $num.' '.$form5; } ?>
