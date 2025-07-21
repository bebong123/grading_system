<?php
namespace Flores\Gs\Core;
use mysqli;

class Database{
    protected $conn;

    public function __construct(){

        $host = 'localhost';
        $db = 'opp_flores';
        $user = 'root';
        $pass = '';
        //mysqli connection
    $this->conn = new mysqli ($host,$user,$pass,$db);
    if($this->conn->connect_error){
        die("connection failed:".$this->conn->connect_error);

    }  
  }



}

?>