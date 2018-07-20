<?php
$_messages = array(
    'H_STOPSALE_HOTEL' => 'Гостиница:',
    'H_STOPSALE_HOTEL_RES' => 'Гостиница',
    'H_STOPSALE_HTPLACE' => 'Размещение',
    'H_STOPSALE_MEAL' => 'Питание',
    'H_STOPSALE_NOTE' => 'Примечание',
    'H_STOPSALE_REFRESH' => 'Показать',
    'H_STOPSALE_ROOM' => 'Номер',
    'H_STOPSALE_STATE' => 'Страна:',
    'H_STOPSALE_STOP' => 'Остановка продаж',
    'H_STOPSALE_TOWN' => 'Город:',
    'H_STOPSALE_TYPE' => 'Тип остановки',
    'H_STOPSALE_TOWN_RES' => 'Город',
    'H_STOPSALE_ZAEZD' => 'На заезд',
    'H_STOPSALE_NIGHTS' => 'На заезд ( %d ночей )',
    'H_STOPSALE_SPO' => 'Для СПО %s',
    'H_STOPSALE_PTYPE' => 'Для программы %s',
    'PAGE_TITLE' => 'Остановки продаж в гостиницах',
    'H_STOPSALE_TOWNFROM' => 'Город отправления:',
    'H_STOPSALE_INCOMING_PARTNER' => 'Принимающая сторона',
    'H_STOPSALE_ALL' => 'Все',
    'H_STOPSALE_PERIOD_RDATE' => 'период подачи заявок:',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
