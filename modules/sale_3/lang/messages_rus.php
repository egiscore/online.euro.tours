<?php
$_messages = array(
    'SALE_REFRESH' => '�����',
    'NO_DATA' => '��� ������. �������� ��������� ������.',
    'PAGE_TITLE' => '��� ������ ���?',
    'SALE_TOWN' => '�����',
    'SALE_METRO' => '������� �����',
    'SALE_CONTACTS' => '��������',
    'SALE_BOSS' => '��������',
    'SALE_LICENSE' => '��������',
    'SALE_ICQ_CONCULTANT' => '�����������',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
