<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['uname'])){
    
    $uname=$_POST['uname'];
    
    require_once '../../Connection.php';
    $connection = new Connection();
    $conn = $connection->createConnection("college");
    
    if(!$conn){
        die('Failed');
    }else{
        $sql = "SELECT * FROM faculty where faculty_uname = '".$uname."'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result)>0){
            echo "ok";
        }else{
            echo "notok";
        }
        
    }
    
}else{
    header("Location: ../../index.php");
}