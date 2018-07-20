<?php
$_messages = array(
    'TICKETS_ADULTS' => '��������',
    'TICKETS_BLOCK_COUNT' => '�������',
    'TICKETS_CHECKIN' => '����',
    'TICKETS_CHECKIN_FROM' => '�������� ����',
    'TICKETS_CHECKIN_TO' => '������� ����',
    'TICKETS_CHECKOUT' => '�������',
    'TICKETS_CHILDS' => '�����',
    'TICKETS_CHILD_AGES' => '�������',
    'TICKETS_CLASS' => '�����',
    'TICKETS_CURRENCY' => '������',
    'TICKETS_INFANT' => '��������',
    'TICKETS_FREIGHT' => '����',
    'TICKETS_PORTFROM' => '���� ������',
    'TICKETS_PORTTO' => '���� �������',
    'TICKETS_PRICE' => '����',
    'TICKETS_REFRESH' => '������',
    'TICKETS_TIME' => '�����',
    'TICKETS_TOWNFROM' => '����� ��',
    'TICKETS_TOWNTO' => '�',
    'TICKETS_AIRLINE' => '������������',
    'TICKETS_AIRLINE_ANY' => '�����',
    'TICKETS_TOO_MANY_ROWS' => '���������� �� ��� ������. �������� ��������� ������',
    'TICKETS_YESPLACES' => '���� �����',
    'NO_DATA' => '������ �� �������. �������� ��������� ������',
    'PAGE_TITLE' => '������� �����������',
    'STAT_NOT_FOUND_FREIGHTS' => '������ �� �������',
    'STAT_BRON_LINK' => '�����������',
    'TICKETS_ONEWAY' => '� ���� �������',
    'TICKETS_ROUNDTRIP' => '���� � �������',
    'TICKETS_DEPARTURE' => '����� ����',
    'TICKETS_ARRIVAL' => '����� �������',
    'TICKETS_CHECKOUT_EMPTY' => '�� ������� ���� ������ �������',
    'TICKETS_CHILDS_AGE' => '������� �����',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
