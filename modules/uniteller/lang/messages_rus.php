<?php
$_messages = array(
    'UNITELLER_POPUP_TITLE' => '���������� ������� � Uniteller',
    'UNITELLER_PARAMS_NOT_SETS' => '��������� ������� Uniteller �� ������!',
    'UNITELLER_PAID' => '��������:',
    'UNITELLER_INPUT_AMOUNT' => '����� ��� ������',
    'UNITELLER_SUBMIT' => '��������',
    'UNITELLER_EMPTY_AMOUNT' => '������� ����� ��� ������!',
    'UNITELLER_OVER_AMOUNT' => '�� ������ �������� �� ����� ',
    'UNITELLER_PAYMENT_INFO' => '���������� � �������',
    'UNITELLER_RESULT_TITLE' => '��������� ������� � Uniteller',
    'UNITELLER_RESULT_NO' => '������ �� ���� ������������',
    'UNITELLER_RESULT_OK' => '������ �������� �������',
);

if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
