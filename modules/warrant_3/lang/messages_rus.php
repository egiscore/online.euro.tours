<?php
$_messages = array(
    'PAGE_TITLE' => 'Доверенность',
    'WARRANT_NO' => 'Нет',
    'WARRANT_YES' => 'Да',
    'WARRANT_PNAME' => 'ФИО',
    'WARRANT_PLNAME' => 'ФИО по-латински',
    'WARRANT_PSSERIE' => 'Серия',
    'WARRANT_PASPORT' => 'Паспорт',
    'WARRANT_PSNUMBER' => 'Серия и номер',
    'WARRANT_PSWHEN' => 'Паспорт выдан',
    'WARRANT_PSWHERE' => 'Кем выдан',
    'WARRANT_PCODEORG' => 'Код подразделения',
    'WARRANT_PBORN' => 'Дата рождения',
    'WARRANT_PADD' => 'Адрес',
    'WARRANT_PDATE' => 'Даты действия',
    'WARRANT_PHAVE' => 'Есть в наличии',
    'WARRANT_PHAVEORIGINAL' => 'оригинал',
    'WARRANT_PHAVECOPY' => 'копия',
    'WARRANT_PRINT' => 'Печать',
    'WARRANT_ADD' => 'Добавить доверенность',
    'POPUP_TITLE' => 'Новая доверенность',

    'PAYER_INFO' => 'Информация о плательщике',
    'PAYER_FIO' => 'ФИО плательщика:',
    'PAYER_BORN' => 'Дата рождения:',
    'PAYER_ADRESS' => 'Адрес плательщика:',
    'PAYER_PSERIE' => 'Серия паспорта:',
    'PAYER_PNUMBER' => 'Номер паспорта:',
    'PAYER_PGIVENDATE' => 'Дата выдачи:',
    'PAYER_PGIVENORG' => 'Кем выдан:',
    'PAYER_PGIVENORG_MENT' => 'Код подразделения:',
    'SAVE_BTN_WARRANT' => 'Сохранить',

    'WARRANT_NO_CONTRACT' => 'Не удалось получить информацию о договоре',
    'WARRANT_WRONG_PGIVENDATE' => 'Неверная дата выдачи паспорта',
    'WARRANT_WRONG_BORN' => 'Неверная дата рождения',
    'WARRANT_NOT_SAVED' => 'Не удалось сохранить доверенность.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
