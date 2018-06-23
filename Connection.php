<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Connection
 *
 * @author Himanshu
 */
include 'MysqliDb.php';

class Connection {
    
    private $db_host = "localhost";  // Change as required
    private $db_user = "root";  // Change as required
    private $db_pass = "";  // Change as required
    private $db_name = ""; // Change as required
    
    function createConnection($dbname="college"){
        $conn = mysqli_connect("localhost", "root", "", $dbname);
        if(!$conn){
            die('Unexpectedly Connection to Database Failed: We are working on it...');
        }else{
            return $conn;
        }
    }
    
    public function Connect($db_name="college") {
        if (isset($db_name)){
            $this->db_name = $db_name;
        }
        $mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        return $db = new MysqliDb($mysqli);
    }
    
}
