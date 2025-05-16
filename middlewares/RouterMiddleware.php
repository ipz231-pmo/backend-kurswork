<?php

namespace middlewares;

use core\Middleware;
use ReflectionMethod;

class RouterMiddleware extends Middleware
{
    
    public function handle()
    {
        $route = $_GET["route"] ?? "";
        $parts = explode('/', $route);
        
        if (sizeof($parts) == 1 || $parts[1] == '') {
            $parts[1] = 'index';
        }
        if ($parts[0] == '') {
            $parts[0] = 'site';
            $parts[1] = 'index';
        }
        
        $controllerName = $parts[0];
        $actionName = $parts[1];
        array_splice($parts, 0, 2);
        $controllerClass = "\\controllers\\".ucfirst($controllerName).'Controller';
        $actionMethod = "action".ucfirst($actionName);
        $parameters = $parts;
        
        if (!class_exists($controllerClass) || !method_exists($controllerClass, $actionMethod))
        {
            http_response_code(404);
            return;
        }
        
        $controller = new $controllerClass($this->core, $controllerName, $actionName);
        
//        var_dump($parameters);
//        $reflection = new ReflectionMethod($controller, $actionMethod);
//        $actionRequiredParameters = $reflection->getParameters();
//        if (!empty($actionRequiredParameters)) {
//            $parameter = $actionRequiredParameters[0];
//            $type = $parameter->getType();
//            var_dump($type->getName());
//        }
        
        //$controller->$actionMethod($parameters);
        $controller->$actionMethod();
    }
}