<?php
$_messages = array(
    'PAGE_TITLE' => '����������� ���������',
    'BTN_REGISTER' => '������������������',
    'SIGNUP_SUCCESS' => '�� ������� ������������������.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
