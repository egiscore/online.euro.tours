<?php
$_messages = array(
    'PAGE_TITLE' => '��������� ������ � ������',
    'PARTNER_INCORRECT_ADMIN_EMAIL_IN_DB' => '� ����� ���� �������� ������������ ����� ����������� ����� ������ ��������������! �� �� ����� ��������� �� ���� ������.',
    'REGISTRATION_FIND_AGENCY' => '��� ��������� ������ � ������ ��� ���������� ����� ���� ��������� � ������� ������������.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
