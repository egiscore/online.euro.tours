<?php
$_messages = array(
    'PAGE_TITLE' => 'Print contract',
    'NO_PRINT_PERMISSIONS' => 'You are not authorized to print the contract, contact your travel agent.',
    'AGREEMENT_TEMPLATE_NOT_FOUND' => 'Not found the template contract to %s - %s years for owner %s. Please refer to the tour operator.',
    'AGREEMENT_CHECK_PARTNER_INFO' => 'Check the correctness of the data',
    'AGREEMENT_CHECK_PARTNER_CONTINUE' => 'The data entered is correct, continue.',
    'AGREEMENT_CONTRACTS_DOCUMENT_INC' => 'Not passed a required parameter',
    'AGREEMENT_E_DOC' => 'Documents',
    'AGREEMENT_NUMBER' => 'Agreement number',
    'AGREEMENT_OWNER' => 'Owner',
    'AGREEMENT_DESCRIPTION' => 'Description',
    'AGREEMENT_PERIOD' => 'Validity',
    'AGREEMENT_TYPE' => 'Type',
    'AGREEMENT_IN_STOCK' => 'In stock',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
