<?php

include_once __DIR__ . '/../../visa_status_3/lang/messages_rus.php';

$_messages = array(
    'PAGE_TITLE' => 'Проверка подтверждения заявки',
    'CHECK_FS_CAPTION' => 'Проверка заявки',
    'CHECK_LOAD' => 'Проверить',
    'NOT_SET_CLAIM' => 'Не указан номер заявки',
    'NOT_SET_PNUMBER' => 'Не указан номер паспорта',
    'NOT_SET_LASTNAME' => 'Не указана фамилия',
    'CLAIM_NOT_FOUND' => 'Заявка не найдена',
    'CLAIM_FIELD' => 'Номер заявки',
    'PNUMBER_FIELD' => 'Номер паспорта (без серии)',
    'FIO_FIELD' => 'фамилия туриста (как написано в загранпаспорте)',
    'CH_CONFIRM_INFO_BEFORE' => 'Данные по заявке будут доступны за %d дней до начала тура',
    'SAVE_CONFIRM' => 'Сохранить',
    'TOURIST_PHONE' => 'Телефон туриста',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
