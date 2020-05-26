<?php
class Account{
  
    // database connection and table name
    private $conn;
    private $table_name = "acc";
  
    // object properties
    public $Account;
    public $Password;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // create product
    function create(){

        // query to insert record
        $query = "SELECT * FROM " . $this->table_name . " WHERE Account = :Account";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->Account=htmlspecialchars(strip_tags($this->Account));
    
        // bind new values
        $stmt->bindParam(':Account', $this->Account);
    
        // execute the query
        $stmt->execute();
        $num = $stmt->rowCount();
        if($num !== 0){
            return false;
        }
    
        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET Account=:Account, Password=:Password";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->Account=htmlspecialchars(strip_tags($this->Account));
        $this->Password=htmlspecialchars(strip_tags($this->Password));
    
        // bind values
        $stmt->bindParam(":Account", $this->Account);
        $stmt->bindParam(":Password", $this->Password);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // function isDup(){
    // }

    // delete the account
    function delete(){
    
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE Account = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->Account=htmlspecialchars(strip_tags($this->Account));
    
        // bind id of record to delete
        $stmt->bindParam(1, $this->Account);
    
        // execute query
        if($stmt->execute()){
            // if($stmt->rowCount()==0){
            //     return false;
            // }
            return true;
        }
    
        return false;
    }

    // update the product
    function update(){
    
        // update query
        $query = "UPDATE " . $this->table_name . " SET Password = :Password WHERE Account = :Account";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->Password=htmlspecialchars(strip_tags($this->Password));
        $this->Account=htmlspecialchars(strip_tags($this->Account));
    
        // bind new values
        $stmt->bindParam(':Password', $this->Password);
        $stmt->bindParam(':Account', $this->Account);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // login
    function login(){
    
        // select all query
        $query = "SELECT * FROM " . $this->table_name . " WHERE Account = :Account AND Password = :Password";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->Password=htmlspecialchars(strip_tags($this->Password));
        $this->Account=htmlspecialchars(strip_tags($this->Account));
    
        // bind new values
        $stmt->bindParam(':Password', $this->Password);
        $stmt->bindParam(':Account', $this->Account);
    
        // execute the query
        $stmt->execute();
        return $stmt;
    }
}



?>