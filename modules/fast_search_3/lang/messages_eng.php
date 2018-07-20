<?php

include_once __DIR__ . '/../../search_tour_3/lang/messages_eng.php';

$_messages = array(
    'FS_ADULTS' => 'Adult',
    'FS_ANY_HOTEL' => 'Any',
    'FS_CHECKIN' => 'From',
    'FS_CHILDS' => 'Child',
    'FS_HOTELINC' => 'Hotel',
    'FS_LOAD' => 'Search',
    'FS_NIGHTS' => 'Nights',
    'FS_NIGHTS_MIN' => 'from',
    'FS_NIGHTS_MAX' => 'till',
    'FS_PRICE' => 'Price till',
    'FS_STATE' => 'State',
    'FS_TOURINC' => 'Tour',
    'FS_TOWNFROM' => 'From',
    'FS_CURRENCY' => 'Currency',
    'FS_FULL_PACKET' => 'Full packet',
    'FS_HOTEL_ONLY' => 'Only hotel',
    'FS_AVIATICKET_ONLY' => 'Only flight',
    'FS_CATEGORY' => 'Category',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
