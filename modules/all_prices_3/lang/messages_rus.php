<?php
include_once __DIR__ . '/../../search_tour_3/lang/messages_rus.php';

$_messages = array(
    'CHECKIN' => '���� ������',
    'CURRENCY' => '������',
    'PAGE_TITLE' => '����������� �����-����',
    'TOUR_SEARCH_REFRESH' => '��������',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
