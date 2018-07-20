<?php
$_messages = array(
    'SBERBANK_RESULT_TITLE' => 'Результат оплаты',
    'SBERBANK_POPUP_TITLE' => 'Оформление платежа в Сбербанке',
    'SBERBANK_PAYMENT_INFO' => 'Информация о платеже',
    'SBERBANK_PAID' => 'Оплачено:',
    'SBERBANK_INPUT_AMOUNT' => 'Сумма для оплаты',
    'SBERBANK_SUBMIT' => 'Оплатить',
    'SBERBANK_PARAMS_NOT_SETS' => 'Параметры системы Сбербанка не заданы!',
    'SBERBANK_EMPTY_AMOUNT' => 'Введите сумму для оплаты!',
    'SBERBANK_RESULT_ERROR_INUMBER' => 'Ошибка при получении статуса платежа (%s). Обратитесь к туроператору!',
    'SBERBANK_RESULT_ERROR' => 'Ошибка при получении статуса платежа. Обратитесь к туроператору!',
    'SBERBANK_RESULT_ERROR_INVALID_INUMBER' => 'Неверный номер счета. Обратитесь к туроператору!',
    'SBERBANK_RESULT_ERROR_ORDER_NOT_FOUND' => 'Платеж не найден!',
    'SBERBANK_RESULT_ERROR_STATUS_UNKNOWN' => 'Статус платежа не известен',
    'SBERBANK_RESULT_ERROR_STATUS_0' => 'Заказ зарегистрирован, но не оплачен',
    'SBERBANK_RESULT_ERROR_STATUS_3' => 'Авторизация отменена',
    'SBERBANK_RESULT_ERROR_STATUS_4' => 'По транзакции была проведена операция возврата',
    'SBERBANK_RESULT_ERROR_STATUS_5' => 'Инициирована авторизация через ACS банка-эмитента',
    'SBERBANK_RESULT_ERROR_STATUS_6' => 'Авторизация отклонена',
    'SBERBANK_RESULT_ERROR_BAD_AMOUNT' => 'Неверная сумма платежа!',
    'SBERBANK_RESULT_ERROR_ALREADY_CONFIRM' => 'Платеж уже подтвержден!',
    'SBERBANK_RESULT_DESCRIPTION' => 'Описание платежа',
    'SBERBANK_RESULT_RESULT' => 'Результат платежа',
    'SBERBANK_RESULT_INUMBER' => 'Номер платежа',
    'SBERBANK_RESULT_AMOUNT' => 'Сумма платежа',
    'SBERBANK_RESULT_CARDHOLDER' => 'Плательщик',
    'SBERBANK_RESULT_OK' => 'Запрос успешно обработан, платеж подтвержден',
    'SBERBANK_RESULT_HOLD' => 'Запрос успешно обработан, необходимая сумма захолдирована',
    'SBERBANK_PAY_ON_BANK_SITE' => 'Перейти на сайт банка для оплаты'

);

if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
