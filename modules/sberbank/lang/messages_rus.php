<?php
$_messages = array(
    'SBERBANK_RESULT_TITLE' => '��������� ������',
    'SBERBANK_POPUP_TITLE' => '���������� ������� � ���������',
    'SBERBANK_PAYMENT_INFO' => '���������� � �������',
    'SBERBANK_PAID' => '��������:',
    'SBERBANK_INPUT_AMOUNT' => '����� ��� ������',
    'SBERBANK_SUBMIT' => '��������',
    'SBERBANK_PARAMS_NOT_SETS' => '��������� ������� ��������� �� ������!',
    'SBERBANK_EMPTY_AMOUNT' => '������� ����� ��� ������!',
    'SBERBANK_RESULT_ERROR_INUMBER' => '������ ��� ��������� ������� ������� (%s). ���������� � ������������!',
    'SBERBANK_RESULT_ERROR' => '������ ��� ��������� ������� �������. ���������� � ������������!',
    'SBERBANK_RESULT_ERROR_INVALID_INUMBER' => '�������� ����� �����. ���������� � ������������!',
    'SBERBANK_RESULT_ERROR_ORDER_NOT_FOUND' => '������ �� ������!',
    'SBERBANK_RESULT_ERROR_STATUS_UNKNOWN' => '������ ������� �� ��������',
    'SBERBANK_RESULT_ERROR_STATUS_0' => '����� ���������������, �� �� �������',
    'SBERBANK_RESULT_ERROR_STATUS_3' => '����������� ��������',
    'SBERBANK_RESULT_ERROR_STATUS_4' => '�� ���������� ���� ��������� �������� ��������',
    'SBERBANK_RESULT_ERROR_STATUS_5' => '������������ ����������� ����� ACS �����-��������',
    'SBERBANK_RESULT_ERROR_STATUS_6' => '����������� ���������',
    'SBERBANK_RESULT_ERROR_BAD_AMOUNT' => '�������� ����� �������!',
    'SBERBANK_RESULT_ERROR_ALREADY_CONFIRM' => '������ ��� �����������!',
    'SBERBANK_RESULT_DESCRIPTION' => '�������� �������',
    'SBERBANK_RESULT_RESULT' => '��������� �������',
    'SBERBANK_RESULT_INUMBER' => '����� �������',
    'SBERBANK_RESULT_AMOUNT' => '����� �������',
    'SBERBANK_RESULT_CARDHOLDER' => '����������',
    'SBERBANK_RESULT_OK' => '������ ������� ���������, ������ �����������',
    'SBERBANK_RESULT_HOLD' => '������ ������� ���������, ����������� ����� �������������',
    'SBERBANK_PAY_ON_BANK_SITE' => '������� �� ���� ����� ��� ������'

);

if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
