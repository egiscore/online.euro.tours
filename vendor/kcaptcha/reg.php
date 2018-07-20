<?php
include __DIR__ . '/kcaptcha.php';
include dirname(dirname(__DIR__)) . '/properties.php';
ini_set('session.cookie_path', defined('COOKIE_PATH') ? COOKIE_PATH : WWWROOT);
ini_set('session.cookie_domain', COOKIE_DOMAIN);
session_name(SESSION_NAME);
session_start();
$captcha = new KCAPTCHA();
if ($_REQUEST[session_name()]) {
    $_SESSION['captcha_keystring'] = $captcha->getKeyString();
    session_write_close();
}
