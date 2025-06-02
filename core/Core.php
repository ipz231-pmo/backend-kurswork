<?php

namespace core;

class Core
{
    private Middleware|null $firstMiddleware, $lastMiddleware;
    public string $controllerName, $actionName, $controllerClass, $actionMethod;
    public array $parameters;
    public array|null $user;
    public DB $DB;
    
    public function __construct()
    {
        $this->DB = new DB($this);
    }
    
    public function init(): void
    {
        session_start();
        $this->DB->init();
    }
    
    public function useMiddleware(Middleware $middleware) : void
    {
        if(isset($this->lastMiddleware))
            $this->lastMiddleware->setNext($middleware);
        $this->lastMiddleware = $middleware;
        if (empty($this->firstMiddleware))
            $this->firstMiddleware = $middleware;
    }
    public function run() : void
    {
        $this->firstMiddleware->handle();
    }
    public function renderErrorPage($code, $message)
    {
        $debugEnabled = true;
        $pagePath = "layout/default_pages/error_{$code}.php";
        if (file_exists($pagePath))
        {
            $tmpl = new Template($pagePath);
            if ($debugEnabled)
                $tmpl->message = $message;
            $content = $tmpl->getOutput();
        }
        else
        {
            $content = "<h1>Error -> $code</h1>";
            if ($debugEnabled)
                $content .= "<p>$message</p>";
        }
        
        $pageTmpl = new Template("layout/templates/page.php");
        $pageTmpl->title = "Error {$code}";
        $pageTmpl->styles = [];
        $pageTmpl->scripts = [];
        $pageTmpl->content = $content;
        $pageTmpl->render();
    }
}