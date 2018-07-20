<?php
$_messages = array(
    'PAGE_TITLE' => 'Warranty',
    'WARRANT_NO' => 'No',
    'WARRANT_YES' => 'Yes',
    'WARRANT_PNAME' => 'Full name',
    'WARRANT_PLNAME' => 'Full name in Latin',
    'WARRANT_PSSERIE' => 'Series',
    'WARRANT_PASPORT' => 'Passport',
    'WARRANT_PSNUMBER' => 'Series and number',
    'WARRANT_PSWHEN' => 'Passport issued',
    'WARRANT_PSWHERE' => 'Issued by',
    'WARRANT_PCODEORG' => 'Department code',
    'WARRANT_PBORN' => 'Date of Birth',
    'WARRANT_PADD' => 'Address',
    'WARRANT_PDATE' => 'Warranty time',
    'WARRANT_PHAVE' => 'In stock',
    'WARRANT_PHAVEORIGINAL' => 'original',
    'WARRANT_PHAVECOPY' => 'copy',
    'WARRANT_PRINT' => 'Print',
    'WARRANT_ADD' => 'Add Warranty',
    'POPUP_TITLE' => 'New Warranty',

    'PAYER_INFO' => 'Information about payer',
    'PAYER_FIO' => 'Full name payer:',
    'PAYER_BORN' => 'Date of Birth:',
    'PAYER_ADRESS' => 'Address:',
    'PAYER_PSERIE' => 'Passport series:',
    'PAYER_PNUMBER' => 'Passport number:',
    'PAYER_PGIVENDATE' => 'Date of issue:',
    'PAYER_PGIVENORG' => 'Issued by:',
    'PAYER_PGIVENORG_MENT' => 'Department code:',
    'SAVE_BTN_WARRANT' => 'Save',

    'WARRANT_NO_CONTRACT' => 'Unable to get information about the contract',
    'WARRANT_WRONG_PGIVENDATE' => 'Incorrect date of issue',
    'WARRANT_WRONG_BORN' => 'Incorrect date of birth',
    'WARRANT_NOT_SAVED' => 'Failed to save the warranty.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
