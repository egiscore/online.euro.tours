<?php
$_messages = array(
    'PAGE_TITLE' => '������ ��������',
    'NO_PRINT_PERMISSIONS' => '� ��� ��� ���� ��� ������ ��������, ���������� � ������������.',
    'AGREEMENT_TEMPLATE_NOT_FOUND' => '�� ������ ������ �������� �� %s - %s �� ��� ��������� %s. ���������� � ������������.',
    'AGREEMENT_CHECK_PARTNER_INFO' => '��������� ������������ ���������� ������',
    'AGREEMENT_CHECK_PARTNER_CONTINUE' => '������ ��������� �����, ����������.',
    'AGREEMENT_CONTRACTS_DOCUMENT_INC' => '�� ������� ������������ ��������',
    'AGREEMENT_E_DOC' => '���������',
    'AGREEMENT_NUMBER' => '����� ��������',
    'AGREEMENT_OWNER' => '��������',
    'AGREEMENT_DESCRIPTION' => '��������',
    'AGREEMENT_PERIOD' => '������ ��������',
    'AGREEMENT_TYPE' => '��� ��������',
    'AGREEMENT_IN_STOCK' => '� �������',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
