<?php
$_messages = array(
    'PAGE_TITLE' => '�������� ��������',
    'RATING_AMOUNT' => '����� � ������, $:',
    'RATING_CREATE_DATETIME' => '���� � ����� ����������:',
    'RATING_DEPTH' => '������� ������� ������, � ����:',
    'RATING_INTERNET_CLAIMS_COUNT' => '���������� ������ �� online:',
    'RATING_INTERNET_CLAIMS_PERCENT' => '������� ������ ����� online:',
    'RATING_NO_ACCESS' => '������ ������',
    'RATING_PAID' => '���������� �����, $:',
    'RATING_PAX' => '���������� ��������:',
    'RATING_RCOUNT' => '���������� �������:',
    'RATING_POSITION' => '������� � ��������:',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
