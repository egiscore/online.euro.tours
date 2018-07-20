<?php
 function smarty_modifier_datetime_format($timestamp) { if (empty($format)) { $format = 'datetime'; } else { $format = strip_tags(str_replace(array('%d','%m','%Y','%y','%H','%M','%F','&nbsp;'),array('d','m','Y','y','H','i','f','&#160;'),$format)); } if (!$timestamp instanceof Samo_Datetime) { $timestamp = Samo_Datetime::parse($timestamp); } return $timestamp->format($format); } ?>
