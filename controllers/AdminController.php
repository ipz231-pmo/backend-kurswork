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
    
    
    public function actionNews() : void
    {
        $user = $this->core->user;
        if (($user['role'] ?? 'guest') !== 'admin') { http_response_code(403); return; }
        
        $this->contentTmpl->items = $this->core->DB->select('news');
        $this->contentTmpl->title = 'Manage News';
        $this->View();
    }
    public function actionCreateNewsAsync() : void
    {
        header('Content-Type: application/json');
        
        if (!$this->checkAccess())  return;
        if (!($input = $this->getJsonInput())) return;
        
        $title = $input['title'] ?? null;
        $shortText = $input['shortText'] ?? null;
        $text = $input['text'] ?? null;
        
        if (!is_string($title) || !is_string($shortText) || !is_string($text))
        {
            $this->jsonResponse(400, "Missing required parameters or parameters have wrong format");
            return;
        }
        
        $pdo = $this->core->DB->getPDO();
        $sql = "INSERT INTO news (title, shortText, text) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute([$title, $shortText, $text]);
        
        if ($success)
            $this->jsonResponse(200, 'News item created successfully.');
        else
            $this->jsonResponse(500, 'Failed to create news item.');
    }
    public function actionUpdateNewsAsync() : void
    {
        header('Content-Type: application/json');
        
        if (!$this->checkAccess()) return;
        if (!($input = $this->getJsonInput())) return;
        
        $id = $input['id'] ?? null;
        
        if (!is_numeric($id)) {
            $this->jsonResponse(400, 'Valid ID is required.');
            return;
        }
        
        $pdo = $this->core->DB->getPDO();
        $sql = "UPDATE news SET title = ?, shortText = ?, text = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute([
                                      trim($input['title'] ?? ''),
                                      trim($input['shortText'] ?? ''),
                                      trim($input['text'] ?? ''),
                                      $id
                                  ]);
        
        if ($success)
            $this->jsonResponse(200, 'News item updated successfully.');
        else
            $this->jsonResponse(500, 'Failed to update news item.');
    }
    public function actionDeleteNewsAsync() : void
    {
        header('Content-Type: application/json');
        
        if (!$this->checkAccess()) return;
        if (!($input = $this->getJsonInput())) return;
        
        $id = $input['id'] ?? null;
        
        if (!is_numeric($id)) {
            $this->jsonResponse(400, 'A valid ID is required.');
            return;
        }
        
        $this->core->DB->delete('news', "id = $id");
        $this->jsonResponse(200, 'News item deleted successfully.');
    }
    
    public function actionGoods()
    {
        $user = $this->core->user;
        if (($user['role'] ?? 'guest') !== 'admin') { http_response_code(403); return; }
        
        $this->contentTmpl->items = $this->core->DB->select('goods');
        $this->contentTmpl->title = 'Manage Goods';
        $this->View();
    }
    public function actionCreateGoodsAsync() : void
    {
        header('Content-Type: application/json');
        
        if (!$this->checkAccess())  return;
        if (!($input = $this->getJsonInput())) return;
        
        $name = $input['name'] ?? null;
        $description = $input['description'] ?? null;
        $price = $input['price'] ?? null;
        $imageUrl = $input['imageUrl'] ?? null;
        
        if (!is_string($name) || !is_string($description) || !is_string($imageUrl) || !is_numeric($price))
        {
            $this->jsonResponse(400, "Missing required parameters or parameters have wrong format");
            return;
        }
        
        $pdo = $this->core->DB->getPDO();
        $sql = "INSERT INTO goods (name, description, price, imageUrl) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute([$name, $description, $price, $imageUrl]);
        
        if ($success)
            $this->jsonResponse(200, 'Goods item created successfully.');
        else
            $this->jsonResponse(500, 'Failed to create goods item.');
    }
    
    
    public function actionUpdateGoodsAsync() : void
    {
        header('Content-Type: application/json');
        
        if (!$this->checkAccess()) return;
        if (!($input = $this->getJsonInput())) return;
        
        $id = $input['id'] ?? null;
        
        if (!is_numeric($id) || !is_numeric($input['price'])) {
            $this->jsonResponse(400, 'Valid ID is required.');
            return;
        }
        
        $pdo = $this->core->DB->getPDO();
        $sql = "UPDATE goods SET name = ?, description = ?, price = ?, imageUrl = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute([
                                      trim($input['name'] ?? ''),
                                      trim($input['description'] ?? ''),
                                      trim($input['price'] ?? ''),
                                      trim($input['imageUrl'] ?? ''),
                                      $id
                                  ]);
        
        if ($success)
            $this->jsonResponse(200, 'Goods item updated successfully.');
        else
            $this->jsonResponse(500, 'Failed to update goods item.');
    }
    public function actionDeleteGoodsAsync() : void
    {
        header('Content-Type: application/json');
        
        if (!$this->checkAccess()) return;
        if (!($input = $this->getJsonInput())) return;
        
        $id = $input['id'] ?? null;
        
        if (!is_numeric($id)) {
            $this->jsonResponse(400, 'A valid ID is required.');
            return;
        }
        
        $this->core->DB->delete('goods', "id = $id");
        $this->jsonResponse(200, 'Goods item deleted successfully.');
    }
    
    
    
    
    private function jsonResponse(int $status, string $message, array $data = [])
    {
        http_response_code($status);
        $response['status'] = $status;
        $response['message'] = $message;
        $response['data'] = $data;
        echo json_encode($response);
    }
    private function checkAccess() : bool
    {
        if ($this->core->user !== null && $this->core->user['role'] === 'admin') {
            return true;
        }
        $this->jsonResponse(403, 'Access denied.');
        return false;
    }
    protected function getJsonInput() : array|null {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(405, 'Method Not Allowed');
            return null;
        }
        
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->jsonResponse(400, "Invalid JSON format: ".json_last_error_msg());
            return null;
        }
        return $input;
    }
}