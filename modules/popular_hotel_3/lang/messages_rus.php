<?php
$_messages = array(
    'PAGE_TITLE' => '���������� �����',
    'HOTEL_STAR' => '���������',
    'HOTEL_NAME' => '���������',
    'HOTEL_ROOM' => '�����',
    'HOTEL_HTPLACE' => '����������',
    'HOTEL_MEAL' => '�������',
    'HOTEL_NIGHTS' => '�����',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
