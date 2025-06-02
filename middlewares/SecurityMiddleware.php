<?php

namespace middlewares;

use core\Middleware;

class SecurityMiddleware extends Middleware
{
    function loadSecurity()
    {
        $controllerName = $this->core->controllerName;
        $actionName = $this->core->actionName;
        
        $authFile = file_get_contents("configs/security.json");
        $authInfo = json_decode($authFile, true);
        
        $controllerAuthInfo = $authInfo['controllers'][$controllerName] ?? null;
        
        if ($controllerAuthInfo === null) {
            $this->controllerRole = null;
            $this->actionRole = null;
            return;
        }
        
        
        
        $controllerInfo = $controllersAuthInfo[$controllerName];
        $methodsAuthInfo = $controllersAuthInfo['actions'][$actionName];
        
        $controllerRole = $controllerInfo['auth'];
    }
    
    private string|null $controllerRole;
    private string|null $actionRole;
    
    public function handle()
    {
        $core = $this->core;
        $db = $core->DB;
        
        $controllerName = $core->controllerName;
        $actionName = $core->actionName;
        $class = $core->controllerClass;
        $method = $core->actionMethod;
        
        
        $userId = $_SESSION['userId'] ?? null;
        
        $user = null;
        if (isset($userId)) {
            $user = $db->selectFirst('users', where: "id='$userId'");
            if (!$user) unset($_SESSION['userId']);
        }
        $core->user = $user;
        
        
        //$this->loadSecurity();
        
        
        $controller = new $class($this->core);
        $controller->$method();
    }
}