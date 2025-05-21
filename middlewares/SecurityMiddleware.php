<?php

namespace middlewares;

use core\Middleware;

class SecurityMiddleware extends Middleware
{
    
    public function handle()
    {
        $core = $this->core;
        $class = $core->controllerClass;
        $method = $core->actionMethod;
        
        
        $controller = new $class($this->core);
        $controller->$method();
        
//        var_dump($parameters);
//        $reflection = new ReflectionMethod($controller, $actionMethod);
//        $actionRequiredParameters = $reflection->getParameters();
//        if (!empty($actionRequiredParameters)) {
//            $parameter = $actionRequiredParameters[0];
//            $type = $parameter->getType();
//            var_dump($type->getName());
//        }
//        $controller->$actionMethod($parameters);
    }
}