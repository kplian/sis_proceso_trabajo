<?php
if (!defined('ENVIRONMENT')) {
    $domain = strtolower($_SERVER['HTTP_HOST']);

    switch ($domain) {
        case '172.18.79.207':
            define('ENVIRONMENT', 'development');
            define('PATH_DOWNLOADED_ATTACHMENTS', '/var/www/html/etr/reportes_generados/aperturas_digitales/');
            break;
        case '172.18.79.248':
            define('ENVIRONMENT', 'test');
            define('PATH_DOWNLOADED_ATTACHMENTS', '/var/www/html/etrtest/reportes_generados/aperturas_digitales/');
            break;
        default :
            define('ENVIRONMENT', 'production');
            define('PATH_DOWNLOADED_ATTACHMENTS', '/var/www/html/etr/reportes_generados/aperturas_digitales/');
            break;
    }
}
