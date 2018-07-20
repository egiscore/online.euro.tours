<?php
$_messages = array(
// begin [the_best]
'PAGE_TITLE' => 'Лучшие предложения',
'BEST_REFRESH' => 'Показать',
'REFRESH' => 'Показать',
'THE_BEST_CHECKIN' => 'Заезд',
'THE_BEST_HOTEL' => 'Гостиница',
'THE_BEST_HTPLACE' => 'Размещение',
'THE_BEST_NIGHTS' => 'Ночей',
'THE_BEST_PRICE' => 'Цена',
'THE_BEST_ROOM' => 'Номер',
'THE_BEST_SPO' => 'СПО',
'THE_BEST_STAR' => 'Категория',
'THE_BEST_STATE_TO' => 'Страна',
'THE_BEST_TOUR' => 'Тур',
'THE_BEST_TOWN' => 'Город вылета',
'THE_BEST_TOWNTO' => 'Курорт',
'THE_BEST_LIKE' => 'Похожие',
'THE_BEST_MEAL' => 'Питание',
// end [the_best]
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
