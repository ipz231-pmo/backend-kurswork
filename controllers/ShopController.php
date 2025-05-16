<?php

namespace controllers;

use core\Controller;
use core\Core;

class ShopController extends Controller
{
    public function __construct(Core $core, $controllerName, $actionName)
    {
        parent::__construct($core, $controllerName, $actionName);
    }
    
    public function actionAll()
    {
        $db = $this->core->DB;
        $items = $db->select("goods");
        $this->contentTmpl->items = $items;
        $this->View();
    }
    public function actionItem()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            return;
        }
        
        $db = $this->core->DB;
        $item = $db->select("goods", where: "id = $id");
        if (!$item) {
            http_response_code(404);
            return;
        }
        $item = $item[0];
        $this->contentTmpl->item = $item;
        $this->View();
    }
}