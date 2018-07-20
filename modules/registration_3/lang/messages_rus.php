<?php
$_messages = array(
    'PAGE_TITLE' => 'Получение логина и пароля',
    'PARTNER_INCORRECT_ADMIN_EMAIL_IN_DB' => 'В нашей базе хранится некорректный адрес электронной почты вашего администратора! Мы не можем отправить на него письмо.',
    'REGISTRATION_FIND_AGENCY' => 'Для получения логина и пароля Вам необходимо найти свое агентство в системе туроператора.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
