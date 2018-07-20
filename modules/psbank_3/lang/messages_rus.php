<?php
$_messages = array(
    'PAGE_TITLE' => 'Квитанция для оплаты в отделении банка',
    'POPUP_TITLE' => 'Квитанция для оплаты в отделении банка',
    'NO_BANK_LIST' => 'Не определены банки для оплаты. Обратитесь к туроператору.',
    'ERROR_GET_DATA' => 'Не переданы необходимые данные.',
    'ERROR_ON_SAVE_PAYER' => 'Ошибка при сохранении плательщика.',
    'SELECT_PAYER' => 'Выберите плательщика',
    'NEW_PAYER' => 'Новый плательщик',
    'PAYER_INFO' => 'Информация о плательщике',
    'PAYER_FIO' => 'ФИО плательщика:',
    'PAYER_BRON' => 'Дата рождения:',
    'PAYER_ADRESS' => 'Адрес плательщика:',
    'PAYER_PSERIE' => 'Серия паспорта:',
    'PAYER_PNUMBER' => 'Номер паспорта:',
    'PAYER_PGIVENDATE' => 'Дата выдачи:',
    'PAYER_PGIVENORG' => 'Кем выдан:',
    'PAYER_PGIVENORG_MENT' => 'Код подразделения:',
    'PAYMENT_INFO' => 'Информация о платеже',
    'PAYED' => 'Оплачено:',
    'MAX_AMOUNT' => 'Сумма для оплаты:',
    'BANK_INFO' => 'Информация о банке',
    'KVITOK_BTN' => 'Выписать квитанцию',
    'PSBANK_WRONG_PGIVENDATE' => 'Неверная дата выдачи паспорта',
    'PSBANK_WRONG_BORN' => 'Неверная дата рождения',
    'PAYER_READONLY' => 'Редактирование информации о плательщике запрещено.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
