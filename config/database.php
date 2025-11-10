<?php

class Database
{

        private $localhost = 'localhost';
        private $username = 'root';
        private $password = '';
        private $dbname = 'php_crud';
        private $connection;

    public function connect(){
        
        try{
            $this->connection = new PDO
            ("mysql:host={$this->localhost}; dbname={$this->dbname}", $this->username, $this->password);
          
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection;
            
        }catch(PDOException $e){
            die('Database connection error failed ' . $e->getMessage());
        }
    
    }
}

// $db = new Database;
// $conn = $db->connect();

// if($conn){
//     echo"connected";
// }else{
//     echo "error";
// }