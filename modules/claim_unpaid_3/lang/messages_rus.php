<?php
include dirname(__FILE__) . '/../../check_confirm_3/lang/messages_rus.php';
include dirname(__FILE__) . '/../../cl_refer_3/lang/messages_rus.php';
$_messages = array(
    'PAGE_TITLE' => '������������ ������',
    'CLAIM_UNPAID_CLAIM_NUMBER' => '������',
    'CLAIM_UNPAID_CLAIM_STATUS' => '������',
    'CLAIM_UNPAID_CHECKIN' => '������ ����',
    'CLAIM_UNPAID_COST' => '���������',
    'CLAIM_UNPAID_DEBT' => '����� �����',
    'CLAIM_UNPAID_PARTPAY' => '��������� ������',
    'CLAIM_UNPAID_FULLPAY' => '������ ������',
    'CLAIM_UNPAID_PAY_ACTION' => '��������',
    'CLAIM_UNPAID_ON_DATE' => '��',
    'CLAIM_UNPAID_UNTIL' => '��',
    'CLAIM_UNPAID_PAYMENT_CAPTION' => '������ ������',
    'CLAIM_EARLYCOMISSION' => '���� ��������<br>�� ����� ������������',
    'CLAIM_EARLY' => '�� ������ ������������',
    'CLAIM_COMISSION' => '��������',
    'CLAIM_LAST_MTYPE' => '���<br>���������� �������',
    'CLAIM_NEXT_PDATE' => '����<br>���������� �������',
    'CLAIM_NEXT_PSUM' => '�����<br>���������� �������',
    'CLAIM_PAYMENT' => '������',
    'CLAIM_NEARFUTURE' => '� ��������� �����',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
