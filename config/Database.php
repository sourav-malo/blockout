<?php
  class Database {
    // DB Params
    // private $host = 'localhost';
    // private $db_name = 'gamearea_cubeout';
    // private $username = 'root';
    // private $password = '';
    // private $conn;
    // private $host = 'localhost';
    // private $db_name = 'souravma_blockout';
    // private $username = 'souravma_blockout';
    // private $password = 'souravma_blockout';
    // private $conn;
    private $host = 'localhost';
    private $db_name = 'gamerea_cubeoutt';
    private $username = 'gamerea_cubeout';
    private $password = 'cubeoutmagi';
    // private $conn;

    // DB Connect
    public function connect() {
      $this->conn = null;

      try {
        $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection Error: '.$e->getMessage();
      }

      return $this->conn;
    }
  }
?>