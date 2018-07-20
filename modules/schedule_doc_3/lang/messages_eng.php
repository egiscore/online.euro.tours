<?php
$_messages = array(
    'ARRIVAL' => 'Departures',
    'CODE' => 'Code',
    'DATETIME' => 'Date of issue',
    'DEPARTURE' => 'Arrival',
    'FLY_DATE' => 'Date of departure',
    'FREIGHT' => 'Transport',
    'NOTE' => 'Note',
    'PAGE_TITLE' => 'Schedule issuing documents',
    'TOUR' => 'Tour',
    'SHEDULE_DOC_TOWNFROM' => 'City',
    'SHEDULE_DOC_STATE' => 'State',
    'SHEDULE_DOC_OFFICE' => 'Office issuing documents',
    'SHEDULE_DOC_CHECKIN' => 'Date of departure',
    'REFRESH' => 'Show',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
