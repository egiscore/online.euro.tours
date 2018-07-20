<?php
$_messages = array(
    'UNITELLER_POPUP_TITLE' => 'Payment processing at Uniteller',
    'UNITELLER_PARAMS_NOT_SETS' => 'Uniteller system parameters are not defined!',
    'UNITELLER_PAID' => 'Paid for:',
    'UNITELLER_INPUT_AMOUNT' => 'Payment amount',
    'UNITELLER_SUBMIT' => 'Pay now',
    'UNITELLER_EMPTY_AMOUNT' => 'Enter the amount to be paid!',
    'UNITELLER_OVER_AMOUNT' => 'You can pay no more than ',
    'UNITELLER_PAYMENT_INFO' => 'Payment Information',
    'UNITELLER_RESULT_TITLE' => 'Result of payment in Uniteller',
    'UNITELLER_RESULT_NO' => 'Payment has not been made',
    'UNITELLER_RESULT_OK' => 'Payment completed successfully',
);

if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
