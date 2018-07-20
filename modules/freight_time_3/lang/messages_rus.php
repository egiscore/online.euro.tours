<?php
$_messages = array (
  'FREIGHT_TIME_ARRIVAL_PORT' => 'А/п',
  'FREIGHT_TIME_AVIACOMPANY' => ' Авиакомпания',
  'FREIGHT_TIME_DATEBEG' => 'Начало программы',
  'FREIGHT_TIME_DATEEND' => ' Окончание программы',
  'FREIGHT_TIME_DAY_WEEK' => ' День недели',
  'FREIGHT_TIME_DEPARTURE_PORT' => 'А/п',
  'FREIGHT_TIME_FREIGHT' => 'Рейс',
  'FREIGHT_TIME_REFRESH' => 'Обновить',
  'FREIGHT_TIME_SRC_TIME' => ' Вылет ',
  'FREIGHT_TIME_SRC_TIME_BACK' => ' Вылет ',
  'FREIGHT_TIME_STATE' => 'Страна:',
  'FREIGHT_TIME_TOWNFROM' => 'Вылет из:',
  'FREIGHT_TIME_TOWNTO' => 'Город назначения:',
  'FREIGHT_TIME_TARGET' => 'Город назначения',
  'FREIGHT_TIME_TRANTYPE' => 'Транспорт',
  'FREIGHT_TIME_TRG_TIME' => 'Прилет',
  'FREIGHT_TIME_TRG_TIME_BACK' => 'Прилет',
  'PAGE_TITLE' => 'Расписание рейсов',
);
if (isset($messages) && is_array($messages))  {$messages = array_merge($messages,$_messages);} else {$messages = $_messages;}
?>