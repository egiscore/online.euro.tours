<?php
$_messages = array(
    'PAGE_TITLE' => 'Edit agency',
    'LOGIN_EDIT' => 'Edit',
    'PARTPASS_NOT_IN_PARTNER' => 'The user does not belong to this partner.',
    'REQUEST_CHANGES_BTN' => 'Request for changes',
    'PARTNER_REQUEST_CHANGES_TITLE' => "The request for changes data.",
    'PARTNER_REQUEST_CHANGES_SUBJECT' => "The request for changes partner's data.",
    'REQUEST_CHANGES_SUCCESS' => 'A request to change the data was sent to the tour operator.',
    'PARTNER_REQUEST_EMPTY_CHANGES' => 'Changes not detected.',
    'PARTNER_REQUEST_CHANGES_ERROR_405' => 'Do not set up the address to send the request. Contact your tour operator',
    'PARTNER_REQUEST_CHANGES_ERROR_500' => 'Error occurred while send message.',
    'NOT_ENOUGH_RIGHTS_TO_EDIT' => 'Not enough rights to edit.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
