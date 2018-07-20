<?php
$_messages = array(
    'PAGE_TITLE' => 'Памятка туристам',
    'BOOKLET_PRINT' => 'Печать',
    'CANNOT_PRINT_DAYS' => 'Печать запрещена, так как до начала тура больше %d дней',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
