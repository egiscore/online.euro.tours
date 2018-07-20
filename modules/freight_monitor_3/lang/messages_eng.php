<?php
$_messages = array (
  'FREIGHT_AIRPORT_FROM' => 'A/P',
  'FREIGHT_AIRPORT_FROM_RESULT' => 'A/P',
  'FREIGHT_AIRPORT_TO' => 'A/P',
  'FREIGHT_CLASS' => 'class',
  'FREIGHT_DATE' => 'date',
  'FREIGHT_AK' => 'A/C',
  'FREIGHT_DATE_RESULT' => 'Departure',
  'FREIGHT_DELTA' => '+/-',
  'FREIGHT_NAME_IN' => 'Direct flight',
  'FREIGHT_NAME_OUT' => 'Back flight',
  'FREIGHT_NIGHTS_FROM' => 'nights',
  'FREIGHT_NOPLACE' => '&nbsp;no seats',
  'FREIGHT_PLACES_AVAILABILITY_ECONOM' => 'Econom',
  'FREIGHT_PLACES_AVAILABILITY_BUSINES' => 'Business',
  'FREIGHT_REFRESH' => 'refresh',
  'FREIGHT_STATE_TO' => 'state',
  'FREIGHT_STOP_ANY_NIGHTS' => 'All',
  'FREIGHT_STOP_NIGHTS_ECONOM' => 'Stop(econom)',
  'FREIGHT_STOP_NIGHTS_BUSINES' => 'Stop(business)',
  'FREIGHT_TIME_FROM' => 'Time',
  'FREIGHT_TIME_TO' => 'Time',
  'FREIGHT_TOUR_NAME' => 'tour',
  'FREIGHT_TOWNTO_NAME' => 'arrival town',
  'FREIGHT_TOWN_FROM' => 'departure town',
  'FREIGHT_TRANSPORT_IN' => 'Transport',
  'FREIGHT_TRANSPORT_OUT' => 'Transport',
  'FREIGHT_YESNOPLACE' => '&nbsp;few seats',
  'FREIGHT_YESPLACE' => '&nbsp;seats available',
  'FREIGHT_TOWNFROM' => 'Departure town',
  'FREIGHT_TOWNTO' => 'Arrival town',
  'FREIGHT_AIRLINE' => 'Airline',
  'PAGE_TITLE' => 'Flights monitor',
  'noplace' => 'no',
  'requestplace' => 'on request',
  'yesnoplace' => 'few',
  'yesplace' => 'enough',
  'default' => '',
  'FREIGHT_SELECT_TOUR' => 'Choose a tour or destination city',
  'FREIGHT_FLEW' => 'already departed',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
