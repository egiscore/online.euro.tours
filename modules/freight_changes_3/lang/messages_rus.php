<?php
$_messages = array(
    'FRCHANGES_PUBLIC' => '������������',
    'FRCHANGES_TEXT_1' => '����� �����',
    'FRCHANGES_REFRESH' => '��������',
    'FRCHANGES_TOWNFROM' => '����� ��',
    'FRCHANGES_STATE' => '������',
    'FRCHANGES_TOURNAME' => '���',
    'FRCHANGES_DATE' => '���� ������',
    'PAGE_TITLE' => '��������� � ���������� ������',
    'FRCHANGES_ROUTE' => '�������',
    'FRCHANGES_TEXT_2' => '�� ��������',
    'FRCHANGES_TEXT_3' => '������',
    'FRCHANGES_TEXT_4' => '����� �����������',
    'FRCHANGES_TEXT_5' => '������',
    'FRCHANGES_TEXT_6' => '�',
    'FRCHANGES_TEXT_7' => '��',
    'FRCHANGES_TEXT_8' => '����� �� ��������',
    'FRCHANGES_TEXT_9' => '������ �����',
    'FRCHANGES_TEXT_10' => '����� ����������� ������',
    'FRCHANGES_TEXT_11' => '������������',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
