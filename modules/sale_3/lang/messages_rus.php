<?php
$_messages = array(
    'SALE_REFRESH' => 'Найти',
    'NO_DATA' => 'Нет данных. Уточните параметры поиска.',
    'PAGE_TITLE' => 'Где купить тур?',
    'SALE_TOWN' => 'Город',
    'SALE_METRO' => 'Станция метро',
    'SALE_CONTACTS' => 'Контакты',
    'SALE_BOSS' => 'Директор',
    'SALE_LICENSE' => 'Лицензия',
    'SALE_ICQ_CONCULTANT' => 'Консультант',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
