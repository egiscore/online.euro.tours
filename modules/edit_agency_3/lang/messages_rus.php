<?php
$_messages = array(
    'PAGE_TITLE' => 'Редактирование партнера',
    'LOGIN_EDIT' => 'Изменить',
    'PARTPASS_NOT_IN_PARTNER' => 'Пользователь не принадлежит данному партнёру.',
    'REQUEST_CHANGES_BTN' => 'Запросить изменения',
    'PARTNER_REQUEST_CHANGES_TITLE' => 'Запрос на изменение данных',
    'REQUEST_CHANGES_SUCCESS' => 'Запрос на измение данных отправлен туроператору.',
    'PARTNER_REQUEST_EMPTY_CHANGES' => 'Изменений не обнаружено.',
    'PARTNER_REQUEST_CHANGES_ERROR_405' => 'Не настроен адрес для отправки запроса. Обратитесь к туроператору.',
    'PARTNER_REQUEST_CHANGES_ERROR_500' => 'Произошла ошибка при отправке запроса. Обратитесь к туроператору.',
    'NOT_ENOUGH_RIGHTS_TO_EDIT' => 'Недостаточно прав для редактирования.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
