<?php
$_messages = array(
    'PAGE_TITLE' => 'Рейтинги агентств',
    'RATING_AMOUNT' => 'Сумма к оплате, $:',
    'RATING_CREATE_DATETIME' => 'Дата и время обновления:',
    'RATING_DEPTH' => 'Средняя глубина продаж, в днях:',
    'RATING_INTERNET_CLAIMS_COUNT' => 'Количество заявок из online:',
    'RATING_INTERNET_CLAIMS_PERCENT' => 'Процент заявок через online:',
    'RATING_NO_ACCESS' => 'Доступ закрыт',
    'RATING_PAID' => 'Оплаченная сумма, $:',
    'RATING_PAX' => 'Количество туристов:',
    'RATING_RCOUNT' => 'Количество номеров:',
    'RATING_POSITION' => 'Позиция в рейтинге:',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
