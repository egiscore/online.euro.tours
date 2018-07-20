<?php
/**
 * Created by PhpStorm.
 * User: andrey.krokhin
 * Date: 14.07.2016
 * Time: 11:57
 */

$_messages = array(
    'WSPAY_TICKET_NOT_FOUND' => 'Ticket %s is not found.',
    'WSPAY_ACCESS_DANIED_FOR_TICKET' => 'You have not permissions to view this ticket',
    'WSPAY_ACCESS_DANIED_FOR_OWNER' => 'You have not permissions to view tickets of this owner',
    'WSPAY_ACCESS_DANIED_FOR_PARTNER' => 'You have not permissions to view tickets of this partner',
    'WSPAY_TICKET_ALREADY_CONFIRMED' => 'Ticket %s is already confirmed %s.',
    'WSPAY_IMPOSSIBLE_TO_PAY_TICKET' => 'It is impossible to pay ticket: claim status is %s.',
    'WSPAY_IMPOSSIBLE_TO_PAY_TICKET_DOUBLE' => 'It is impossible to pay ticket: duplicate claim.',
    'WSPAY_CLAIM_NOT_FOUND' => 'Claim for ticket is not found.',
    'WSPAY_INCORRECT_INFORMATION' => 'Incorrect claim number or buyer passport number or partner login.',
    'WSPAY_USER_NOT_FOUND' => 'User %s is not found',
    'WSPAY_CURRENCY_NOT_FOUND' => 'Currency %s is not found',
    'WSPAY_CURRENCY_RATE_INVALID' => 'Cannot rate currency.',
    'WSPAY_PAYMENT_ERROR_MINUS' => 'Faild to make a payment: negative amount of payment.',
    'WSPAY_CLAIM_CANNOT_PAY' => 'Claim %d is cannot be payed. Contact your tour operator.',
    'WSPAY_CONFIG_ERROR' => 'Cannot get config.',
    'WSPAY_CLAIM_COST_ERROR' => 'Cannot rate claim cost',
    'WSPAY_TICKET_CREATE_ERROR' => 'Cannot to create ticket',
    'WSPAY_CLAIM_CANNOT_PAY2' => 'Claim cannot be payed. Contact your tour operator.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
return $messages;
