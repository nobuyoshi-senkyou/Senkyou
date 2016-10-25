<?php
/**
 * Register The Composer Auto Loader
 *
 * If used composer autoload, You should require
 * the autoload.php file in vendor directory
 */
if (file_exists(APP_PATH . '/composer.json'))
    require_once APP_PATH . '/vendor/autoload.php';

/**
 * Register User Customer Directory And Library Directory
 */
require_once APP_PATH . '/bootstrap/helpers.php';

$loader = new \Phalcon\Loader();
$loader->registerNamespaces(array_merge(
    getRegisterDir('App', APP_PATH . '/app'),
    getRegisterDir('Senkyou', APP_PATH . '/vendor/senkyou/src/Senkyou')
))->register();