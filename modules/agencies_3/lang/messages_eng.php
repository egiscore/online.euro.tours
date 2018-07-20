<?php
$_messages = array(
    'AGENCIES_SEARCH_LABEL' => 'Query:',
    'AGENCIES_ENTER_YOUR_QUERY' => 'INN / Name / Name of director / Phone',
    'AGENCIES_SEARCH' => 'Find',
    'PAGE_TITLE' => 'Check partner',
    'AGENCIES_NAME' => 'Title',
    'AGENCIES_TITLE' => 'Abbreviated title',
    'AGENCIES_TOWN' => 'City',
    'AGENCIES_TOWN_FILTER' => 'City',
    'AGENCIES_METROSTATION_FILTER' => 'Metrostation',
    'AGENCIES_ADDRESS' => 'Address',
    'AGENCIES_INN' => 'INN',
    'AGENCIES_OGRN' => 'OGRN',
    'AGENCIES_KPP' => 'KPP',
    'AGENCIES_DATE_REGISTER' => 'Date of first registration',
    'AGENCIES_DATE_CLOSE' => 'Date of cessation of activity',
    'AGENCIES_STATUS' => 'Status (state)',
    'AGENCIES_STATUS_YES' => 'Valid',
    'AGENCIES_STATUS_NO' => 'Not valid',
    'AGENCIES_OWNER' => 'Head',
    'AGENCIES_ACTIVITIE' => 'Primary Business Type',
    'AGENCIES_OKVED' => 'OKVED',
    'AGENCIES_DOG' => 'The current contract',
    'AGENCIES_AVAILABLE' => 'In stock',
    'AGENCIES_AVAILABLE_YES' => 'Yes',
    'AGENCIES_AVAILABLE_NO' => 'No',
    'AGENCIES_LAST_ORDER' => 'Date of last claim',
    'AGENCIES_DATE' => 'Information is accurate at',
    'AGENCIES_RATING' => 'Raiting',

    'AGENCIES_MORE' => 'Read more',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
