<?php
$_messages = array (
    'PAGE_TITLE' => '������ �������',
    'ANKETA_ERROR_ON_COMPRESS_FILE' => '������ ��� ������ �����.',
    'ANKETA_IMAGE_WIDTH_HEIGHT' => '����������� ������ ���� �� ����� %dx%d ��������.',
    'ANKETA_IMAGE_NOT_VALID_TYPE' => '�� �������������� ��� ����� %s',
    'ANKETA_IMAGE_SCOPE' => '����������� ������ ���� ��������������� �������� %dx%d ��������.',
    'ANKETA_IMAGE_VERY_LARGE' => '�� ���������� ������� ������� �����������.',
    'ANKETA_ALREDY_SAVED' => '������ ��� ���������.',
    'ANKETA_PHOTO_NOT_PROPERTIES' => '������ ����������� "%s" �� ��������. ���������� � ������������.',
    'ANKETA_SAVED' => '������ ���������',
    'ANKETA_TOURIST_NOT_INFO' => '�� ������� �������� ���������� �� �������. ���������� � ������������',
    'ANKETA_TOURIST_NOT_VISA' => '� ������� �� �������� ����',
    'BTN_ACCEPT' => '������ ��������� �����, ����������',
    'BTN_EDIT' => '������������� �������',

);
if (isset($messages) && is_array($messages))  {$messages = array_merge($messages,$_messages);} else {$messages = $_messages;}
?>