<?php
$_messages = array (
    'PAGE_TITLE' => 'Анкета туриста',
    'ANKETA_ERROR_ON_COMPRESS_FILE' => 'Ошибка при сжатии файла.',
    'ANKETA_IMAGE_WIDTH_HEIGHT' => 'Изображение должно быть не менее %dx%d пикселей.',
    'ANKETA_IMAGE_NOT_VALID_TYPE' => 'Не поддерживаемый тип файла %s',
    'ANKETA_IMAGE_SCOPE' => 'Изображение должно быть пропорционально размерам %dx%d пикселей.',
    'ANKETA_IMAGE_VERY_LARGE' => 'Вы загружаете слишком большое изображение.',
    'ANKETA_ALREDY_SAVED' => 'Анкета уже сохранена.',
    'ANKETA_PHOTO_NOT_PROPERTIES' => 'Размер изображения "%s" не настроен. Обратитесь к туроператору.',
    'ANKETA_SAVED' => 'Анкета сохранена',
    'ANKETA_TOURIST_NOT_INFO' => 'Не удается получить информацию по туристу. Обратитесь к туроператору',
    'ANKETA_TOURIST_NOT_VISA' => 'У туриста не заказана виза',
    'BTN_ACCEPT' => 'Данные заполнены верно, продолжить',
    'BTN_EDIT' => 'Редактировать туриста',

);
if (isset($messages) && is_array($messages))  {$messages = array_merge($messages,$_messages);} else {$messages = $_messages;}
?>