<?php
$_messages = array(
    'PAGE_TITLE' => '��������� ��� ������ � ��������� �����',
    'POPUP_TITLE' => '��������� ��� ������ � ��������� �����',
    'NO_BANK_LIST' => '�� ���������� ����� ��� ������. ���������� � ������������.',
    'ERROR_GET_DATA' => '�� �������� ����������� ������.',
    'ERROR_ON_SAVE_PAYER' => '������ ��� ���������� �����������.',
    'SELECT_PAYER' => '�������� �����������',
    'NEW_PAYER' => '����� ����������',
    'PAYER_INFO' => '���������� � �����������',
    'PAYER_FIO' => '��� �����������:',
    'PAYER_BRON' => '���� ��������:',
    'PAYER_ADRESS' => '����� �����������:',
    'PAYER_PSERIE' => '����� ��������:',
    'PAYER_PNUMBER' => '����� ��������:',
    'PAYER_PGIVENDATE' => '���� ������:',
    'PAYER_PGIVENORG' => '��� �����:',
    'PAYER_PGIVENORG_MENT' => '��� �������������:',
    'PAYMENT_INFO' => '���������� � �������',
    'PAYED' => '��������:',
    'MAX_AMOUNT' => '����� ��� ������:',
    'BANK_INFO' => '���������� � �����',
    'KVITOK_BTN' => '�������� ���������',
    'PSBANK_WRONG_PGIVENDATE' => '�������� ���� ������ ��������',
    'PSBANK_WRONG_BORN' => '�������� ���� ��������',
    'PAYER_READONLY' => '�������������� ���������� � ����������� ���������.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
