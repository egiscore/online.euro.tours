<?php
$_messages = array(
    'PAGE_TITLE' => 'Partners ratings',
    'RATING_AMOUNT' => 'Amount sum, $:',
    'RATING_CREATE_DATETIME' => 'Last update time:',
    'RATING_DEPTH' => 'Depth sales:',
    'RATING_INTERNET_CLAIMS_COUNT' => 'Reservations by INTERNET:',
    'RATING_INTERNET_CLAIMS_PERCENT' => 'Percent reservations by INTERNET:',
    'RATING_NO_ACCESS' => "You don't have permission to view this rating",
    'RATING_PAID' => 'Paid sum, $:',
    'RATING_PAX' => 'Pax:',
    'RATING_RCOUNT' => 'Rooms count:',
    'RATING_POSITION' => 'Rating position:',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
