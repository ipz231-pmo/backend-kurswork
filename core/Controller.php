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
        
        $pageParameters = [
            'title' => "Auto Site",
            'styles' => [],
            'scripts' => [],
            'content' => '',
            'pageIcon' => 'images/favicon.svg',
            'headerCategories' => $db->select('Categories'),
            'user' => $core->user,
        ];
        
        $this->pageTmpl = new Template("layout/templates/page.php");
        $this->pageTmpl->setParameters($pageParameters);
        
        $this->contentTmpl = new Template("views/$controllerName/$actionName.php");
        $this->contentTmpl->setParameters($pageParameters);
        
    }
    
    protected function View()
    {
        $content = $this->contentTmpl->getOutput();
        $contentParameters = $this->contentTmpl->getParameters();
        
        $layout = $contentParameters['layout'] ?? null;
        if ($layout) {
            $path = "layout/templates/$layout.php";
            $this->pageTmpl->setTemplatePath(str_replace($path, '/', DIRECTORY_SEPARATOR));
        }
        
        $contentParameters['content'] = $content;
        $this->pageTmpl->setParameters($contentParameters);
        $this->pageTmpl->render();
    }
    protected function BareView()
    {
        $this->contentTmpl->render();
    }
}