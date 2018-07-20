<?php
$_messages = array(
    'PAGE_TITLE' => 'Registration agency',
    'BTN_REGISTER' => 'Register',
    'SIGNUP_SUCCESS' => 'You have registered successfully.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
