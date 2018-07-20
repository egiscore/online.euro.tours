<?php
$_messages = array(
    'PAGE_TITLE' => 'Tourist memo',
    'BOOKLET_PRINT' => 'Print',
    'CANNOT_PRINT_DAYS' => 'Printing is prohibited, so as to start the tour than %d days',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
