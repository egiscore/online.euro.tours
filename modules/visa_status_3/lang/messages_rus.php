<?php
$_messages = array(
    'PAGE_TITLE' => 'Статус документов на визу',
    'VISA_STATUS_DOC_FULL_TAKEN' => 'Приняты полностью',
    'VISA_STATUS_DOC_PREPARED_TO_EMBASSY' => 'Оформлены для Посольства',
    'VISA_STATUS_DOC_GIVEN_INTO_EMBASSY' => 'Сданы в Посольство',
    'VISA_STATUS_DOC_APPROXIMATE_RECEIVING_DATE' => 'Ориентировочная дата получения из Посольства',
    'VISA_STATUS_DOC_RECEIVED_FROM_EMBASSY' => 'Получены из Посольства',
    'VISA_STATUS_DOC_VISA_RECEIVED' => 'Виза получена',
    'VISA_STATUS_DOC_VISA_EXPIREDATE' => 'Срок действия визы',
    'VISA_STATUS_PASSPORT_RETURNED' => 'Паспорт выдан агентству',
    'VISA_STATUS_VISA_DOCUMENTS_STATUS' => 'Статус документов для визы:',
    'VISA_STATUS_NOTE' => 'Примечание:',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
