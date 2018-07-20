<?php
$filename = basename(__FILE__);
foreach (['alfabank','bonus_manager_3', 'deposit_3', 'credit_europe_bank', 'kkb_kz', 'paylate', 'platron', 'psbank', 'sberbank', 'uniteller'] as $pay_variant) {
    $translate = _ROOT . 'modules/' . $pay_variant . '/lang/' . $filename;
    if (file_exists($translate)) {
        include $translate;
    }
}

$_messages = array(
    'PAGE_TITLE' => 'Payments',
    'CL_R_DEPOSIT' => 'Deposit',
    'CL_R_DEPOSIT_PDATE' => 'Payment date',
    'CL_R_DEPOSIT_SUMM' => 'Amount',
    'CL_R_DEPOSIT_CURRENCY' => 'Currency',
    'CL_R_DEPOSIT_TYPE' => 'Type',
    'CL_R_DEPOSIT_RESERVATIONS' => 'Claims',
    'CL_R_DEPOSIT_RAWINVOICE' => 'Invoice number',
    'CL_R_DEPOSIT_RIDATE' => 'Invoice date',
    'CL_R_DEPOSIT_USE' => 'Use deposit',
    'CL_R_BONUS_MANAGER' => 'Bonus',
    'PAY_VARIANT_TITLE' => 'Possible methods of payment',
    'PAY_VARIANT_CURRENT_OWNER' => 'Reservation owner is ',
    'PAY_VARIANT_IS_EMPTY' => 'There is no available payment methods. Please contact the tour operator.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
