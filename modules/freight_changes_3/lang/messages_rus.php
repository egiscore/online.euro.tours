<?php
$_messages = array(
    'FRCHANGES_PUBLIC' => 'Опубликовано',
    'FRCHANGES_TEXT_1' => 'Вылет рейса',
    'FRCHANGES_REFRESH' => 'Обновить',
    'FRCHANGES_TOWNFROM' => 'Вылет из',
    'FRCHANGES_STATE' => 'Страна',
    'FRCHANGES_TOURNAME' => 'Тур',
    'FRCHANGES_DATE' => 'Дата вылета',
    'PAGE_TITLE' => 'Изменения в расписании рейсов',
    'FRCHANGES_ROUTE' => 'Маршрут',
    'FRCHANGES_TEXT_2' => 'по маршруту',
    'FRCHANGES_TEXT_3' => 'вместо',
    'FRCHANGES_TEXT_4' => 'будет выполняться',
    'FRCHANGES_TEXT_5' => 'рейсом',
    'FRCHANGES_TEXT_6' => 'в',
    'FRCHANGES_TEXT_7' => 'из',
    'FRCHANGES_TEXT_8' => 'вылет по маршруту',
    'FRCHANGES_TEXT_9' => 'вместо рейса',
    'FRCHANGES_TEXT_10' => 'будет выполняться рейсом',
    'FRCHANGES_TEXT_11' => 'Опубликовано',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
