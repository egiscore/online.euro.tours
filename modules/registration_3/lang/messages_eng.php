<?php
$_messages = array(
    'PAGE_TITLE' => 'Sign up',
    'PARTNER_INCORRECT_ADMIN_EMAIL_IN_DB' => 'Our database is stored incorrect e-mail address of your administrator! We can not send him a letter.',
    'REGISTRATION_FIND_AGENCY' => 'For the login and password you need to find your agency of the tour operator.',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
