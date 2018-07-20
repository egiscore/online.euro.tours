<?php
$_messages = array(
    'PAGE_TITLE' => '�������������� ��������',
    'LOGIN_EDIT' => '��������',
    'PARTPASS_NOT_IN_PARTNER' => '������������ �� ����������� ������� �������.',
    'REQUEST_CHANGES_BTN' => '��������� ���������',
    'PARTNER_REQUEST_CHANGES_TITLE' => '������ �� ��������� ������',
    'REQUEST_CHANGES_SUCCESS' => '������ �� ������� ������ ��������� ������������.',
    'PARTNER_REQUEST_EMPTY_CHANGES' => '��������� �� ����������.',
    'PARTNER_REQUEST_CHANGES_ERROR_405' => '�� �������� ����� ��� �������� �������. ���������� � ������������.',
    'PARTNER_REQUEST_CHANGES_ERROR_500' => '��������� ������ ��� �������� �������. ���������� � ������������.',
    'NOT_ENOUGH_RIGHTS_TO_EDIT' => '������������ ���� ��� ��������������.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
