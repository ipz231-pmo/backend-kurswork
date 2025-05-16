<?php

namespace controllers;

use core\Controller;
use core\Core;

class NewsController extends Controller
{
    public function __construct(Core $core, $controllerName, $actionName)
    {
        parent::__construct($core, $controllerName, $actionName);
    }
    
    public function actionIndex()
    {
        $page = $_GET["page"] ?? 1;
        $db = $this->core->DB;
            $newsTotal = $db->Select('news');
            $newsSpliced = $newsTotal;
            $newsSpliced = array_splice($newsSpliced, ($page - 1) * 5, 5);
        
        $this->contentTmpl->news = $newsSpliced;
        $this->contentTmpl->currentPage = $page;
        $this->contentTmpl->pagesCount = (int)(count($newsTotal) / 5);
        
        $this->View();
    }
    public function actionItem()
    {
        $id = $_GET['id'] ?? null;
        if ($id === null) {
            header('Location: /news');
        }
        
        $db = $this->core->DB;
        $new = $db->Select('news', where: "id = $id");
        if (empty($new))
            header('Location: /news');
        $this->contentTmpl->new = $new;
        $this->View();
    }
}