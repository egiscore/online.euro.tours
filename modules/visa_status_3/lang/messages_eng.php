<?php
$_messages = array(
    'PAGE_TITLE' => 'The status of visa applications',
    'VISA_STATUS_DOC_FULL_TAKEN' => 'full taken',
    'VISA_STATUS_DOC_PREPARED_TO_EMBASSY' => 'prepared to Embassy',
    'VISA_STATUS_DOC_GIVEN_INTO_EMBASSY' => 'given into the Embassy',
    'VISA_STATUS_DOC_APPROXIMATE_RECEIVING_DATE' => 'Approximate receiving date',
    'VISA_STATUS_DOC_RECEIVED_FROM_EMBASSY' => 'Received from the Embassy',
    'VISA_STATUS_DOC_VISA_RECEIVED' => 'Visa received',
    'VISA_STATUS_DOC_VISA_EXPIREDATE' => 'Visa expired date',
    'VISA_STATUS_PASSPORT_RETURNED' => 'Passport returned to agency',
    'VISA_STATUS_VISA_DOCUMENTS_STATUS' => 'Visa documents status:',
    'VISA_STATUS_NOTE' => 'Note:',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
