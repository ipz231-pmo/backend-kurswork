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
            http_response_code(405);
            echo json_encode(['status' => '405', 'message' => 'Bad request method']);
            return;
        }

        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['status' => '400', 'message' => json_last_error_msg()]);
            return;
        }
        
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
        $user = $db->selectFirst('users', where: "email = '{$email}' and password = '{$password}'");
        if ($user === null) {
            http_response_code(400);
            echo json_encode(['status' => '400', 'message' => 'Invalid email or password']);
            return;
        }
        
        $_SESSION['userId'] = $user['id'];
        echo json_encode(['status' => '200', 'message' => 'Login success']);
    }
    
    
    public function actionLogout(){
        $core = $this->core;
        $db = $core->DB;
        
        unset($_SESSION['userId']);
        echo json_encode(['status' => '200', 'message' => 'Logout success']);
    }
    
}