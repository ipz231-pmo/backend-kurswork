<?php

namespace middlewares;

use core\Middleware;

class ExecutionMiddleware extends Middleware
{
    public function __construct($core)
    {
        parent::__construct($core);
    }
    
    public function handle() : void
    {
        $core = $this->core;
        
        $controllerClass = $core->controllerClass;
        $actionMethod = $core->actionMethod;
        $controllerInstance = new $controllerClass($core);
        $controllerInstance->$actionMethod();
    }
}