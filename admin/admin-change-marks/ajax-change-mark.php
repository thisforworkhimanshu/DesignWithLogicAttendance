<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['enrolment'])&&isset($_POST['semester'])&&isset($_POST['examtype'])&&isset($_POST['subject'])&&isset($_POST['mark'])){
    session_start();
    $semester = $_POST['semester'];
    $enrolment = $_POST['enrolment'];
    $examtype = $_POST['examtype'];
    $subject = $_POST['subject'];
    $mark = $_POST['mark'];
    
    $dept_id = $_SESSION['a_dept_id'];
    
    require_once '../../Connection.php';
    $connection = new Connection();
    $conn = $connection->createConnection("college");
    
    if($examtype==="m"){
        $sqlmarkupdate = "update sem".$semester."_".$dept_id." set ".$subject."_m = $mark where enrolment=$enrolment";
        if(mysqli_query($conn, $sqlmarkupdate)){
            echo "ok";
        }else{
            echo "notok";
        }
        
    }else if($examtype==="v"){
        $sqlmarkupdate = "update sem".$semester."_".$dept_id." set ".$subject."_v = $mark where enrolment=$enrolment";
        if(mysqli_query($conn, $sqlmarkupdate)){
            echo "ok";
        }else{
            echo "notok";
        }
    }else if($examtype==="r"){
        $sqlmarkupdate = "update sem".$semester."_".$dept_id."_r set ".$subject."_r = $mark where enrolment=$enrolment";
        if(mysqli_query($conn, $sqlmarkupdate)){
            echo "ok";
        }else{
            echo "notok";
        }
    }
}