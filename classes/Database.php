<?php

class Database {
    private $server = 'localhost';
    private $username = 'php';
    private $password = 'php';
    private $dbName = 'bookcatalog';
    
    protected function connect() {
      
            $dsn = 'mysql:host='. $this->server . ';dbname=' . $this->dbName;
            $conn = new PDO($dsn, $this->username, $this->password);
            $conn ->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $conn;
   }
}
