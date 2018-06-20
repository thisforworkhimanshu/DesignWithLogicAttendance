<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['batchyear'])){
    require_once '../../Connection.php';
    $connection = new Connection();
    $conn = $connection->Connect("college");
    if(!$conn){
        die("Connection Failed");
    }else{
        $batchyear = $_POST['batchyear'];
        
        $sql="SELECT COUNT(*) as total FROM `student` where batch_year = $batchyear";
        $result = $conn->ObjectBuilder()->rawQueryOne($sql);
        $no_of_row = $conn->count;
        $totalstud = $result->total;
        echo "ok".$totalstud;
    }
}