<?php

include_once __DIR__ . '/../../search_tour_3/lang/messages_rus.php';

$_messages = array(
    'FS_ADULTS' => '��������',
    'FS_ANY_HOTEL' => '�����',
    'FS_CHECKIN' => '������ ����',
    'FS_CHILDS' => '�����',
    'FS_HOTELINC' => '���������',
    'FS_LOAD' => '������',
    'FS_NIGHTS' => '�����',
    'FS_NIGHTS_MIN' => '��',
    'FS_NIGHTS_MAX' => '��',
    'FS_PRICE' => '���� ��',
    'FS_STATE' => '������',
    'FS_TOURINC' => '���',
    'FS_TOWNFROM' => '����� ��',
    'FS_CURRENCY' => '������',
    'FS_FULL_PACKET' => '������ �����',
    'FS_HOTEL_ONLY' => '������ ����������',
    'FS_AVIATICKET_ONLY' => '������ ������',
    'FS_CATEGORY' => '���������',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
