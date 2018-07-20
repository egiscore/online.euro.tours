<?php
    $server_conf = realpath(__DIR__.'/../conf/server.conf');

    if (file_exists($server_conf)) {
        if ($cfg = parse_ini_file($server_conf)) {
            if (isset($cfg['WEBROOT'])) {
            $__ROOT = __DIR__.DIRECTORY_SEPARATOR.$cfg['WEBROOT'];
                if (file_exists($__ROOT) && file_exists($__ROOT.DIRECTORY_SEPARATOR.'cron.php') && realpath($__ROOT.DIRECTORY_SEPARATOR.'cron.php') !== __FILE__) {
                    chdir($__ROOT);
                    return include 'cron.php';
                }
            }
        }
    }
    ignore_user_abort(true);
    header('Content-type: image/gif');
    echo base64_decode("R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==");
    flush();

?>
