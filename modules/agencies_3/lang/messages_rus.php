<?php
$_messages = array(
    'AGENCIES_SEARCH_LABEL' => '������',
    'AGENCIES_ENTER_YOUR_QUERY' => '��� / �������� / ��� ������������ / �������',
    'AGENCIES_SEARCH' => '�����',
    'PAGE_TITLE' => '�������� ��������',
    'AGENCIES_NAME' => '��������',
    'AGENCIES_TITLE' => '����������� ������������',
    'AGENCIES_TOWN_FILTER' => '�����',
    'AGENCIES_METROSTATION_FILTER' => '�����',
    'AGENCIES_TOWN' => '�����',
    'AGENCIES_ADDRESS' => '�����',
    'AGENCIES_INN' => '���',
    'AGENCIES_OGRN' => '����',
    'AGENCIES_KPP' => '���',
    'AGENCIES_DATE_REGISTER' => '���� ��������� �����������',
    'AGENCIES_DATE_CLOSE' => '���� ����������� ������������',
    'AGENCIES_STATUS' => '������ (���������)',
    'AGENCIES_STATUS_YES' => '�����������',
    'AGENCIES_STATUS_NO' => '�� �����������',
    'AGENCIES_OWNER' => '������������',
    'AGENCIES_ACTIVITIE' => '�������� ��� ������������',
    'AGENCIES_OKVED' => '�����',
    'AGENCIES_DOG' => '����������� �������',
    'AGENCIES_AVAILABLE' => '� �������',
    'AGENCIES_AVAILABLE_YES' => '��',
    'AGENCIES_AVAILABLE_NO' => '���',
    'AGENCIES_LAST_ORDER' => '���� ��������� ������',
    'AGENCIES_DATE' => '���������� ���������� ��',
    'AGENCIES_RATING' => '�������',

    'AGENCIES_MORE' => '���������',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
