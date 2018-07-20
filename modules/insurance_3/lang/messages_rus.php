<?php
$_messages = array(
    'PAGE_TITLE' => 'Страховой полис',
    'PRINT_DISABLED' => 'Печать запрещена, так как до начала тура меньше %d дней',
    'POPUP_TITLE' => 'Выписка страховых полисов',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
