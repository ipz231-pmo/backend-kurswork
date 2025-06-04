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
    
    public function actionLogin(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            echo json_encode(['status' => '400', 'message' => 'Bad request method']);
            exit;
        }

        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['status' => '400', 'message' => json_last_error_msg()]);
            exit;
        }
        
        if (!isset($input['email']) || !isset($input['password'])) {
            http_response_code(400);
            echo json_encode(['status' => '400', 'message' => 'Missing credentials']);
            exit;
        }
        
        $email = trim($input['email']);
        $password = trim($input['password']);
        
        if (empty($email) || empty($password)) {
            http_response_code(400);
            echo json_encode(['status' => '400', 'message' => 'Missing credentials']);
            exit;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['status' => '400', 'message' => 'Invalid email syntax']);
            exit;
        }
        
        $db = $this->core->DB;
        $user = $db->selectFirst('users', where: "email = '{$email}' and password = '{$password}'");
        if ($user === null) {
            http_response_code(400);
            echo json_encode(['status' => '400', 'message' => 'Invalid email or password']);
            die;
        }
        $_SESSION['userId'] = $user['id'];
        http_response_code(200);
        echo json_encode(['status' => '200', 'message' => 'Login success']);
        
        
        
            //sendJsonResponse(['error' => 'Invalid request method. Only POST is allowed.'], 405);
            //sendJsonResponse(['error' => 'Invalid JSON payload.'], 400);
            //sendJsonResponse(['error' => 'Email and password cannot be empty.'], 400);
            //sendJsonResponse(['error' => 'Invalid email format.'], 400);
            //sendJsonResponse(['error' => 'Missing email or password.'], 400);
    }
    
    
    public function actionLogout(){
        $core = $this->core;
        $db = $core->DB;
        
        unset($_SESSION['userId']);
        header("Location: /");
    }
    
}