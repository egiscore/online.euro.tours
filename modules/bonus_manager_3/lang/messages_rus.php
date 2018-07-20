<?php
$_messages = array(
    'PAGE_TITLE' => '������ ����������',
    'BONUS_MANAGER_CURRENCY' => '������',
    'BONUS_MANAGER_ADD' => '���������',
    'BONUS_MANAGER_DELETE' => '�������������',
    'BONUS_MANAGER_TOTAL' => '��������',
    'BONUS_MANAGER_DATE' => '����',
    'BONUS_MANAGER_TYPE' => '���',
    'BONUS_MANAGER_CLAIM' => '������',
    'BONUS_MANAGER_BONUS' => '�����',
    'BONUS_MANAGER_SHOW_DETAIL' => '�������� ������',
    'BONUS_MANAGER_HIDE_DETAIL' => '������ ������',
    'BONUS_MANAGER_IN' => '������',
    'BONUS_MANAGER_OUT' => '������',
    'BONUS_MANAGER_UNKNOWN' => '???',
    'BONUS_MANAGER_CLAIM_COST' => '�������� � ������',
    'BONUS_MANAGER_SUM_AVAILABLE' => '����������� �����',
    'BONUS_MANAGER_USE' => '������',
    'BONUS_MANAGER_USE_BTN' => '������������',
    'BONUS_MANAGER_CONFIRM' => '�� ������������� ������ ������������ �������� ����� � ���� ������ ������?',
    'BONUS_MANAGER_PAY_FAILED' => '��������� ������ � �������� �������� �������. ���������� � ������������.',
    'BONUS_MANAGER_PAY_SUCCESS' => '������ ������� �������.',
    'BONUS_MANAGER_BONUS_TOTAL_AVAILABLE' => '��������',
    'BONUS_MANAGER_BONUS_STATUS' => '������',
    'BONUS_MANAGER_BONUS_AVAILABLE' => '��������',
    'BONUS_MANAGER_BONUS_UNAVAILABLE' => '����������',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
