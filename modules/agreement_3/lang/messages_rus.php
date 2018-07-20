<?php
$_messages = array(
    'PAGE_TITLE' => 'Печать договора',
    'NO_PRINT_PERMISSIONS' => 'У вас нет прав для печати договора, обратитесь к туроператору.',
    'AGREEMENT_TEMPLATE_NOT_FOUND' => 'Не найден шаблон договора на %s - %s гг для владельца %s. Обратитесь к туроператору.',
    'AGREEMENT_CHECK_PARTNER_INFO' => 'Проверьте правильность заполнения данных',
    'AGREEMENT_CHECK_PARTNER_CONTINUE' => 'Данные заполнены верно, продолжить.',
    'AGREEMENT_CONTRACTS_DOCUMENT_INC' => 'Не передан обязательный параметр',
    'AGREEMENT_E_DOC' => 'Документы',
    'AGREEMENT_NUMBER' => 'Номер договора',
    'AGREEMENT_OWNER' => 'Владелец',
    'AGREEMENT_DESCRIPTION' => 'Описание',
    'AGREEMENT_PERIOD' => 'Период действия',
    'AGREEMENT_TYPE' => 'Тип договора',
    'AGREEMENT_IN_STOCK' => 'В наличии',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
