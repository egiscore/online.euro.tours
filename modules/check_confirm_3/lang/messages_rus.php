<?php

include_once __DIR__ . '/../../visa_status_3/lang/messages_rus.php';

$_messages = array(
    'PAGE_TITLE' => '�������� ������������� ������',
    'CHECK_FS_CAPTION' => '�������� ������',
    'CHECK_LOAD' => '���������',
    'NOT_SET_CLAIM' => '�� ������ ����� ������',
    'NOT_SET_PNUMBER' => '�� ������ ����� ��������',
    'NOT_SET_LASTNAME' => '�� ������� �������',
    'CLAIM_NOT_FOUND' => '������ �� �������',
    'CLAIM_FIELD' => '����� ������',
    'PNUMBER_FIELD' => '����� �������� (��� �����)',
    'FIO_FIELD' => '������� ������� (��� �������� � ��������������)',
    'CH_CONFIRM_INFO_BEFORE' => '������ �� ������ ����� �������� �� %d ���� �� ������ ����',
    'SAVE_CONFIRM' => '���������',
    'TOURIST_PHONE' => '������� �������',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
