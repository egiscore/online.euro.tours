<?php
$_messages = array(
    'KKB_KZ_POPUP_TITLE' => 'Оформление платежа в Казкоммерцбанке',
    'KKB_KZ_PARAMS_NOT_SETS' => 'Параметры системы Казкоммерцбанка не заданы!',
    'KKB_KZ_PAID' => 'Оплачено:',
    'KKB_KZ_INPUT_AMOUNT' => 'Сумма для оплаты',
    'KKB_KZ_INPUT_EMAIL' => 'E-mail',
    'KKB_KZ_SUBMIT' => 'Оплатить',
    'KKB_KZ_EMPTY_AMOUNT' => 'Введите сумму для оплаты!',
    'KKB_KZ_OVER_AMOUNT' => 'Вы можете оплатить не более ',
    'KKB_KZ_PAYMENT_INFO' => 'Информация о платеже',
    'KKB_KZ_RESULT_TITLE' => 'Результат платежа в Казкоммерцбанке',
    'KKB_KZ_RESULT_FAIL' => 'Оплата не была осуществлена',
    'KKB_KZ_RESULT_OK' => 'Платеж совершен успешно',
);

if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
