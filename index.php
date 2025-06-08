<?php

use core\Core;
use middlewares\AuthenticationMiddleware;
use middlewares\ErrorMiddleware;
use middlewares\ExecutionMiddleware;
use middlewares\RouterMiddleware;

include 'autoload.php';
include 'shutdown.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");


$core = new Core();

$core->init();

$core->useMiddleware(new ErrorMiddleware($core));
$core->useMiddleware(new AuthenticationMiddleware($core));
$core->useMiddleware(new RouterMiddleware($core));
$core->useMiddleware(new ExecutionMiddleware($core));

$core->run();