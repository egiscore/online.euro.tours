<?php
$_messages = array(
    'CHECK_PASSPORT' => '�������� ����� �������� ���������������',
    'CHECK_PASSPORT_CITY_DEPARTURE' => '����� ������',
    'CHECK_PASSPORT_COUNTRY_DESTINATION' => '������ ����������',
    'CHECK_PASSPORT_CITIZENSHIP' => '�����������',
    'CHECK_PASSPORT_PLACE_BIRTH' => '����� ��������',
    'CHECK_PASSPORT_DEPARTURE_DATE' => '���� ������',
    'CHECK_PASSPORT_DURATION' => '����������������� ���� (�����)',
    'CHECK_PASSPORT_CHECK' => '���������',
    'CHECK_PASSPORT_VALID' => '��� ������� �������� ��� ���������� �����������.',
    'CHECK_PASSPORT_VALID_NOTE' => '��� ������� �������� ��� ���������� �������, �� ��������� ������� ����������� ������� �����������.',
    'CHECK_PASSPORT_INVALID' => '��� ������� �� �������� ��� ���������� �������, ������ ������������ �������.',
    'CHECK_PASSPORT_VALID_DATE' => '���� �������� ��������',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
