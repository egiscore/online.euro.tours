<?php
$_messages = array(
    'PAGE_TITLE' => 'Invoice',
    'POPUP_TITLE' => 'Print invoice for reservation',
    'TEMPLATE_NOT_CONFIGURE' => 'The template for this type of contract is not configured. Please refer to the tour operator.',
    'CAN_NOT_LOAD_CLAIM_INFO' => 'Error loading the information on the reservation. Please refer to the tour operator.',
    'CLAIM_NOT_CONFIRMED' => 'The reservation has not been confirmed. Print invoice is impossible. Please refer to the tour operator.',
    'CLAIM_PAYMENT_PARTPAYMENT' => 'Reservation partially paid or paid in full. Print account is impossible. Please refer to the tour operator.',
    'NO_CONTRACT' => 'There is no contract on the date of reservation. Print invoice is impossible. Please refer to the tour operator.',
    'CAN_NOT_LOAD_PARTNER_INFO' => 'Error loading information to the partner. Please refer to the tour operator.',
    'CANNOT_PRINT_INVOICE' => 'Can not print. Please refer to the tour operator.',
    'INVOICE_PRINT' => 'Print',
    'POPUP_PP_TITLE' => 'Payment order',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
