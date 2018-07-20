<?php
$_messages = array(
    'PLATRON_POPUP_TITLE' => 'Making payment in Platron',
    'PLATRON_PAYMENT_INFO' => 'Payment info',
    'PLATRON_PAID' => 'Paid:',
    'PLATRON_INPUT_AMOUNT' => 'Amount for payment',
    'PLATRON_SUBMIT' => 'Checkout',
    'PLATRON_PARAMS_NOT_SETS' => 'System settings of Platron not set!',
    'PLATRON_EMPTY_AMOUNT' => 'Enter the amount to pay!',
    'PLATRON_OVER_AMOUNT' => 'You can pay no more than '
);

if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
