<?php
$_messages = array(
    'PAGE_TITLE' => '����� ����',
    'NO_DATA' => '������ �� �������. �������� ��������� ������',
    'NO_DOPDATA' => '�������������� ������ �� �������.',
    'SERVER_NOT_AVAILABLE' => '����� �� ���������� ����������� �������� ����������.',
    'PROMOTIONS' => '�����',
    'FILTERS' => '�������',
    'TOUR_SEARCH_PRICE_STATS' => '�������� ����, ������� ���� �� �����',
    'TOUR_SEARCH_RES_YES_PLACE' => '���� �����',
    'TOUR_SEARCH_RES_YESNO_PLACE' => '���� ����',
    'TOUR_SEARCH_RES_NO_PLACE' => '��� ����',
    'TOUR_SEARCH_RES_REQUEST_PLACE' => '����� �� �������',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
