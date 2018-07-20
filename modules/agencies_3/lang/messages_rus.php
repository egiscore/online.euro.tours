<?php
$_messages = array(
    'AGENCIES_SEARCH_LABEL' => 'Запрос',
    'AGENCIES_ENTER_YOUR_QUERY' => 'ИНН / Название / ФИО руководителя / Телефон',
    'AGENCIES_SEARCH' => 'Найти',
    'PAGE_TITLE' => 'Проверка партнера',
    'AGENCIES_NAME' => 'Название',
    'AGENCIES_TITLE' => 'Сокращенное наименование',
    'AGENCIES_TOWN_FILTER' => 'Город',
    'AGENCIES_METROSTATION_FILTER' => 'Метро',
    'AGENCIES_TOWN' => 'Город',
    'AGENCIES_ADDRESS' => 'Адрес',
    'AGENCIES_INN' => 'ИНН',
    'AGENCIES_OGRN' => 'ОГРН',
    'AGENCIES_KPP' => 'КПП',
    'AGENCIES_DATE_REGISTER' => 'Дата первичной регистрации',
    'AGENCIES_DATE_CLOSE' => 'Дата прекращения деятельности',
    'AGENCIES_STATUS' => 'Статус (состояние)',
    'AGENCIES_STATUS_YES' => 'Действующий',
    'AGENCIES_STATUS_NO' => 'Не действующий',
    'AGENCIES_OWNER' => 'Руководитель',
    'AGENCIES_ACTIVITIE' => 'Основной вид деятельности',
    'AGENCIES_OKVED' => 'ОКВЭД',
    'AGENCIES_DOG' => 'Действующий договор',
    'AGENCIES_AVAILABLE' => 'В наличии',
    'AGENCIES_AVAILABLE_YES' => 'Да',
    'AGENCIES_AVAILABLE_NO' => 'Нет',
    'AGENCIES_LAST_ORDER' => 'Дата последней заявки',
    'AGENCIES_DATE' => 'Информация актуальная на',
    'AGENCIES_RATING' => 'Рейтинг',

    'AGENCIES_MORE' => 'Подробнее',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
