<?php
$_messages = array(
    'PAGE_TITLE' => 'Бонусы менеджеров',
    'BONUS_MANAGER_CURRENCY' => 'Валюта',
    'BONUS_MANAGER_ADD' => 'Начислено',
    'BONUS_MANAGER_DELETE' => 'Израсходовано',
    'BONUS_MANAGER_TOTAL' => 'Осталось',
    'BONUS_MANAGER_DATE' => 'Дата',
    'BONUS_MANAGER_TYPE' => 'Тип',
    'BONUS_MANAGER_CLAIM' => 'Заявка',
    'BONUS_MANAGER_BONUS' => 'Бонус',
    'BONUS_MANAGER_SHOW_DETAIL' => 'Показать детали',
    'BONUS_MANAGER_HIDE_DETAIL' => 'Скрыть детали',
    'BONUS_MANAGER_IN' => 'Приход',
    'BONUS_MANAGER_OUT' => 'Расход',
    'BONUS_MANAGER_UNKNOWN' => '???',
    'BONUS_MANAGER_CLAIM_COST' => 'Доступно к оплате',
    'BONUS_MANAGER_SUM_AVAILABLE' => 'Накопленные баллы',
    'BONUS_MANAGER_USE' => 'Оплата',
    'BONUS_MANAGER_USE_BTN' => 'Использовать',
    'BONUS_MANAGER_CONFIRM' => 'Вы действительно хотите использовать бонусные баллы в счёт оплаты заявки?',
    'BONUS_MANAGER_PAY_FAILED' => 'Произошла ошибка в процессе списания бонусов. Обратитесь к туроператору.',
    'BONUS_MANAGER_PAY_SUCCESS' => 'Бонусы успешно списаны.',
    'BONUS_MANAGER_BONUS_TOTAL_AVAILABLE' => 'доступно',
    'BONUS_MANAGER_BONUS_STATUS' => 'Статус',
    'BONUS_MANAGER_BONUS_AVAILABLE' => 'Доступен',
    'BONUS_MANAGER_BONUS_UNAVAILABLE' => 'Недоступен',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
