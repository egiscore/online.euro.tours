<?php
$_messages = array(
    'PAGE_TITLE' => 'Ticket print',
    'POPUP_TITLE' => 'Ticket print for claim',
    'CAN_NOT_LOAD_CLAIM_INFO' => 'Error loading information about the claim. Contact your tour operator.',
    'TOUR_ALREADY_BEGIN' => 'Print is forbidden, as the tour has already started.',
    'CANNOT_PRINT_DAYS' => 'Print is forbidden since before the tour for more than %d days.',
    'MORE_COMMON' => 'There are several tourist accommodation is attached. Contact your tour operator.',
    'TICKET_DITRIBUTED' => 'Tickets are issued. Contact your tour operator.',
    'NO_TICKET_NUMBER' => 'Unknown ticket number. Contact your tour operator.',
    'CAN_NOT_LOAD_RESULT_PEOPLEINFO' => 'Not able to get information about tourist.',
    'TRANSPORT' => 'Transport',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
