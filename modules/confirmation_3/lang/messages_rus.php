<?php
$_messages = array(
    'PAGE_TITLE' => '������ �������������',
    'CONFIRMATION_PRINT' => '��������',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
