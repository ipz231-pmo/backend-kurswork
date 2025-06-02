<?php

namespace controllers;

use core\Controller;
use core\Core;

class NewsController extends Controller
{
    public function __construct(Core $core)
    {
        parent::__construct($core);
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
        $this->contentTmpl->pagesCount = ceil(count($newsTotal) / 5);
        
        $this->View();
    }
    public function actionItem()
    {
        $db = $this->core->DB;
        $tmpl = $this->contentTmpl;
        
        $id = $_GET['id'] ?? null;
        if ($id === null) {
            http_response_code(404);
            return;
        }
        
        $item = $db->selectFirst('news', where: "id = $id");
        if ($item === null)
        {
            http_response_code(404);
            return;
        }
        $tmpl->item = $item;
        $this->View();
    }
}