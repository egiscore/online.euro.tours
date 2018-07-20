<?php
$_messages = array(
    'SBERBANK_RESULT_TITLE' => 'Result of payment',
    'SBERBANK_POPUP_TITLE' => 'Making a payment in Sberbank',
    'SBERBANK_PAYMENT_INFO' => 'Payment Information',
    'SBERBANK_PAID' => 'Paid for:',
    'SBERBANK_INPUT_AMOUNT' => 'Payment amount',
    'SBERBANK_SUBMIT' => 'Pay',
    'SBERBANK_PARAMS_NOT_SETS' => 'The parameters of the Sberbank system are not set!',
    'SBERBANK_EMPTY_AMOUNT' => 'Enter the amount to be paid!',
    'SBERBANK_RESULT_ERROR_INUMBER' => 'An error occurred while receiving the payment status (%s). Contact the tour operator!',
    'SBERBANK_RESULT_ERROR' => 'An error occurred while receiving the payment status (%s). Contact the tour operator!',
    'SBERBANK_RESULT_ERROR_INVALID_INUMBER' => 'Invalid invoice number. Contact the tour operator!',
    'SBERBANK_RESULT_ERROR_ORDER_NOT_FOUND' => 'Payment not found',
    'SBERBANK_RESULT_ERROR_STATUS_UNKNOWN' => 'Unknown payment status',
    'SBERBANK_RESULT_ERROR_STATUS_0' => 'Order is registered, but not paid.',
    'SBERBANK_RESULT_ERROR_STATUS_3' => 'Authorization canceled',
    'SBERBANK_RESULT_ERROR_STATUS_4' => 'A return operation was performed on the transaction',
    'SBERBANK_RESULT_ERROR_STATUS_5' => 'Authorization through ACS of the issuing bank was initiated',
    'SBERBANK_RESULT_ERROR_STATUS_6' => 'Authorization rejected',
    'SBERBANK_RESULT_ERROR_BAD_AMOUNT' => 'Invalid payment amount!',
    'SBERBANK_RESULT_ERROR_ALREADY_CONFIRM' => 'Payment is already confirmed!',
    'SBERBANK_RESULT_DESCRIPTION' => 'Description of payment',
    'SBERBANK_RESULT_RESULT' => 'Result of payment',
    'SBERBANK_RESULT_INUMBER' => 'Payment number',
    'SBERBANK_RESULT_AMOUNT' => 'Amount of payment',
    'SBERBANK_RESULT_CARDHOLDER' => 'Payer',
    'SBERBANK_RESULT_OK' => 'Request successfully processed, payment verified',
    'SBERBANK_RESULT_HOLD' => 'The request has been successfully processed, the required amount is declared',
    'SBERBANK_PAY_ON_BANK_SITE' => "Go to the bank's website for payment"

);

if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
