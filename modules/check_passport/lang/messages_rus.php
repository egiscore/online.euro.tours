<?php
$_messages = array(
    'CHECK_PASSPORT' => 'Проверка срока действия загранпаспортов',
    'CHECK_PASSPORT_CITY_DEPARTURE' => 'Город вылета',
    'CHECK_PASSPORT_COUNTRY_DESTINATION' => 'Страна назначения',
    'CHECK_PASSPORT_CITIZENSHIP' => 'Гражданство',
    'CHECK_PASSPORT_PLACE_BIRTH' => 'Место рождения',
    'CHECK_PASSPORT_DEPARTURE_DATE' => 'Дата вылета',
    'CHECK_PASSPORT_DURATION' => 'Продолжительность тура (ночей)',
    'CHECK_PASSPORT_CHECK' => 'Проверить',
    'CHECK_PASSPORT_VALID' => 'Ваш паспорт подходит для совершения путешествия.',
    'CHECK_PASSPORT_VALID_NOTE' => 'Ваш паспорт подходит для совершения поездки, но требуется заранее оформленное визовое приглашение.',
    'CHECK_PASSPORT_INVALID' => 'Ваш паспорт не подходит для совершения поездки, просим переоформить паспорт.',
    'CHECK_PASSPORT_VALID_DATE' => 'Срок действия паспорта',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
