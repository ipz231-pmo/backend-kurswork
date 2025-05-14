<?php

namespace core;

use PDO;

class DB
{
    private PDO $pdo;
    private Core $core;
    
    public function __construct(Core $core)
    {
        $this->core = $core;
    }
    
    public function init()
    {
        $username = 'backend-kurswork-user';
        $password = 'kzz@MgCTO0Eh7wyE';
        $host = 'localhost';
        $database = 'backend-kurswork-db';
        
        $this->pdo = new PDO("mysql:host=$host;dbname=$database", "$username", "$password");
    }
    
    public function getPdo() : PDO {
        return $this->pdo;
    }
    
    public function Select(string $table, string|array $fields = "*", string|array|null $where = null)
    {
        if (is_array($fields)) {
            $fieldsString = implode(',', $fields);
        } else if(is_string($fields)) {
            $fieldsString = $fields;
        } else {
            $fieldsString = '*';
        }
        
        if (is_array($where)) {
            $whereString = implode('AND', $where);
        } else if(is_string($where)) {
            $whereString = $where;
        } else {
            $whereString = '';
        }
        
        $sql = "SELECT $fieldsString FROM $table WHERE $whereString";
        $prep = $this->pdo->prepare($sql);
        $prep->execute();
        return $prep->fetchAll(PDO::FETCH_ASSOC);
        // DELETE FROM employees WHERE id=1;
    }
    public function Delete(string $table, string $where = "FALSE")
    {
        $sql = "DELETE FROM $table WHERE $where";
        $prep = $this->pdo->prepare($sql);
        $prep->execute();
    }
    public function Insert(string $table, array $data)
    {
    
    }
    public function Update(string $table, array|string $fields, string $where = "FALSE")
    {
        $sql = "UPDATE $table SET $fields WHERE $where";
    }
}