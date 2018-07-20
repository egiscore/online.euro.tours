<?php
$_messages = array(
    'KKB_KZ_POPUP_TITLE' => 'Making payment in Kazkommertsbank',
    'KKB_KZ_PARAMS_NOT_SETS' => 'Kazkommertsbank system parameters are not set!',
    'KKB_KZ_PAID' => 'Paid:',
    'KKB_KZ_INPUT_AMOUNT' => 'Amount for payment',
    'KKB_KZ_INPUT_EMAIL' => 'E-mail',
    'KKB_KZ_SUBMIT' => 'Checkout',
    'KKB_KZ_EMPTY_AMOUNT' => 'Enter the amount to pay!',
    'KKB_KZ_OVER_AMOUNT' => 'You can pay no more than ',
    'KKB_KZ_PAYMENT_INFO' => 'Payment info',
    'KKB_KZ_RESULT_TITLE' => 'Result of payments in Kazkommertsbank',
    'KKB_KZ_RESULT_FAIL' => 'Payment has not been implemented',
    'KKB_KZ_RESULT_OK' => 'Payment is made successfully',
);

if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
