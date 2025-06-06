<?php

namespace middlewares;

use core\Middleware;
use core\Template;
use ErrorException;
use Throwable;

class ErrorMiddleware extends Middleware
{
    private array $errorConfig;
    public function __construct($core)
    {
        parent::__construct($core);
        $this->errorConfig = $this->getConfig();
    }
    
    private function getConfig() : array
    {
        $filename = "configs/error_middleware.json";
        if (!file_exists($filename))
            throw new ErrorException("Error configuration file not found");
        return json_decode(file_get_contents($filename), true);
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
        
        $defaultErrorPage = $this->isShownDefaultClientErrorPage();
        
        
        $code = http_response_code();
        if ($code >= 500 && $code <= 599)
            $this->core->renderErrorPage($code, $errorMsg);
        if ($code >= 400 && $code <= 499) {
            $this->handleClientErrors($code, $defaultErrorPage);
        }
    }
    
    private function handleClientErrors(int $code, bool $defaultErrorPage) : void
    {
        if (!$defaultErrorPage ||  $code == 404) {
            $this->core->renderErrorPage($code, "Client error");
        }
    }
    
    private function isShownDefaultClientErrorPage() : bool
    {
        $core = $this->core;
        
        $noDefaultPageConfig = $this->errorConfig["no_client_error_page"];
        $controllerRules = $noDefaultPageConfig["controllers"][$core->controllerName] ?? null;
        
        if ($controllerRules === null)
            return true;
        
        if (isset($controllerRules["actions"][$core->actionName]))
            return false;
        
        return true;
    }
    
}