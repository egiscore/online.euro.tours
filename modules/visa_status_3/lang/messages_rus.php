<?php
$_messages = array(
    'PAGE_TITLE' => '������ ���������� �� ����',
    'VISA_STATUS_DOC_FULL_TAKEN' => '������� ���������',
    'VISA_STATUS_DOC_PREPARED_TO_EMBASSY' => '��������� ��� ����������',
    'VISA_STATUS_DOC_GIVEN_INTO_EMBASSY' => '����� � ����������',
    'VISA_STATUS_DOC_APPROXIMATE_RECEIVING_DATE' => '��������������� ���� ��������� �� ����������',
    'VISA_STATUS_DOC_RECEIVED_FROM_EMBASSY' => '�������� �� ����������',
    'VISA_STATUS_DOC_VISA_RECEIVED' => '���� ��������',
    'VISA_STATUS_DOC_VISA_EXPIREDATE' => '���� �������� ����',
    'VISA_STATUS_PASSPORT_RETURNED' => '������� ����� ���������',
    'VISA_STATUS_VISA_DOCUMENTS_STATUS' => '������ ���������� ��� ����:',
    'VISA_STATUS_NOTE' => '����������:',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
