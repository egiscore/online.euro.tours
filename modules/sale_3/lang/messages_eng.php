<?php
$_messages = array(
    'SALE_REFRESH' => 'Find',
    'NO_DATA' => 'No data. Narrow your search.',
    'PAGE_TITLE' => 'Where to buy a tour?',
    'SALE_TOWN' => 'City',
    'SALE_METRO' => 'Metro station',
    'SALE_CONTACTS' => 'Contacts',
    'SALE_BOSS' => 'Director',
    'SALE_LICENSE' => 'License',
    'SALE_ICQ_CONCULTANT' => 'Consultant',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
