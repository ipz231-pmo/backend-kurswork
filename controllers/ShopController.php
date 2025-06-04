<?php

namespace controllers;

use core\Controller;
use core\Core;
use PDO;

class ShopController extends Controller
{
    public function __construct(Core $core)
    {
        parent::__construct($core);
    }
    
    public  function actionIndex()
    {
        $categoryUrlName = $_GET['category'] ?? null;
        if ($categoryUrlName === null) { // Пішов за чайом, надовго (20 хв)
            http_response_code(404);
            return;
        }
        
        $db = $this->core->DB;
        $pdo = $db->getPDO();
        
        $category = $db->selectFirst(table: "categories",  where: "urlName = '$categoryUrlName'") ?? null;
        if ($category === null) {
            http_response_code(404);
            return;
        }
        
        $sql = "SELECT g.id, g.name, g.description, g.price, g.imageUrl FROM goods g INNER JOIN goodscategories gc on g.id = gc.goodId WHERE gc.categoryId = {$category['id']}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        
        $this->contentTmpl->items = $items;
        $this->contentTmpl->category = $category;
        $this->View();
    }
    
    public function actionCatalog()
    {
        $db = $this->core->DB;
        $items = $db->select("categories");
        $this->contentTmpl->items = $items;
        $this->View();
    }
    public function actionItem()
    {
        $db = $this->core->DB;
        $pdo = $db->getPDO();
        $tmpl = $this->contentTmpl;
        
        $id = $_GET['id'] ?? null;
        if ($id === null) {
            http_response_code(404);
            return;
        }
        
        $item = $db->selectFirst("goods", where: "id = $id");
        if ($item === null) {
            http_response_code(404);
            return;
        }
        $tmpl->item = $item;
        $this->View();
    }
    public function actionCart()
    {
        $this->BareView();
    }
}