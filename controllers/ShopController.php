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
    
    public function actionPlaceOrder()
    {
        $this->View();
    }
    
    public function actionPlaceOrderAsync()
    {
        
    }
    
    
    public  function actionIndex()
    {
        $db = $this->core->DB;
        $pdo = $db->getPDO();
        
        $categoryUrlName = $_GET['category'] ?? null;
        $sortMethod = $_GET['sort'] ?? "rating";
        $minPrice = $_GET['minPrice'] ?? null;
        $maxPrice = $_GET['maxPrice'] ?? null;
        $currentPage = $_GET['page'] ?? 1;
        
        if(!is_numeric($currentPage)) {
            $currentPage = 1;
        }
        if ($categoryUrlName === null) {
            http_response_code(404);
            return;
        }
        $category = $db->selectFirst(table: "categories",  where: "urlName = '$categoryUrlName'") ?? null;
        if ($category === null) {
            http_response_code(404);
            return;
        }
        
        if (!in_array($sortMethod, ["cheap", "expensive", "rating"])) {
            $sortMethod = "rating";
        }
        if ($sortMethod === "rating")
        {
            $sortStr = "";
        }
        else if ($sortMethod === "cheap" || $sortMethod === "expensive")
        {
            $sortStr = "ORDER BY price";
            if ($sortMethod === "expensive")
                $sortStr .= " DESC";
        }
        
        if ($minPrice !== null && !is_numeric($minPrice))
        {
            http_response_code(404);
            return;
        }
        if ($maxPrice !== null && !is_numeric($maxPrice))
        {
            http_response_code(404);
            return;
        }
        $minWhere = empty($minPrice) ? "" : " AND price >= $minPrice";
        $maxWhere = empty($maxPrice) ? "" : " AND price <= $maxPrice";
        
        

        
        $sql = "
                    SELECT g.id, g.name, g.description, g.price, g.imageUrl
                    FROM goods g
                    INNER JOIN goodscategories gc on g.id = gc.goodId
                    WHERE gc.categoryId = {$category['id']} $minWhere $maxWhere
                    $sortStr";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $pagesCount = ceil($stmt->rowCount() / 5);
        $itemsCount = count($items);
        
        $items = array_slice($items, ($currentPage - 1) * 5, 5);
        
        $this->contentTmpl->items = $items;
        $this->contentTmpl->itemsCount = $itemsCount;
        $this->contentTmpl->category = $category;
        $this->contentTmpl->sort = $sortMethod;
        $this->contentTmpl->minPrice = $minPrice;
        $this->contentTmpl->maxPrice = $maxPrice;
        $this->contentTmpl->pagesCount = $pagesCount;
        $this->contentTmpl->currentPage = $currentPage;
        $this->contentTmpl->user = $this->core->user;
        
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
        $core = $this->core;
        $user = $core->user;
        $db = $core->DB;
        $pdo = $db->getPDO();
        $tmpl = $this->contentTmpl;
        
        // Input
        $id = $_GET['id'] ?? null;
        
        // Output
        $item = null;
        $category = null;
        $cartHasItem = false;
        
        // Item
        if (!is_numeric($id) || !($item = $db->selectFirst("goods", where: "id = $id"))) {
            http_response_code(404);
            return;
        }
        $tmpl->item = $item;
        
        // Fetch category for breadcrumbs
        $sql = "SELECT c.id, c.name, c.description, c.urlName, c.iconPath
                FROM goods g
                JOIN goodscategories gc ON g.id = gc.goodId
                JOIN categories c ON gc.categoryId = c.id
                WHERE g.id = ?
                LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        $tmpl->category = $category;
        
        // Cart has item?
        if ($user !== null) {
            $sql = "SELECT cg.goodId
                    FROM cartgoods cg
                    JOIN users u ON cg.userId = u.id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $cartItems = array_column($cartItems, 'goodId');
            $cartHasItem = in_array($item['id'], $cartItems);
        }
        $this->contentTmpl->cartHasItem = $cartHasItem;
        
        $tmpl->user = $core->user;
        $this->View();
    }
    public function actionCart()
    {
        header('Content-Type: application/json');
        
        $core = $this->core;
        $user = $core->user;
        $db = $core->DB;
        $pdo = $db->getPDO();
        
        if ($user === null) {
            http_response_code(403);
            echo json_encode(['status' => 'user are not authorized', 'content' => '<div class="h5">User are not authorized</div>']);
            return;
        }
        
        $sql = "SELECT g.id, g.name, g.price, g.imageUrl, cg.goodQuantity
                FROM cartgoods cg JOIN goods g ON cg.goodId = g.id
                WHERE cg.userId = ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user['id']]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $this->contentTmpl->items = $cartItems;
        $content = $this->contentTmpl->getOutput();
        
        echo json_encode(['status' => 'success', 'content' => $content]);
    }
    
    
    public function actionAddToCart()
    {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => '405', 'message' => 'Method Not Allowed']);
            return;
        }
        
        $input = $this->getJsonInput();
        if ($input === null) return;
        
        $goodId = $input['goodId'] ?? null;
        $quantity = $input['quantity'] ?? 1;
        $userId = $_SESSION['userId'];
        
        if (!is_numeric($goodId) || !is_numeric($quantity) || $quantity <= 0) {
            http_response_code(400);
            echo json_encode(['status' => '400', 'message' => 'Invalid input: goodId and quantity are required and must be numeric.']);
            return;
        }
        
        $db = $this->core->DB;
        $pdo = $db->getPDO();
        
        // Check if item exists in cart
        $stmt = $pdo->prepare("SELECT * FROM cartgoods WHERE userId = ? AND goodId = ?");
        $stmt->execute([$userId, $goodId]);
        $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($existingItem) {
            $updateStmt = $pdo->prepare("UPDATE cartgoods SET goodQuantity = ? WHERE id = ?");
            $success = $updateStmt->execute([$quantity, $existingItem['id']]);
        } else {
            $insertStmt = $pdo->prepare("INSERT INTO cartgoods (userId, goodId, goodQuantity) VALUES (?, ?, ?)");
            $success = $insertStmt->execute([$userId, $goodId, $quantity]);
        }
        
        if ($success) {
            echo json_encode(['status' => '200', 'message' => 'Item added to cart.']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => '500', 'message' => 'Failed to add item to cart.']);
        }
    }
    
    public function actionRemoveFromCart()
    {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => '405', 'message' => 'Method Not Allowed']);
            return;
        }
        
        $input = $this->getJsonInput();
        if ($input === null) return;
        
        $goodId = $input['goodId'] ?? null;
        $userId = $_SESSION['userId'];
        
        if (!is_numeric($goodId)) {
            http_response_code(400);
            echo json_encode(['status' => '400', 'message' => 'Invalid input: goodId is required.']);
            return;
        }
        
        $db = $this->core->DB;
        $pdo = $db->getPDO();
        
        $stmt = $pdo->prepare("DELETE FROM cartgoods WHERE userId = ? AND goodId = ?");
        $success = $stmt->execute([$userId, $goodId]);
        
        if ($success) {
            echo json_encode(['status' => '200', 'message' => 'Item removed from cart.']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => '500', 'message' => 'Failed to remove item from cart.']);
        }
    }
    
    
    private function getJsonInput()
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