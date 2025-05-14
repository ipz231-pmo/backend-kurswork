<?php

namespace middlewares;

use core\Middleware;
use core\Template;
use Throwable;

class ErrorMiddleware extends Middleware
{
    public function __construct($core)
    {
        parent::__construct($core);
    }
    
    public function handle() : void
    {
        $errorMsg = null;
        try {
            $this?->next->handle();
        } catch (Throwable $e) {
            http_response_code(500);
            $errorMsg = "Internal server error: {$e->getMessage()}";
        }
        
        $code = http_response_code();
        if ($code >= 400 && $code <= 599)
            $this->core->renderErrorPage($code, $errorMsg);
    }
}