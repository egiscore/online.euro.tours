<?php
/**
 * Created by PhpStorm.
 * User: andrey.krokhin
 * Date: 14.07.2016
 * Time: 11:08
 */

$_messages = array(
    'WSPAY_TICKET_NOT_FOUND' => '��������� %s �� �������.',
    'WSPAY_ACCESS_DANIED_FOR_TICKET' => '��� ���� ��� ��������� ������ ���������',
    'WSPAY_ACCESS_DANIED_FOR_OWNER' => '��� ���� ��� ��������� ������ ����� ���������',
    'WSPAY_ACCESS_DANIED_FOR_PARTNER' => '��� ���� ��� ��������� ������ ����� ��������',
    'WSPAY_TICKET_ALREADY_CONFIRMED' => '��������� %s ��� ������������ %s.',
    'WSPAY_IMPOSSIBLE_TO_PAY_TICKET' => '���������� �������� ���������: ������ ������ %s.',
    'WSPAY_IMPOSSIBLE_TO_PAY_TICKET_DOUBLE' => '���������� �������� ���������: ������������ ���������.',
    'WSPAY_CLAIM_NOT_FOUND' => '������ �� ��������� �� �������.',
    'WSPAY_INCORRECT_INFORMATION' => '�������� ����� ������ ��� ����� �������� ���������� ��� ����� ��������.',
    'WSPAY_USER_NOT_FOUND' => '������������ %s �� ������',
    'WSPAY_CURRENCY_NOT_FOUND' => '������ %s �� �������',
    'WSPAY_CURRENCY_RATE_INVALID' => '�� ������� ���������� ����.',
    'WSPAY_PAYMENT_ERROR_MINUS' => '�� ������� �������� ������: ������������� ����� �������.',
    'WSPAY_CLAIM_CANNOT_PAY' => '������ %d �� ����� ���� ��������. ���������� � ������������.',
    'WSPAY_CONFIG_ERROR' => '�� ������� �������� ���������.',
    'WSPAY_CLAIM_COST_ERROR' => '�� ������� ��������� ��������� ������',
    'WSPAY_TICKET_CREATE_ERROR' => '�� ������� ������� ���������',
    'WSPAY_CLAIM_CANNOT_PAY2' => '������ �� ����� ���� ��������. ���������� � ������������.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
return $messages;
