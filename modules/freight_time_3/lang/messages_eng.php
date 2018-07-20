<?php
$_messages = array(
    'FREIGHT_TIME_ARRIVAL_PORT' => 'AP',
    'FREIGHT_TIME_AVIACOMPANY' => ' Airline',
    'FREIGHT_TIME_DATEBEG' => 'Date start of program',
    'FREIGHT_TIME_DATEEND' => ' Date end of program',
    'FREIGHT_TIME_DAY_WEEK' => ' Day of week',
    'FREIGHT_TIME_DEPARTURE_PORT' => 'AP',
    'FREIGHT_TIME_FREIGHT' => 'Flight',
    'FREIGHT_TIME_REFRESH' => 'Refresh',
    'FREIGHT_TIME_SRC_TIME' => ' Departure ',
    'FREIGHT_TIME_SRC_TIME_BACK' => ' Departure ',
    'FREIGHT_TIME_STATE' => 'State:',
    'FREIGHT_TIME_TOWNFROM' => 'Departure from:',
    'FREIGHT_TIME_TOWNTO' => 'Town destination:',
    'FREIGHT_TIME_TARGET' => 'Town destination',
    'FREIGHT_TIME_TRANTYPE' => 'Transport',
    'FREIGHT_TIME_TRG_TIME' => 'Arrival',
    'FREIGHT_TIME_TRG_TIME_BACK' => 'Arrival',
    'PAGE_TITLE' => 'Flights schedule',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
