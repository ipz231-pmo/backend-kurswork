<?php

namespace core;

class Controller
{
    protected Core $core;
    protected Template $template;
    public function __construct(Core $core, $controllerName, $actionName)
    {
        $this->core = $core;
        $this->template = new Template("views/$controllerName/$actionName.php");
    }
    
    
}