<?php
$_messages = array(
    'TICKETS_ADULTS' => 'взрослых',
    'TICKETS_BLOCK_COUNT' => 'Наличие',
    'TICKETS_CHECKIN' => 'Дата',
    'TICKETS_CHECKIN_FROM' => 'обратный рейс',
    'TICKETS_CHECKIN_TO' => 'выбрать дату',
    'TICKETS_CHECKOUT' => 'Обратно',
    'TICKETS_CHILDS' => 'детей',
    'TICKETS_CHILD_AGES' => 'возраст',
    'TICKETS_CLASS' => 'класс',
    'TICKETS_CURRENCY' => 'валюта',
    'TICKETS_INFANT' => 'младенец',
    'TICKETS_FREIGHT' => 'Рейс',
    'TICKETS_PORTFROM' => 'порт вылета',
    'TICKETS_PORTTO' => 'порт прилета',
    'TICKETS_PRICE' => 'Цена',
    'TICKETS_REFRESH' => 'Искать',
    'TICKETS_TIME' => 'Время',
    'TICKETS_TOWNFROM' => 'вылет из',
    'TICKETS_TOWNTO' => 'в',
    'TICKETS_AIRLINE' => 'Авиакомпания',
    'TICKETS_AIRLINE_ANY' => 'Любая',
    'TICKETS_TOO_MANY_ROWS' => 'Обработаны не все данные. Уточните параметры поиска',
    'TICKETS_YESPLACES' => 'есть места',
    'NO_DATA' => 'Данных не найдено. Измените параметры поиска',
    'PAGE_TITLE' => 'Продажа авиабилетов',
    'STAT_NOT_FOUND_FREIGHTS' => 'данных не найдено',
    'STAT_BRON_LINK' => 'бронировать',
    'TICKETS_ONEWAY' => 'В одну сторону',
    'TICKETS_ROUNDTRIP' => 'Туда и обратно',
    'TICKETS_DEPARTURE' => 'Вылет туда',
    'TICKETS_ARRIVAL' => 'Вылет обратно',
    'TICKETS_CHECKOUT_EMPTY' => 'Не указана дата вылета обратно',
    'TICKETS_CHILDS_AGE' => 'возраст детей',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
