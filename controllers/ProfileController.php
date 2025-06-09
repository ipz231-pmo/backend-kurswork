<?php

namespace controllers;

use core\Controller;
use core\Core;
use PDO;

class ProfileController extends Controller
{
    public function __construct(Core $core)
    {
        parent::__construct($core);
    }
    
    public function actionIndex()
    {
        $core = $this->core;
        $user = $core->user;
        $pdo = $core->DB->getPDO();
        $tmpl = $this->contentTmpl;
        
        if ($user === null) {
            header("Location: /");
            exit();
        }
        
        
        
        $sql = "SELECT * FROM orders WHERE userId = :userId";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['userId' => $user['id']]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $tmpl->orders = $orders;
        
        $this->contentTmpl->title = 'My Profile';
        $this->contentTmpl->currentUser = $this->core->user;
        $this->contentTmpl->scripts = ['/js/profile.js'];
        $this->View();
    }
    
    
    public function actionRegisterAsync()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => '405', 'message' => 'Bad request method']);
            return;
        }
        
        $input = $this->getJsonInput();
        if ($input === null) return;
        
        // --- Validation ---
        $required = ['name', 'familyName', 'email', 'password'];
        foreach ($required as $field) {
            if (empty($input[$field])) {
                http_response_code(400);
                echo json_encode(['status' => '400', 'message' => "Missing required field: {$field}"]);
                return;
            }
        }
        
        $email = trim($input['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['status' => '400', 'message' => 'Invalid email format.']);
            return;
        }
        
        // Check if email already exists
        $pdo = $this->core->DB->getPDO();
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            http_response_code(409); // Conflict
            echo json_encode(['status' => '409', 'message' => 'An account with this email already exists.']);
            return;
        }
        
        // --- Insertion ---
        $hashedPassword = password_hash(trim($input['password']), PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (name, familyName, email, password, role) VALUES (?, ?, ?, ?, ?)";
        $params = [
            trim($input['name']),
            trim($input['familyName']),
            $email,
            $hashedPassword,
            'user'
        ];
        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute($params);
        
        if ($success) {
            $_SESSION['userId'] = $pdo->lastInsertId();
            echo json_encode(['status' => '200', 'message' => 'Registration successful.']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => '500', 'message' => 'Could not register user.']);
        }
    }
    
    public function actionUpdateAsync()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => '405', 'message' => 'Bad request method']);
            return;
        }
        
        if (!isset($_SESSION['userId'])) {
            http_response_code(401);
            echo json_encode(['status' => '401', 'message' => 'You must be logged in to update your profile.']);
            return;
        }
        $userId = $_SESSION['userId'];
        
        $input = $this->getJsonInput();
        if ($input === null) return;
        if (empty($input)) {
            http_response_code(400);
            echo json_encode(['status' => '400', 'message' => 'No update data provided.']);
            return;
        }
        
        $pdo = $this->core->DB->getPDO();
        $setClauses = [];
        $params = [];
        
        // Dynamically build the query based on provided input
        $allowedFields = ['name', 'familyName', 'email', 'password', 'phone', 'mailIndex'];
        foreach ($allowedFields as $field) {
            if (isset($input[$field])) {
                $value = trim($input[$field]);
                if (empty($value) && $field !== 'phone' && $field !== 'mailIndex') continue; // Don't set required fields to empty
                
                // Special validation for email
                if ($field === 'email') {
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        http_response_code(400);
                        echo json_encode(['status' => '400', 'message' => 'Invalid email format.']);
                        return;
                    }
                    // Check if email is taken by ANOTHER user
                    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
                    $stmt->execute([$value, $userId]);
                    if ($stmt->fetch()) {
                        http_response_code(409);
                        echo json_encode(['status' => '409', 'message' => 'This email is already in use by another account.']);
                        return;
                    }
                }
                
                $setClauses[] = "$field = ?";
                if ($field === 'password') {
                    $params[] = password_hash($value, PASSWORD_DEFAULT);
                } elseif ($field === 'mailIndex') {
                    $params[] = is_numeric($value) ? (int)$value : null;
                } else {
                    $params[] = $value;
                }
            }
        }
        
        if (empty($setClauses)) {
            http_response_code(400);
            echo json_encode(['status' => '400', 'message' => 'No valid update data provided.']);
            return;
        }
        
        $sql = "UPDATE users SET " . implode(', ', $setClauses) . " WHERE id = ?";
        $params[] = $userId;
        
        $stmt = $pdo->prepare($sql);
        $success = $stmt->execute($params);
        
        if ($success) {
            echo json_encode(['status' => '200', 'message' => 'Profile updated successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => '500', 'message' => 'Failed to update profile.']);
        }
    }
    
    
    public function actionLogin(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => '405', 'message' => 'Bad request method']);
            return;
        }
        
        $input = $this->getJsonInput();
        if ($input === null) return;
        
        if (!isset($input['email']) || !isset($input['password'])) {
            http_response_code(400);
            echo json_encode(['status' => '400', 'message' => 'Missing credentials']);
            return;
        }
        
        $email = trim($input['email']);
        $password = trim($input['password']);
        
        if (empty($email) || empty($password)) {
            http_response_code(400);
            echo json_encode(['status' => '400', 'message' => 'Missing credentials']);
            return;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['status' => '400', 'message' => 'Invalid email syntax']);
            return;
        }
        
        
        $db = $this->core->DB;
        $pdo = $db->getPdo();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['userId'] = $user['id'];
            echo json_encode(['status' => '200', 'message' => 'Login success']);
        } else {
            http_response_code(401); // Unauthorized
            echo json_encode(['status' => '401', 'message' => 'Invalid email or password']);
        }
    }
    
    public function actionLogout(){
        unset($_SESSION['userId']);
        header("Content-type: application/json");
        echo json_encode(['status' => '200', 'message' => 'Logout success']);
    }
    
    // profile/index (profile page)
    // profile/register (registration page)
    
}