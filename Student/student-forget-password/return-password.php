<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['enrol'])&&isset($_POST['email'])&&isset($_POST['cellno'])){
    require_once '../../Connection.php';
    $connection = new Connection();
    $conn = $connection->createConnection("college");
    
    $enrol = $_POST['enrol'];
    $cellno=$_POST['cellno'];
    $email=$_POST['email'];
    
    $sqlGet = "select * from student where student_enrolment = $enrol and student_email = '".$email."' and student_cellno = $cellno";
    $result = mysqli_query($conn, $sqlGet);
    
    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
        echo $row['student_password'];
    }else{
        echo 'Verify Details';
    }
}