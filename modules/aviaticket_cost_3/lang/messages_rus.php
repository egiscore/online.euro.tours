<?php
$_messages = array(
    'PAGE_TITLE' => 'Стоимость авиабилетов',
    'AC_CLAIM_NUMBER' => 'Заявка №',
    'AC_TOUR_ROUTE' => 'Маршрут:',
    'AC_CLASS' => 'Класс:',
    'AC_PEOPLE_NAME' => 'ФИО по-русски',
    'AC_PEOPLE_LNAME' => 'ФИО по-латински',
    'AC_NO_PEOPLES' => 'Туристов не найдено',
    'AC_PRINT_BTN' => 'Справка',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
