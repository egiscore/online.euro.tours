<?php
$_messages = array(
    'H_STOPSALE_HOTEL' => '���������:',
    'H_STOPSALE_HOTEL_RES' => '���������',
    'H_STOPSALE_HTPLACE' => '����������',
    'H_STOPSALE_MEAL' => '�������',
    'H_STOPSALE_NOTE' => '����������',
    'H_STOPSALE_REFRESH' => '��������',
    'H_STOPSALE_ROOM' => '�����',
    'H_STOPSALE_STATE' => '������:',
    'H_STOPSALE_STOP' => '��������� ������',
    'H_STOPSALE_TOWN' => '�����:',
    'H_STOPSALE_TYPE' => '��� ���������',
    'H_STOPSALE_TOWN_RES' => '�����',
    'H_STOPSALE_ZAEZD' => '�� �����',
    'H_STOPSALE_NIGHTS' => '�� ����� ( %d ����� )',
    'H_STOPSALE_SPO' => '��� ��� %s',
    'H_STOPSALE_PTYPE' => '��� ��������� %s',
    'PAGE_TITLE' => '��������� ������ � ����������',
    'H_STOPSALE_TOWNFROM' => '����� �����������:',
    'H_STOPSALE_INCOMING_PARTNER' => '����������� �������',
    'H_STOPSALE_ALL' => '���',
    'H_STOPSALE_PERIOD_RDATE' => '������ ������ ������:',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
