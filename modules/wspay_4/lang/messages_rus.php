<?php
/**
 * Created by PhpStorm.
 * User: andrey.krokhin
 * Date: 14.07.2016
 * Time: 11:08
 */

$_messages = array(
    'WSPAY_TICKET_NOT_FOUND' => 'Квитанция %s не найдена.',
    'WSPAY_ACCESS_DANIED_FOR_TICKET' => 'Нет прав для просмотра данной квитанции',
    'WSPAY_ACCESS_DANIED_FOR_OWNER' => 'Нет прав для просмотра заявок этого владельца',
    'WSPAY_ACCESS_DANIED_FOR_PARTNER' => 'Нет прав для просмотра заявок этого партнера',
    'WSPAY_TICKET_ALREADY_CONFIRMED' => 'Квитанция %s уже подтверждена %s.',
    'WSPAY_IMPOSSIBLE_TO_PAY_TICKET' => 'Невозможно оплатить квитанцию: статус заявки %s.',
    'WSPAY_IMPOSSIBLE_TO_PAY_TICKET_DOUBLE' => 'Невозможно оплатить квитанцию: дублирование квитанции.',
    'WSPAY_CLAIM_NOT_FOUND' => 'Заявка по квитанции не найдена.',
    'WSPAY_INCORRECT_INFORMATION' => 'Неверный номер заявки или номер паспорта покупателя или логин партнера.',
    'WSPAY_USER_NOT_FOUND' => 'Пользователь %s не найден',
    'WSPAY_CURRENCY_NOT_FOUND' => 'Валюта %s не найдена',
    'WSPAY_CURRENCY_RATE_INVALID' => 'Не удалось рассчитать курс.',
    'WSPAY_PAYMENT_ERROR_MINUS' => 'Не удалось провести платеж: отрицательная сумма платежа.',
    'WSPAY_CLAIM_CANNOT_PAY' => 'Заявка %d не может быть оплачена. Обратитесь к туроператору.',
    'WSPAY_CONFIG_ERROR' => 'Не удалось получить настройки.',
    'WSPAY_CLAIM_COST_ERROR' => 'Не удалось посчитать стоимость заявки',
    'WSPAY_TICKET_CREATE_ERROR' => 'Не удалось создать квитанцию',
    'WSPAY_CLAIM_CANNOT_PAY2' => 'Заявка не может быть оплачена. Обратитесь к туроператору.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
return $messages;
