<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['enrolment'])&&isset($_POST['semester'])&&isset($_POST['examtype'])&&isset($_POST['subject'])){
    session_start();
    $semester = $_POST['semester'];
    $enrolment = $_POST['enrolment'];
    $examtype = $_POST['examtype'];
    $subject = $_POST['subject'];
    
    $dept_id = $_SESSION['f_dept_id'];
    
    
    require_once '../../Connection.php';
    $connection = new Connection();
    $conn = $connection->createConnection("college");
    error_reporting(E_ALL ^ E_WARNING); 
    if($examtype==="m"){
        
        $sqlmidmark = "select ".$subject."_m as mid from sem".$semester."_".$dept_id." where enrolment = $enrolment";
        $resultMidmark = mysqli_query($conn, $sqlmidmark);
        if(mysqli_num_rows($resultMidmark)>0){
            $rowMark = mysqli_fetch_assoc($resultMidmark);
            $mark = $rowMark['mid'];
            echo $mark;
        }else{
            
        }
    }else if($examtype==="v"){
        $sqlmark = "select ".$subject."_v as viva from sem".$semester."_".$dept_id." where enrolment = $enrolment";
        $resultmark = mysqli_query($conn, $sqlmark);
        if(mysqli_num_rows($resultmark)>0){
            $rowMark = mysqli_fetch_assoc($resultmark);
            $mark = $rowMark['viva'];
            echo $mark;
        }else{
            
        }
    }elseif ($examtype==="r") {
        $sqlremidmark = "select ".$subject."_r as remid from sem".$semester."_".$dept_id."_r where enrolment = $enrolment";
        $resultReMidmark = mysqli_query($conn, $sqlremidmark);
        if(mysqli_num_rows($resultReMidmark)>0){
            $rowMark = mysqli_fetch_assoc($resultReMidmark);
            $mark = $rowMark['remid'];
            echo $mark;
        }else{
            
        }
    }
}