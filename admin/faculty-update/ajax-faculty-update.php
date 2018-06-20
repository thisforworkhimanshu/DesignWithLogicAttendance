<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['fid'])&&isset($_POST['fname'])&&isset($_POST['uname'])&&isset($_POST['pass'])&&isset($_POST['email'])&&isset($_POST['cellno'])&&isset($_POST['gender'])){
    
    $fid = $_POST['fid'];
    $fname = $_POST['fname'];
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    $cellno = $_POST['cellno'];
    $gender = $_POST['gender'];
    
    require_once '../../Connection.php';
    $connection = new Connection();
    $conn = $connection->Connect("college");
    if(!$conn){
        die("Connection Failed");
    }else{
        $data = Array("faculty_fname"=>$fname,
            "faculty_uname"=>$uname,
            "faculty_pass"=>$pass,
            "faculty_email"=>$email,
            "faculty_cellno"=>$cellno,
            "faculty_gender"=>$gender
            );
        $conn->where('faculty_id',$fid);
        if($conn->update("faculty",$data)){
            echo 'ok';
        }else{
            echo 'Updation Failed';
        }
    }
}