<?php
$_messages = array(
    'PAGE_TITLE' => '��������� �����',
    'PRINT_DISABLED' => '������ ���������, ��� ��� �� ������ ���� ������ %d ����',
    'POPUP_TITLE' => '������� ��������� �������',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
