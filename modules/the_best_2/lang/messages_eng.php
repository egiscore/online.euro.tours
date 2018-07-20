<?php
$_messages = array(
// begin [the_best]
'BEST_REFRESH' => 'Refresh',
'PAGE_TITLE' => 'Best offers',
'REFRESH' => 'Refresh',
'THE_BEST_CHECKIN' => 'Check-in',
'THE_BEST_HOTEL' => 'Hotel',
'THE_BEST_HTPLACE' => 'Accommodation',
'THE_BEST_NIGHTS' => 'Nights',
'THE_BEST_PRICE' => 'Price',
'THE_BEST_ROOM' => 'Room',
'THE_BEST_SPO' => 'SPO',
'THE_BEST_STAR' => 'Star',
'THE_BEST_STATE_TO' => 'State',
'THE_BEST_TOUR' => 'Tour',
'THE_BEST_TOWN' => 'Departure town',
'THE_BEST_TOWNTO' => 'Town',
'THE_BEST_LIKE' => 'Similar',
'THE_BEST_MEAL' => 'Meal',
// end [the_best]

);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
