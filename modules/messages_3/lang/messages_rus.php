<?php
$_messages = array(
    'MSG_TOTAL_COUNT' => 'Всего',
    'MSG_UNREAD_COUNT' => 'Непрочитанных',
    'MSG_UNREAD_COUNT_TO' => 'Непрочитанных туроператором',
    'MSG_LAST_MESSAGE' => 'Последний',
    'MSG_TOPICS' => 'Сообщение',
    'MSG_ANSWERS' => 'Ответ',
    'MESSAGES' => 'Сообщения',
    'MESSAGES_CLAIM' => 'Сообщения к заявке',
    'MESSAGES_UNREAD' => 'Непрочитанные',
    'MESSAGES_UNREAD_EMPTY' => 'Нет непрочитанных сообщений',
    'MESSAGES_RECENT' => 'Все сообщения',
    'MSG_REPLY' => 'Ответить',
    'MSG_SEND_BUTTON' => 'Отправить',
    'RELOAD_PAGE' => 'Для корректной работы требуется обновить страницу.',
    'MSG_CLAIM' => 'Заявка',
    'MSG_CREATE' => 'Новое сообщение',
    'MSG_TEXT' => 'Сообщение',
    'MSG_SUBJECT' => 'Тема сообщения',
    'MSG_READ_MORE' => 'читать',
    'MSG_ERROR_CLAIM_EMPTY' => 'Не заполнено поле "Номер заявки".',
    'MSG_ERROR_SUBJECT_EMPTY' => 'Не заполнено поле "Тема сообщения".',
    'MSG_ERROR_TEXT_EMPTY' => 'Пустое сообщение не может быть отправлено.',
    'MSG_ERROR_SUBJECT_TOO_LONG' => 'Максимальная длина темы - %d символов.',
    'MSG_ERROR_CLAIM' => 'Вы не можете оставлять сообщения к заявке "%s", проверьте номер.',
    'MSG_REPLY_DENY' => 'Функция отключена.',
    'MSG_CREATE_DENY' => 'Функция отключена.',
    'MSG_ERROR_MESSAGETYPE_EMPTY' => 'Выберите назначение сообщения',
);
$_messages = array_map(
    function($ansi) {
        return mb_convert_encoding($ansi, 'utf-8', 'cp1251');
    },
    $_messages
);

$_messages['PAGE_TITLE'] = 'Сообщения';

if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
