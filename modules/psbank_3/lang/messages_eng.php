<?php
$_messages = array(
    'PAGE_TITLE' => 'Invoice for payment in the bank',
    'POPUP_TITLE' => 'Invoice for payment in the bank',
    'NO_BANK_LIST' => 'Undetermined banks for payment. Please refer to the tour operator.',
    'ERROR_GET_DATA' => 'Not transferred the necessary data.',
    'ERROR_ON_SAVE_PAYER' => 'Error saving the payer.',
    'SELECT_PAYER' => 'Select payer',
    'NEW_PAYER' => 'New payer',
    'PAYER_INFO' => 'Information about payer',
    'PAYER_FIO' => 'Full name of the payer:',
    'PAYER_BRON' => 'Date of Birth:',
    'PAYER_ADRESS' => 'Address of the payer:',
    'PAYER_PSERIE' => 'Passport series:',
    'PAYER_PNUMBER' => 'Passport number:',
    'PAYER_PGIVENDATE' => 'Date of issue:',
    'PAYER_PGIVENORG' => 'Issued by:',
    'PAYER_PGIVENORG_MENT' => 'Department code:',
    'PAYMENT_INFO' => 'Payment info',
    'PAYED' => 'Paid:',
    'MAX_AMOUNT' => 'Amount for payment:',
    'BANK_INFO' => 'Information about the bank',
    'KVITOK_BTN' => 'Get invoice',
    'PSBANK_WRONG_PGIVENDATE' => 'Incorrect date of issue',
    'PSBANK_WRONG_BORN' => 'Incorrect date of birth',
    'PAYER_READONLY' => 'Edit information about payer is prohibited.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
