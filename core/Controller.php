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
        
        $this->pageTmpl = new Template("layout/templates/page.php");
        $this->pageTmpl->title = "Default Title";
        $this->pageTmpl->styles = ['/lib/bootstrap/css/bootstrap.css'];
        $this->pageTmpl->scripts = ['/lib/bootstrap/js/bootstrap.js'];
        $this->pageTmpl->content = '';
    }
    
    protected function View()
    {
        $content = $this->contentTmpl->getOutput();
        
        $contentParams = $this->contentTmpl->getParameters();
        
        $layout = $contentParams['layout'] ?? null;
        
        if ($layout) {
            $path = "layout/templates/$layout.php";
            $this->pageTmpl->setTemplatePath(str_replace($path, '/', DIRECTORY_SEPARATOR));
        }
        
        $this->pageTmpl->content = $content;
        $this->pageTmpl->setParameters($contentParams);
        $this->pageTmpl->render();
        
        
        
    }
    
    
}