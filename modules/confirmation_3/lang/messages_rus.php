<?php
$_messages = array(
    'PAGE_TITLE' => 'Печать подтверждения',
    'CONFIRMATION_PRINT' => 'Печатать',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
