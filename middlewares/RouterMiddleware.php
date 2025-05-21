<?php

namespace middlewares;

use core\Middleware;
use ReflectionMethod;

class RouterMiddleware extends Middleware
{
    
    public function handle()
    {
        $core = $this->core;
        
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
        
        $core->controllerName = $controllerName;
        $core->actionName = $actionName;
        $core->controllerClass = $controllerClass;
        $core->actionMethod = $actionMethod;
        $core->parameters = $parameters;
        
        $this->next?->handle();
    }
}