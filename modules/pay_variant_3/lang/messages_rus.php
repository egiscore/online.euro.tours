<?php

$filename = basename(__FILE__);
foreach (['alfabank','bonus_manager_3', 'deposit_3', 'credit_europe_bank', 'kkb_kz', 'paylate', 'platron', 'psbank', 'sberbank', 'uniteller'] as $pay_variant) {
    $translate = _ROOT . 'modules/' . $pay_variant . '/lang/' . $filename;
    if (file_exists($translate)) {
        include $translate;
    }
}

$_messages = array(
    'PAGE_TITLE' => '������ ������',
    'CL_R_DEPOSIT' => '��� �������',
    'CL_R_DEPOSIT_PDATE' => '���� �������',
    'CL_R_DEPOSIT_SUMM' => '�����',
    'CL_R_DEPOSIT_CURRENCY' => '������',
    'CL_R_DEPOSIT_TYPE' => '���',
    'CL_R_DEPOSIT_RESERVATIONS' => '������',
    'CL_R_DEPOSIT_RAWINVOICE' => '� �����',
    'CL_R_DEPOSIT_RIDATE' => '���� �����',
    'CL_R_DEPOSIT_USE' => '������������',
    'CL_R_BONUS_MANAGER' => '���� ������',
    'PAY_VARIANT_TITLE' => '��������� ������� ������ ������',
    'PAY_VARIANT_CURRENT_OWNER' => '���������� ������ ��������',
    'PAY_VARIANT_IS_EMPTY' => '�� ������ ������ ��� ��������� �������� ������. ��������� � �������������.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
