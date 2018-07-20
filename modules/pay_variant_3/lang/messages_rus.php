<?php

$filename = basename(__FILE__);
foreach (['alfabank','bonus_manager_3', 'deposit_3', 'credit_europe_bank', 'kkb_kz', 'paylate', 'platron', 'psbank', 'sberbank', 'uniteller'] as $pay_variant) {
    $translate = _ROOT . 'modules/' . $pay_variant . '/lang/' . $filename;
    if (file_exists($translate)) {
        include $translate;
    }
}

$_messages = array(
    'PAGE_TITLE' => 'Оплата заявки',
    'CL_R_DEPOSIT' => 'Ваш депозит',
    'CL_R_DEPOSIT_PDATE' => 'Дата платежа',
    'CL_R_DEPOSIT_SUMM' => 'Сумма',
    'CL_R_DEPOSIT_CURRENCY' => 'Валюта',
    'CL_R_DEPOSIT_TYPE' => 'Тип',
    'CL_R_DEPOSIT_RESERVATIONS' => 'Заявки',
    'CL_R_DEPOSIT_RAWINVOICE' => '№ счета',
    'CL_R_DEPOSIT_RIDATE' => 'Дата счета',
    'CL_R_DEPOSIT_USE' => 'Использовать',
    'CL_R_BONUS_MANAGER' => 'Ваши бонусы',
    'PAY_VARIANT_TITLE' => 'Возможные способы оплаты заявки',
    'PAY_VARIANT_CURRENT_OWNER' => 'Владельцем заявки является',
    'PAY_VARIANT_IS_EMPTY' => 'На данный момент нет доступных способов оплаты. Свяжитесь с туроператором.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
