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
            'pageIcon' => '/images/favicon.svg',
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
    
    protected function getJsonInput()
    {
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['status' => '400', 'message' => 'Invalid JSON format: ' . json_last_error_msg()]);
            return null;
        }
        return $input;
    }
    
}