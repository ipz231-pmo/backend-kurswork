<?php

namespace middlewares;

use core\Middleware;

class AuthenticationMiddleware extends Middleware
{
    public function __construct($core)
    {
        parent::__construct($core);
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
        
        $this->next?->handle();
    }
}