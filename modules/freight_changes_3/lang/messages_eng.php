<?php
$_messages = array(
    'FRCHANGES_PUBLIC' => 'Public',
    'FRCHANGES_TEXT_1' => 'Flight',
    'FRCHANGES_REFRESH' => 'Refresh',
    'FRCHANGES_TOWNFROM' => 'Departure town',
    'FRCHANGES_STATE' => 'State',
    'FRCHANGES_TOURNAME' => 'Tour',
    'FRCHANGES_DATE' => 'Departure date',
    'PAGE_TITLE' => 'Freight changes',
    'FRCHANGES_ROUTE' => 'Route',
    'FRCHANGES_TEXT_2' => 'route',
    'FRCHANGES_TEXT_3' => 'instead',
    'FRCHANGES_TEXT_4' => 'will be performed',
    'FRCHANGES_TEXT_5' => 'flight',
    'FRCHANGES_TEXT_6' => 'at',
    'FRCHANGES_TEXT_7' => 'from',
    'FRCHANGES_TEXT_8' => 'flight route',
    'FRCHANGES_TEXT_9' => 'instead flight',
    'FRCHANGES_TEXT_10' => 'will fly',
    'FRCHANGES_TEXT_11' => 'Published',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
