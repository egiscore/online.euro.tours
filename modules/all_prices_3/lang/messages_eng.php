<?php
include_once __DIR__ . '/../../search_tour_3/lang/messages_eng.php';

$_messages = array(
    'CHECKIN' => 'Check-in',
    'CURRENCY' => 'Currency',
    'PAGE_TITLE' => 'Detailed price list',
    'TOUR_SEARCH_REFRESH' => 'Refresh',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
