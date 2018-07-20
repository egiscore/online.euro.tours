<?php
$_messages = array(
    'ARRIVAL' => 'Отправление',
    'CODE' => 'Код',
    'DATETIME' => 'Дата выдачи',
    'DEPARTURE' => 'Прибытие',
    'FLY_DATE' => 'Дата отправления',
    'FREIGHT' => 'Транспорт',
    'NOTE' => 'Примечание',
    'PAGE_TITLE' => 'График выдачи документов',
    'TOUR' => 'Тур',
    'SHEDULE_DOC_TOWNFROM' => 'Город',
    'SHEDULE_DOC_STATE' => 'Страна',
    'SHEDULE_DOC_OFFICE' => 'Офис выдачи документов',
    'SHEDULE_DOC_CHECKIN' => 'Дата вылета',
    'REFRESH' => 'Показать',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
