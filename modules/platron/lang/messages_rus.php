<?php
$_messages = array(
    'PLATRON_POPUP_TITLE' => '���������� ������� � Platron',
    'PLATRON_PAYMENT_INFO' => '���������� � �������',
    'PLATRON_PAID' => '��������:',
    'PLATRON_INPUT_AMOUNT' => '����� ��� ������',
    'PLATRON_SUBMIT' => '��������',
    'PLATRON_PARAMS_NOT_SETS' => '��������� ������� Platron �� ������!',
    'PLATRON_EMPTY_AMOUNT' => '������� ����� ��� ������!',
    'PLATRON_OVER_AMOUNT' => '�� ������ �������� �� ����� '
);

if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
