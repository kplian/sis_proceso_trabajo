<?php
if (!defined('ENVIRONMENT')) {
    $domain = strtolower($_SERVER['HTTP_HOST']);

    switch ($domain) {
        case '172.18.79.207':
            define('ENVIRONMENT', 'development');
            define('PATH_DOWNLOADED_ATTACHMENTS', '/var/www/html/valvaradoetr/uploaded_files/');
            break;
        case '172.18.79.248':
            define('ENVIRONMENT', 'test');
            define('PATH_DOWNLOADED_ATTACHMENTS', '/var/www/html/etrtest/uploaded_files/');
            break;
        default :
            define('ENVIRONMENT', 'production');
            define('PATH_DOWNLOADED_ATTACHMENTS', '/var/www/html/etr/uploaded_files/');
            break;
    }
}
