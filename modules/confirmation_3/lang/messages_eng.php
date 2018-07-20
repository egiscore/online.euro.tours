<?php
$_messages = array(
    'PAGE_TITLE' => 'Confirmation',
    'CONFIRMATION_PRINT' => 'Print',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
