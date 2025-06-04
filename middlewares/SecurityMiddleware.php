<?php

namespace middlewares;

use core\Middleware;
use Exception;

class SecurityMiddleware extends Middleware
{
    private array $securityConfig;
    public function __construct($core)
    {
        parent::__construct($core);
        $this->loadSecurityConfig();
        
    }
    private function loadSecurityConfig(): void
    {
        $authFile = "configs/security.json";
        if (!file_exists($authFile))
            throw new Exception("Config file doesn't exist");
        $this->securityConfig = json_decode(file_get_contents($authFile), true)['controllers'] ?? [];
    }
    
    private function getRequiredRole(): string
    {
        $controllerName = $this->core->controllerName;
        $actionName = $this->core->actionName;
        
        $controllerRules = $this->securityConfig[$controllerName] ?? null;
        
        if (isset($controllerRules['actions'][$actionName]['access'])) {
            return $controllerRules['actions'][$actionName]['access'];
        }
        
        if (isset($controllerRules['default_access']) && $controllerRules['default_access'] ) {
            return $controllerRules['default_access'];
        }
        
        return 'guest';
    }
    
    private function getCurrentUserRole(): string
    {
        return $this->core->user['role'] ?? 'guest';
    }
    
    private function checkAccess(string $requiredRole, string $userRole): bool
    {
        if ($requiredRole === 'guest')
            return true;
        
        if ($requiredRole === 'user')
            return ($userRole === 'user' || $userRole === 'admin');
        
        if ($requiredRole === 'admin')
            return ($userRole === 'admin');
        
        return false; // Deny by default if role is unknown
    }
    
    public function handle() : void
    {
        $core = $this->core;
        $db = $core->DB;
        
        $userId = $_SESSION['userId'] ?? null;
        $user = null;
        if (isset($userId))
            $user = $db->selectFirst('users', ['id', 'email', 'role'], "id = '$userId'");
        if (!$user)
            unset($_SESSION['userId']);
        
        $core->user = $user;
        
        $requiredRole = $this->getRequiredRole();
        $currentUserRole = $this->getCurrentUserRole();
        
        if (!$this->checkAccess($requiredRole, $currentUserRole))
        {
            // Access denied
            if ($currentUserRole === 'guest' && ($requiredRole === 'user' || $requiredRole === 'admin')) {
                // Guest trying to access a protected route, redirect to login
                http_response_code(401); // Unauthorized
                header("Location: /profile/login?redirect=" . urlencode($_GET['route'] ?? '/'));
                exit;
            } else {
                // Logged-in user trying to access a route they don't have permission for
                http_response_code(403);
                return;
            }
        }
        
        $this->next?->handle();
    }
}