<?php

use core\Core;
use middlewares\ErrorMiddleware;
use middlewares\RouterMiddleware;

spl_autoload_register(function ($class) {
    $filename = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($filename)) {
        require_once $filename;
    }
});


$core = new Core();

$core->useMiddleware(new ErrorMiddleware($core));
$core->useMiddleware(new RouterMiddleware($core));

$core->run();