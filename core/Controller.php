<?php

namespace core;

class Controller
{
    protected Core $core;
    protected Template $contentTmpl, $pageTmpl;
    
    public function __construct(Core $core, $controllerName, $actionName)
    {
        $this->core = $core;
        $this->contentTmpl = new Template("views/$controllerName/$actionName.php");
        
        $this->pageTmpl = new Template("layout/pageTmpl.php");
        $this->pageTmpl->title = "Default Title";
        $this->pageTmpl->styles = ['/lib/bootstrap/css/bootstrap.css'];
        $this->pageTmpl->scripts = ['/lib/bootstrap/js/bootstrap.js'];
        $this->pageTmpl->content = '';
    }
    
    protected function View()
    {
        $content = $this->contentTmpl->getOutput();
        
        $this->pageTmpl->content = $content;
        $this->pageTmpl->setParameters($this->contentTmpl->getParameters());
        $this->pageTmpl->render();
    }
    
    
}