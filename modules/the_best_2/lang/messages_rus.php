<?php
$_messages = array(
// begin [the_best]
'PAGE_TITLE' => '������ �����������',
'BEST_REFRESH' => '��������',
'REFRESH' => '��������',
'THE_BEST_CHECKIN' => '�����',
'THE_BEST_HOTEL' => '���������',
'THE_BEST_HTPLACE' => '����������',
'THE_BEST_NIGHTS' => '�����',
'THE_BEST_PRICE' => '����',
'THE_BEST_ROOM' => '�����',
'THE_BEST_SPO' => '���',
'THE_BEST_STAR' => '���������',
'THE_BEST_STATE_TO' => '������',
'THE_BEST_TOUR' => '���',
'THE_BEST_TOWN' => '����� ������',
'THE_BEST_TOWNTO' => '������',
'THE_BEST_LIKE' => '�������',
'THE_BEST_MEAL' => '�������',
// end [the_best]
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
