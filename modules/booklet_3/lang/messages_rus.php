<?php
$_messages = array(
    'PAGE_TITLE' => '������� ��������',
    'BOOKLET_PRINT' => '������',
    'CANNOT_PRINT_DAYS' => '������ ���������, ��� ��� �� ������ ���� ������ %d ����',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
