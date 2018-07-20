<?php
$_messages = array (
    'PAGE_TITLE' => 'Tourist profile',
    'ANKETA_ERROR_ON_COMPRESS_FILE' => 'Error during file compression.',
    'ANKETA_IMAGE_WIDTH_HEIGHT' => 'The image must be at least %dx%d pixels.',
    'ANKETA_IMAGE_NOT_VALID_TYPE' => 'Unsupported file type %s',
    'ANKETA_IMAGE_SCOPE' => 'The image must be in proportion %dx%d pixels.',
    'ANKETA_IMAGE_VERY_LARGE' => 'You upload is too large image.',
    'ANKETA_ALREDY_SAVED' => 'Profile has already been saved.',
    'ANKETA_PHOTO_NOT_PROPERTIES' => 'Size Image "%s" is not set. Please refer to the tour operator.',
    'ANKETA_SAVED' => 'Profile saved',
    'ANKETA_TOURIST_NOT_INFO' => 'Unable to get information about tourist. Please refer to the tour operator',
    'ANKETA_TOURIST_NOT_VISA' => 'Do not ordered a tourist visa',
    'BTN_ACCEPT' => 'Data are filled in correctly, continue',
    'BTN_EDIT' => 'Edit tourist',

);
if (isset($messages) && is_array($messages))  {$messages = array_merge($messages,$_messages);} else {$messages = $_messages;}
?>