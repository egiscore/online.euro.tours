<?php
$_messages = array(
    'ARRIVAL' => '�����������',
    'CODE' => '���',
    'DATETIME' => '���� ������',
    'DEPARTURE' => '��������',
    'FLY_DATE' => '���� �����������',
    'FREIGHT' => '���������',
    'NOTE' => '����������',
    'PAGE_TITLE' => '������ ������ ����������',
    'TOUR' => '���',
    'SHEDULE_DOC_TOWNFROM' => '�����',
    'SHEDULE_DOC_STATE' => '������',
    'SHEDULE_DOC_OFFICE' => '���� ������ ����������',
    'SHEDULE_DOC_CHECKIN' => '���� ������',
    'REFRESH' => '��������',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
