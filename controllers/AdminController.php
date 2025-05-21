<?php

namespace controllers;

use core\Controller;
use core\Core;

class AdminController extends Controller
{
    public function __construct(Core $core)
    {
        parent::__construct($core);
    }
    
    public function actionReadNews()
    {
        $db = $this->core->DB;
        $items = $db->select('news');
        $this->contentTmpl->items = $items;
        $this->View();
    }
    public function actionDeleteNew()
    {
        $id = $_GET['id'] ?? null;
        if (!is_numeric($id)) {
            http_response_code(400);
            return;
        }
        
        $db = $this->core->DB;
        $item = $db->select('news', where: "id = $id");
        if (empty($item)) {
            http_response_code(400);
            return;
        }
        $db->delete('news', where: "id = $id");
        header("Location: /admin/readNews");
    }
    public function actionUpdateNew()
    {
        $id = $_GET['id'] ?? null;
        if (!is_numeric($id)) {
            http_response_code(400);
            return;
        }
        $db = $this->core->DB;
        $items = $db->select('news', where: "id = $id");
        if (empty($items)) {
            http_response_code(400);
            return;
        }
        
        $this->contentTmpl->item = $items[0];
        $this->View();
    }
    
}