<?php
$_messages = array(
    'PAGE_TITLE' => '��������� �����������',
    'AC_CLAIM_NUMBER' => '������ �',
    'AC_TOUR_ROUTE' => '�������:',
    'AC_CLASS' => '�����:',
    'AC_PEOPLE_NAME' => '��� ��-������',
    'AC_PEOPLE_LNAME' => '��� ��-��������',
    'AC_NO_PEOPLES' => '�������� �� �������',
    'AC_PRINT_BTN' => '�������',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
