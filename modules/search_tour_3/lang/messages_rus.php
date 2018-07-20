<?php
$_messages = array(
    'PAGE_TITLE' => 'Поиск тура',
    'NO_DATA' => 'Данных не найдено. Измените параметры поиска',
    'NO_DOPDATA' => 'Дополнительных данных не найдено.',
    'SERVER_NOT_AVAILABLE' => 'Поиск по выбранному направлению временно недоступен.',
    'PROMOTIONS' => 'акции',
    'FILTERS' => 'фильтры',
    'TOUR_SEARCH_PRICE_STATS' => 'Динамика цены, наличие мест на рейсы',
    'TOUR_SEARCH_RES_YES_PLACE' => 'есть места',
    'TOUR_SEARCH_RES_YESNO_PLACE' => 'мало мест',
    'TOUR_SEARCH_RES_NO_PLACE' => 'нет мест',
    'TOUR_SEARCH_RES_REQUEST_PLACE' => 'места по запросу',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
