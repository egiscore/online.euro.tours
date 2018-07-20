<?php
$_messages = array(
    'CHECK_PASSPORT' => 'Checking the validity of passports',
    'CHECK_PASSPORT_CITY_DEPARTURE' => 'City of departure',
    'CHECK_PASSPORT_COUNTRY_DESTINATION' => 'Country of destination',
    'CHECK_PASSPORT_CITIZENSHIP' => 'Citizenship',
    'CHECK_PASSPORT_PLACE_BIRTH' => 'Place of birth',
    'CHECK_PASSPORT_DEPARTURE_DATE' => 'Departure date',
    'CHECK_PASSPORT_DURATION' => 'Duration of the tour (nights)',
    'CHECK_PASSPORT_CHECK' => 'Check',
    'CHECK_PASSPORT_VALID' => 'Your passport is suitable for traveling.',
    'CHECK_PASSPORT_VALID_NOTE' => 'Your passport is suitable for travel, but a pre-arranged visa invitation is required.',
    'CHECK_PASSPORT_INVALID' => 'Your passport is not suitable for travel, please reissue your passport.',
    'CHECK_PASSPORT_VALID_DATE' => 'Passport validity period',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
