<?php
$_messages = array(
    'UNITELLER_POPUP_TITLE' => 'Оформление платежа в Uniteller',
    'UNITELLER_PARAMS_NOT_SETS' => 'Параметры системы Uniteller не заданы!',
    'UNITELLER_PAID' => 'Оплачено:',
    'UNITELLER_INPUT_AMOUNT' => 'Сумма для оплаты',
    'UNITELLER_SUBMIT' => 'Оплатить',
    'UNITELLER_EMPTY_AMOUNT' => 'Введите сумму для оплаты!',
    'UNITELLER_OVER_AMOUNT' => 'Вы можете оплатить не более ',
    'UNITELLER_PAYMENT_INFO' => 'Информация о платеже',
    'UNITELLER_RESULT_TITLE' => 'Результат платежа в Uniteller',
    'UNITELLER_RESULT_NO' => 'Оплата не была осуществлена',
    'UNITELLER_RESULT_OK' => 'Платеж совершен успешно',
);

if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
