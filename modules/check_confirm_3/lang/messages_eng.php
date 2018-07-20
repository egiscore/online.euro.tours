<?php

include_once __DIR__ . '/../../visa_status_3/lang/messages_eng.php';

$_messages = array(
    'PAGE_TITLE' => 'Check claim confirmation',
    'CHECK_FS_CAPTION' => 'Check claim',
    'CHECK_LOAD' => 'Check',
    'NOT_SET_CLAIM' => 'Not specified claim number',
    'NOT_SET_PNUMBER' => 'Not specified passport number',
    'NOT_SET_LASTNAME' => 'Not specified surname',
    'CLAIM_NOT_FOUND' => 'Claim not found',
    'CLAIM_FIELD' => 'Claim number',
    'PNUMBER_FIELD' => 'Passport number (w/o series)',
    'FIO_FIELD' => 'surname tourist (as written in passport)',
    'CH_CONFIRM_INFO_BEFORE' => 'The data on the claim will be available for %d days before the tour',
    'SAVE_CONFIRM' => 'Save',
    'TOURIST_PHONE' => "Tourist's phone",
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
