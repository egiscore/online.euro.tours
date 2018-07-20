<?php
$_messages = array(
    'PAGE_TITLE' => 'Air fare',
    'AC_CLAIM_NUMBER' => 'Reservation ¹',
    'AC_TOUR_ROUTE' => 'Route:',
    'AC_CLASS' => 'Class:',
    'AC_PEOPLE_NAME' => 'Full name',
    'AC_PEOPLE_LNAME' => 'Name in English',
    'AC_NO_PEOPLES' => 'No tourists found',
    'AC_PRINT_BTN' => 'Print',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
