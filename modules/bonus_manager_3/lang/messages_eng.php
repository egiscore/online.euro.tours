<?php
$_messages = array(
    'PAGE_TITLE' => 'Bonus of managers',
    'BONUS_MANAGER_CURRENCY' => 'Currency',
    'BONUS_MANAGER_ADD' => 'Earn',
    'BONUS_MANAGER_DELETE' => 'Spent',
    'BONUS_MANAGER_TOTAL' => 'Remains',
    'BONUS_MANAGER_DATE' => 'Date',
    'BONUS_MANAGER_TYPE' => 'Type',
    'BONUS_MANAGER_CLAIM' => 'Claim',
    'BONUS_MANAGER_BONUS' => 'Bonus',
    'BONUS_MANAGER_SHOW_DETAIL' => 'Show details',
    'BONUS_MANAGER_HIDE_DETAIL' => 'Hide details',
    'BONUS_MANAGER_IN' => 'Parish',
    'BONUS_MANAGER_OUT' => 'Expenses',
    'BONUS_MANAGER_UNKNOWN' => 'Unknown',
    'BONUS_MANAGER_CLAIM_COST' => 'Available for payment',
    'BONUS_MANAGER_SUM_AVAILABLE' => 'Redeem bonus points',
    'BONUS_MANAGER_USE' => 'Payment',
    'BONUS_MANAGER_USE_BTN' => 'Use',
    'BONUS_MANAGER_CONFIRM' => 'Do you really want to use the bonus points as payment requests?',
    'BONUS_MANAGER_PAY_FAILED' => 'An error occurred during the use bonuses. Please refer to the tour operator.',
    'BONUS_MANAGER_PAY_SUCCESS' => 'Bonuses used successfully.',
    'BONUS_MANAGER_BONUS_TOTAL_AVAILABLE' => 'available',
    'BONUS_MANAGER_BONUS_STATUS' => 'Status',
    'BONUS_MANAGER_BONUS_AVAILABLE' => 'Available',
    'BONUS_MANAGER_BONUS_UNAVAILABLE' => 'Unavailable',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
