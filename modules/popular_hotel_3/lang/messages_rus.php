<?php
$_messages = array(
    'PAGE_TITLE' => 'Популярные отели',
    'HOTEL_STAR' => 'Категория',
    'HOTEL_NAME' => 'Гостиница',
    'HOTEL_ROOM' => 'Номер',
    'HOTEL_HTPLACE' => 'Размещение',
    'HOTEL_MEAL' => 'Питание',
    'HOTEL_NIGHTS' => 'Ночей',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
