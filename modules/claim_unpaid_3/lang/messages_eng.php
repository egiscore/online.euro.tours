<?php
include dirname(__FILE__) . '/../../check_confirm_3/lang/messages_eng.php';
include dirname(__FILE__) . '/../../cl_refer_3/lang/messages_eng.php';
$_messages = array(
    'PAGE_TITLE' => 'Unpaid reservations',
    'CLAIM_UNPAID_CLAIM_NUMBER' => 'Reservation',
    'CLAIM_UNPAID_CLAIM_STATUS' => 'Status',
    'CLAIM_UNPAID_CHECKIN' => 'Tour starts',
    'CLAIM_UNPAID_COST' => 'Cost',
    'CLAIM_UNPAID_DEBT' => 'Amount due',
    'CLAIM_UNPAID_PARTPAY' => 'Partial payment',
    'CLAIM_UNPAID_FULLPAY' => 'Full payment',
    'CLAIM_UNPAID_PAY_ACTION' => 'pay',
    'CLAIM_UNPAID_ON_DATE' => 'on',
    'CLAIM_UNPAID_UNTIL' => 'until',
    'CLAIM_UNPAID_PAYMENT_CAPTION' => 'Payment reservation',
    'CLAIM_EARLYCOMISSION' => 'There is a commission<br>for the previous booking',
    'CLAIM_EARLY' => 'for earlier booking',
    'CLAIM_COMISSION' => 'Commission',
    'CLAIM_LAST_MTYPE' => 'Last<br>payment type',
    'CLAIM_NEXT_PDATE' => 'Next<br>payment date',
    'CLAIM_NEXT_PSUM' => 'Next<br>payment amount',
    'CLAIM_PAYMENT' => 'Payment',
    'CLAIM_NEARFUTURE' => 'in the near future',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
