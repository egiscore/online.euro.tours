<?php
$_messages = array(
    'MSG_TOTAL_COUNT' => '�����',
    'MSG_UNREAD_COUNT' => '�������������',
    'MSG_UNREAD_COUNT_TO' => '������������� �������������',
    'MSG_LAST_MESSAGE' => '���������',
    'MSG_TOPICS' => '���������',
    'MSG_ANSWERS' => '�����',
    'MESSAGES' => '���������',
    'MESSAGES_CLAIM' => '��������� � ������',
    'MESSAGES_UNREAD' => '�������������',
    'MESSAGES_UNREAD_EMPTY' => '��� ������������� ���������',
    'MESSAGES_RECENT' => '��� ���������',
    'MSG_REPLY' => '��������',
    'MSG_SEND_BUTTON' => '���������',
    'RELOAD_PAGE' => '��� ���������� ������ ��������� �������� ��������.',
    'MSG_CLAIM' => '������',
    'MSG_CREATE' => '����� ���������',
    'MSG_TEXT' => '���������',
    'MSG_SUBJECT' => '���� ���������',
    'MSG_READ_MORE' => '������',
    'MSG_ERROR_CLAIM_EMPTY' => '�� ��������� ���� "����� ������".',
    'MSG_ERROR_SUBJECT_EMPTY' => '�� ��������� ���� "���� ���������".',
    'MSG_ERROR_TEXT_EMPTY' => '������ ��������� �� ����� ���� ����������.',
    'MSG_ERROR_SUBJECT_TOO_LONG' => '������������ ����� ���� - %d ��������.',
    'MSG_ERROR_CLAIM' => '�� �� ������ ��������� ��������� � ������ "%s", ��������� �����.',
    'MSG_REPLY_DENY' => '������� ���������.',
    'MSG_CREATE_DENY' => '������� ���������.',
    'MSG_ERROR_MESSAGETYPE_EMPTY' => '�������� ���������� ���������',
);
$_messages = array_map(
    function($ansi) {
        return mb_convert_encoding($ansi, 'utf-8', 'cp1251');
    },
    $_messages
);

$_messages['PAGE_TITLE'] = '���������';

if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
