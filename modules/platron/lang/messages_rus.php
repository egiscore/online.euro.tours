<?php
$_messages = array(
    'PLATRON_POPUP_TITLE' => 'Оформление платежа в Platron',
    'PLATRON_PAYMENT_INFO' => 'Информация о платеже',
    'PLATRON_PAID' => 'Оплачено:',
    'PLATRON_INPUT_AMOUNT' => 'Сумма для оплаты',
    'PLATRON_SUBMIT' => 'Оплатить',
    'PLATRON_PARAMS_NOT_SETS' => 'Параметры системы Platron не заданы!',
    'PLATRON_EMPTY_AMOUNT' => 'Введите сумму для оплаты!',
    'PLATRON_OVER_AMOUNT' => 'Вы можете оплатить не более '
);

if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
