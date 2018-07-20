<?php
$_messages = array(
    'PAGE_TITLE' => 'Popular hotels',
    'HOTEL_STAR' => 'Category',
    'HOTEL_NAME' => 'Hotel',
    'HOTEL_ROOM' => 'Room',
    'HOTEL_HTPLACE' => 'Placement',
    'HOTEL_MEAL' => 'Meal',
    'HOTEL_NIGHTS' => 'Nights',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
