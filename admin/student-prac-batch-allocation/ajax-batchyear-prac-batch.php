<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_POST['batchyear'])){
    $batch_year = $_POST['batchyear'];
    require_once '../../Connection.php';
    $connection = new Connection();
    $conn = $connection->createConnection("college");
    if(!$conn){
        die('Connection to Database Failed');
    }else{
        $sqlcheck = "SELECT DISTINCT(student_semester) as sem from student where batch_year = $batch_year";
        $resultcheck = mysqli_query($conn, $sqlcheck);
        
        if(mysqli_num_rows($resultcheck)>0){
            $row = mysqli_fetch_assoc($resultcheck);
            $semester = $row['sem'];
            
            echo $semester;
            
            session_start();
            $_SESSION['batch_sem'] = $semester;
        }
    }
}
