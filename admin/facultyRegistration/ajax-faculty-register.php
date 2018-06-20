<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['firstName'])&&isset($_POST['email'])&&isset($_POST['cellno'])&&isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['gender'])){
    session_start();
    $dept_id= $_SESSION['a_dept_id'];
    $firstname = $_POST['firstName'];
    $email = $_POST['email'];
    $cellno = $_POST['cellno'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $designation = $_POST['designation'];
    
    require_once '../../Connection.php';
    $connection = new Connection();
    $conn = $connection->Connect("college");
    if(!$conn){
        die('Failed');
    }else{
        $data = Array("faculty_fname"=>$firstname,
            "faculty_uname"=>$username,
            "faculty_pass"=>$password,
            "dept_id"=>$dept_id,
            "faculty_email"=>$email,
            "faculty_cellno"=>$cellno,
            "faculty_gender"=>$gender,
            "faculty_designation"=>$designation
            );
        $id = $conn->insert('faculty',$data);
        if($id){
            echo "ok".$id;
        }else{
            echo "Registration Failed! Try Again After Some Time";
        }
    }
    
}else{
    header("Location: ../../index.php");
}