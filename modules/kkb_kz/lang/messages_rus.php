<?php
$_messages = array(
    'KKB_KZ_POPUP_TITLE' => '���������� ������� � ���������������',
    'KKB_KZ_PARAMS_NOT_SETS' => '��������� ������� ��������������� �� ������!',
    'KKB_KZ_PAID' => '��������:',
    'KKB_KZ_INPUT_AMOUNT' => '����� ��� ������',
    'KKB_KZ_INPUT_EMAIL' => 'E-mail',
    'KKB_KZ_SUBMIT' => '��������',
    'KKB_KZ_EMPTY_AMOUNT' => '������� ����� ��� ������!',
    'KKB_KZ_OVER_AMOUNT' => '�� ������ �������� �� ����� ',
    'KKB_KZ_PAYMENT_INFO' => '���������� � �������',
    'KKB_KZ_RESULT_TITLE' => '��������� ������� � ���������������',
    'KKB_KZ_RESULT_FAIL' => '������ �� ���� ������������',
    'KKB_KZ_RESULT_OK' => '������ �������� �������',
);

if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
