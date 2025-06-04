<?php

use core\Core;
use middlewares\AuthenticationMiddleware;
use middlewares\ErrorMiddleware;
use middlewares\ExecutionMiddleware;
use middlewares\RouterMiddleware;

spl_autoload_register(function ($class) {
    $filename = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($filename)) {
        require_once $filename;
    }
});


$core = new Core();

$core->init();

$core->useMiddleware(new ErrorMiddleware($core));
$core->useMiddleware(new AuthenticationMiddleware($core));
$core->useMiddleware(new RouterMiddleware($core));
$core->useMiddleware(new ExecutionMiddleware($core));

$core->run();