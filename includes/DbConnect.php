<?php
class DbConnect
{
    private $conn;

    function __Construct()
    {

    }
    function connect()
    {
        include_once dirname(__FILE__).'/Constants.php';
        $this->conn=new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

        if(mysqli_connect_errno()){
            echo "Failed  to connect " . mysqli_connect_error(); 
            return null; 
        }

        return $this->conn;

    }
}