<?php
class db 
{ 
    
    private $engine		="mysql"; 
    private $host		="localhost"; 
    private $database	="test"; 
    private $user		="root"; 
    private $pass		=""; 

    public function connect()
    {
    	$mysql_connect_str = "mysql:host=$this->host;dbname=$this->database;";
    	$dbConnection = new PDO($mysql_connect_str,$this->user,$this->pass);
    	$dbConnection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
   		return $dbConnection;
    }   
    
} 

?>