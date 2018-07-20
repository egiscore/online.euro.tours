<?php
 include_once dirname(__FILE__).'/modifier.glue.php'; function smarty_modifier_linkify($text,$href,$target = '_blank', $class = '') { if (strlen($href)) { $attrs = array(); $attrs['href'] = Samo_Url::parse($href); if ($target) { $attrs['target'] = $target; } if ($class) { $attrs['class'] = $class; } return '<a '.smarty_modifier_glue($attrs,' ').'>'.$text.'</a>'; } return $text; } ?>
