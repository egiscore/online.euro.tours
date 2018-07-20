<?php
include_once __DIR__ . '/../../search_tour_3/lang/messages_rus.php';

$_messages = array(
    'CHECKIN' => 'Дата вылета',
    'CURRENCY' => 'Валюта',
    'PAGE_TITLE' => 'Расширенный прайс-лист',
    'TOUR_SEARCH_REFRESH' => 'Обновить',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
