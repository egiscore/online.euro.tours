<?php
$_messages = array(
    'PAGE_TITLE' => '������������',
    'WARRANT_NO' => '���',
    'WARRANT_YES' => '��',
    'WARRANT_PNAME' => '���',
    'WARRANT_PLNAME' => '��� ��-��������',
    'WARRANT_PSSERIE' => '�����',
    'WARRANT_PASPORT' => '�������',
    'WARRANT_PSNUMBER' => '����� � �����',
    'WARRANT_PSWHEN' => '������� �����',
    'WARRANT_PSWHERE' => '��� �����',
    'WARRANT_PCODEORG' => '��� �������������',
    'WARRANT_PBORN' => '���� ��������',
    'WARRANT_PADD' => '�����',
    'WARRANT_PDATE' => '���� ��������',
    'WARRANT_PHAVE' => '���� � �������',
    'WARRANT_PHAVEORIGINAL' => '��������',
    'WARRANT_PHAVECOPY' => '�����',
    'WARRANT_PRINT' => '������',
    'WARRANT_ADD' => '�������� ������������',
    'POPUP_TITLE' => '����� ������������',

    'PAYER_INFO' => '���������� � �����������',
    'PAYER_FIO' => '��� �����������:',
    'PAYER_BORN' => '���� ��������:',
    'PAYER_ADRESS' => '����� �����������:',
    'PAYER_PSERIE' => '����� ��������:',
    'PAYER_PNUMBER' => '����� ��������:',
    'PAYER_PGIVENDATE' => '���� ������:',
    'PAYER_PGIVENORG' => '��� �����:',
    'PAYER_PGIVENORG_MENT' => '��� �������������:',
    'SAVE_BTN_WARRANT' => '���������',

    'WARRANT_NO_CONTRACT' => '�� ������� �������� ���������� � ��������',
    'WARRANT_WRONG_PGIVENDATE' => '�������� ���� ������ ��������',
    'WARRANT_WRONG_BORN' => '�������� ���� ��������',
    'WARRANT_NOT_SAVED' => '�� ������� ��������� ������������.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
