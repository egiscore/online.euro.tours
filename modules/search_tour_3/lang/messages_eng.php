<?php
$_messages = array(
    'PAGE_TITLE' => 'Search tour',
    'NO_DATA' => 'No data',
    'NO_DOPDATA' => 'No additional data found.',
    'SERVER_NOT_AVAILABLE' => 'Search in the chosen direction is temporarily unavailable.',
    'PROMOTIONS' => 'promotions',
    'FILTERS' => 'filters',
    'TOUR_SEARCH_PRICE_STATS' => 'Statistics of price changes, transport availability',
    'TOUR_SEARCH_RES_YES_PLACE' => 'seats available',
    'TOUR_SEARCH_RES_YESNO_PLACE' => 'few seats available',
    'TOUR_SEARCH_RES_NO_PLACE' => 'no seats available',
    'TOUR_SEARCH_RES_REQUEST_PLACE' => 'seats on request',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
