<?php
$_messages = array(
    'H_STOPSALE_HOTEL' => 'Hotel:',
    'H_STOPSALE_HOTEL_RES' => 'Hotel',
    'H_STOPSALE_HTPLACE' => 'Accommodation',
    'H_STOPSALE_MEAL' => 'Meal',
    'H_STOPSALE_NOTE' => 'Note',
    'H_STOPSALE_REFRESH' => 'Refresh',
    'H_STOPSALE_ROOM' => 'Room',
    'H_STOPSALE_STATE' => 'State:',
    'H_STOPSALE_STOP' => 'Stop sale',
    'H_STOPSALE_TOWN' => 'Town:',
    'H_STOPSALE_TYPE' => 'Type',
    'H_STOPSALE_TOWN_RES' => 'Town',
    'H_STOPSALE_ZAEZD' => 'on check-in',
    'H_STOPSALE_NIGHTS' => 'On check-in ( %d nights )',
    'H_STOPSALE_SPO' => 'For SPO %s',
    'H_STOPSALE_PTYPE' => 'For program %s',
    'PAGE_TITLE' => 'Hotel stopsale',
    'H_STOPSALE_TOWNFROM' => 'Departure town:',
    'H_STOPSALE_INCOMING_PARTNER' => 'Incoming partner',
    'H_STOPSALE_ALL' => 'All',
    'H_STOPSALE_PERIOD_RDATE' => 'reservation period:',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
