<?php
define('APP_PATH', realpath('..'));

require_once APP_PATH . '/bootstrap/autoload.php';

$service = new Senkyou\Di\ServiceDefault(APP_PATH . '/config');
$app = new Phalcon\Mvc\Application($service);
$app->handle()->send();