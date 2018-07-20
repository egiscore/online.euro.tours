<?php
$_messages = array(
    'PAGE_TITLE' => 'Регистрация агентства',
    'BTN_REGISTER' => 'Зарегистрироваться',
    'SIGNUP_SUCCESS' => 'Вы успешно зарегистрировались.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
