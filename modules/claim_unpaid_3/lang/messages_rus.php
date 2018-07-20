<?php
include dirname(__FILE__) . '/../../check_confirm_3/lang/messages_rus.php';
include dirname(__FILE__) . '/../../cl_refer_3/lang/messages_rus.php';
$_messages = array(
    'PAGE_TITLE' => 'Неоплаченные заявки',
    'CLAIM_UNPAID_CLAIM_NUMBER' => 'Заявка',
    'CLAIM_UNPAID_CLAIM_STATUS' => 'Статус',
    'CLAIM_UNPAID_CHECKIN' => 'Начало тура',
    'CLAIM_UNPAID_COST' => 'Стоимость',
    'CLAIM_UNPAID_DEBT' => 'Сумма долга',
    'CLAIM_UNPAID_PARTPAY' => 'Частичная оплата',
    'CLAIM_UNPAID_FULLPAY' => 'Полная оплата',
    'CLAIM_UNPAID_PAY_ACTION' => 'оплатить',
    'CLAIM_UNPAID_ON_DATE' => 'на',
    'CLAIM_UNPAID_UNTIL' => 'до',
    'CLAIM_UNPAID_PAYMENT_CAPTION' => 'Оплата заявки',
    'CLAIM_EARLYCOMISSION' => 'Есть комиссия<br>за ранее бронирование',
    'CLAIM_EARLY' => 'за раннее бронирование',
    'CLAIM_COMISSION' => 'Комиссия',
    'CLAIM_LAST_MTYPE' => 'Тип<br>последнего платежа',
    'CLAIM_NEXT_PDATE' => 'Дата<br>ближайшего платежа',
    'CLAIM_NEXT_PSUM' => 'Сумма<br>ближайшего платежа',
    'CLAIM_PAYMENT' => 'Оплата',
    'CLAIM_NEARFUTURE' => 'в ближайшее время',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
