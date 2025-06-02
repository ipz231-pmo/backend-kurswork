<?php

namespace core;

class Controller
{
    protected Core $core;
    protected Template $contentTmpl, $pageTmpl;
    
    public function __construct(Core $core)
    {
        $this->core = $core;
        
        // Aliases
        $db = $core->DB;
        $controllerName = $core->controllerName;
        $actionName = $core->actionName;
        
        $this->pageTmpl = new Template("layout/templates/page.php");
        $this->pageTmpl->title = "Auto Site";
        $this->pageTmpl->styles = [];
        $this->pageTmpl->scripts = [];
        $this->pageTmpl->content = '';
        $this->pageTmpl->
        
        $this->contentTmpl = new Template("views/$controllerName/$actionName.php");
        $this
        
        $headerCategories = $db->select('Categories');
        $this->pageTmpl->headerCategories = $headerCategories;
    }
    
    protected function View()
    {
        $content = $this->contentTmpl->getOutput();
        
        $contentParams = $this->contentTmpl->getParameters();
        
        if ($title = $contentParams["title"] ?? null)
            $this->pageTmpl->title = $title;
        if ($styles = $contentParams["styles"] ?? null)
            $this->pageTmpl->styles = array_merge($this->pageTmpl->styles, $styles);
        if ($scripts = $contentParams["scripts"] ?? null)
            $this->pageTmpl->scripts = array_merge($this->pageTmpl->scripts, $scripts);
            
        
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