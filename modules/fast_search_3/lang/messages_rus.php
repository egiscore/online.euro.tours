<?php

include_once __DIR__ . '/../../search_tour_3/lang/messages_rus.php';

$_messages = array(
    'FS_ADULTS' => 'Взрослых',
    'FS_ANY_HOTEL' => 'Любая',
    'FS_CHECKIN' => 'Начало тура',
    'FS_CHILDS' => 'Детей',
    'FS_HOTELINC' => 'Гостиница',
    'FS_LOAD' => 'Искать',
    'FS_NIGHTS' => 'Ночей',
    'FS_NIGHTS_MIN' => 'от',
    'FS_NIGHTS_MAX' => 'до',
    'FS_PRICE' => 'Цена до',
    'FS_STATE' => 'Страна',
    'FS_TOURINC' => 'Тур',
    'FS_TOWNFROM' => 'Вылет из',
    'FS_CURRENCY' => 'Валюта',
    'FS_FULL_PACKET' => 'Полный пакет',
    'FS_HOTEL_ONLY' => 'Только проживание',
    'FS_AVIATICKET_ONLY' => 'Только перелёт',
    'FS_CATEGORY' => 'Категория',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
