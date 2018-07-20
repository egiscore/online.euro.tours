<?php
$_messages = array(
    'TICKETS_ADULTS' => 'adult',
    'TICKETS_BLOCK_COUNT' => 'Avail',
    'TICKETS_CHECKIN' => 'Date',
    'TICKETS_CHECKIN_FROM' => 'Departure from',
    'TICKETS_CHECKIN_TO' => 'till',
    'TICKETS_CHECKOUT' => 'Back',
    'TICKETS_CHILDS' => 'child',
    'TICKETS_CHILD_AGES' => 'age',
    'TICKETS_CLASS' => 'class',
    'TICKETS_CURRENCY' => 'currency',
    'TICKETS_INFANT' => 'infant',
    'TICKETS_FREIGHT' => 'Freight',
    'TICKETS_PORTFROM' => 'port from',
    'TICKETS_PORTTO' => 'port to',
    'TICKETS_PRICE' => 'Price',
    'TICKETS_REFRESH' => 'Search',
    'TICKETS_TIME' => 'Time',
    'TICKETS_TOWNFROM' => 'departure town',
    'TICKETS_TOWNTO' => 'town',
    'TICKETS_AIRLINE' => 'Airline',
    'TICKETS_AIRLINE_ANY' => 'Any',
    'TICKETS_TOO_MANY_ROWS' => 'Not all data was processing',
    'TICKETS_YESPLACES' => 'seats available',
    'NO_DATA' => 'Data not found. Modify your search',
    'PAGE_TITLE' => 'Sell tickets',
    'STAT_NOT_FOUND_FREIGHTS' => 'not found',
    'STAT_BRON_LINK' => 'reserve',
    'TICKETS_ONEWAY' => 'One way',
    'TICKETS_ROUNDTRIP' => 'Roundtrip',
    'TICKETS_DEPARTURE' => 'Departure',
    'TICKETS_ARRIVAL' => 'Arrival',
    'TICKETS_CHECKOUT_EMPTY' => 'Not the date of departure back',
    'TICKETS_CHILDS_AGE' => 'age of children',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
