<?php
$_messages = array(
    'PAGE_TITLE' => 'Insurance',
    'PRINT_DISABLED' => 'Print prohibited since before the tour is less than %d in days',
    'POPUP_TITLE' => 'Print of the insurance policy',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
