<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['username'])&&isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    require_once '../../Connection.php';
    $connection = new Connection();
    $conn = $connection->createConnection("college");
    
    $sqlcheck = "select student_enrolment,student_dept_id from student where student_enrolment = $username and student_password = '".$password."' ";
    $result = mysqli_query($conn, $sqlcheck);
    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['s_dept_id'] = $row['student_dept_id'];
        $_SESSION['enrolment'] = $row['student_enrolment'];
        echo "ok";
    }else{
        echo "notok";
    }
}