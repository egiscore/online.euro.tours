<?php
$_messages = array(
    'PAGE_TITLE' => '������ �����������',
    'POPUP_TITLE' => '������ ����������� ��� ������',
    'CAN_NOT_LOAD_CLAIM_INFO' => '������ ��� �������� ���������� �� ������. ���������� � ������������.',
    'TOUR_ALREADY_BEGIN' => '������ ���������, ��� ��� ��� ��� �������',
    'CANNOT_PRINT_DAYS' => '������ ���������, ��� ��� �� ������ ���� ������ %d ����.',
    'MORE_COMMON' => '� ���������� ����������� ��������� ��������. ���������� � ������������.',
    'TICKET_DITRIBUTED' => '������ ��� ������. ���������� � ������������.',
    'NO_TICKET_NUMBER' => '�� ������ ����� ������. ���������� � ������������.',
    'CAN_NOT_LOAD_RESULT_PEOPLEINFO' => '��� ����������� ��������� ���������� �� �������',
    'TRANSPORT' => '���������',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
