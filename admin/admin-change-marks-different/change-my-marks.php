<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

require_once '../../Connection.php';
$connection = new Connection();
$conn = $connection->createConnection("college");

$dept_id = $_SESSION['a_dept_id'];
$semester = $_SESSION['semester_change'];
$examtype = $_SESSION['examtype_change'];
$enrolment = $_SESSION['enrolment_change'];

$sqlSubject = "select subject_code from subject where dept_id = $dept_id and semester = $semester";
$resultSubject = mysqli_query($conn, $sqlSubject);
$status=FALSE;

if(mysqli_num_rows($resultSubject)>0){
    while($rowSubject = mysqli_fetch_assoc($resultSubject)){
        $subject_code = $rowSubject['subject_code'];
        mysqli_autocommit($conn, FALSE);
        if(isset($_POST[$subject_code])){
            if($examtype==="m"){
                $mark = $_POST[$subject_code];
                $sqlupdate = "UPDATE sem".$semester."_".$dept_id." SET ".$subject_code."_m = $mark where enrolment = $enrolment";
                if(mysqli_query($conn, $sqlupdate)){
                    $status=TRUE;
                }else{
                    $status=FALSE;
                }
            }else if($examtype==="v"){
                $mark = $_POST[$subject_code];
                $sqlupdate = "UPDATE sem".$semester."_".$dept_id." SET ".$subject_code."_v = $mark where enrolment = $enrolment";
                if(mysqli_query($conn, $sqlupdate)){
                    $status=TRUE;
                }else{
                    $status=FALSE;
                }
            }else if($examtype==="r"){
                $mark = $_POST[$subject_code];
                $sqlupdate = "UPDATE sem".$semester."_".$dept_id."_r SET ".$subject_code."_r = $mark where enrolment = $enrolment";
                if(mysqli_query($conn, $sqlupdate)){
                    $status=TRUE;
                }else{
                    $status=FALSE;
                }
            }
        }else{
            continue;
        }
    }
    
    if($status){
        mysqli_commit($conn);
        header("Location: get-Change-Detail.php?status=success");
    }else{
        mysqli_rollback($conn);
        header("Location: get-Change-Detail.php?status=failed");
    }
}