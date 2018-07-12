<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$dept_id = $_SESSION['f_dept_id'];
$fac_id = $_SESSION['fid'];

require_once '../Connection.php';

$connection = new Connection();
$conn = $connection->createConnection();

if(isset($_POST['subjectcode'])){
    $subject_code = $_POST['subjectcode'];
    $sqlGetTotalLecture = "SELECT lecture_type,type,expected_total_lecture FROM subject_faculty_allocation where faculty_id = $fac_id and dept_id = $dept_id";
    $resultTotalLecture = mysqli_query($conn, $sqlGetTotalLecture);
    if(mysqli_num_rows($resultTotalLecture)>0){
        $i=1;
        while($row= mysqli_fetch_assoc($resultTotalLecture)){
            $type = $row['type'];
            $lec_type=$row['lecture_type'];
            $totallecture = $row['expected_total_lecture'];
            
            echo $i.'. '.$lec_type.' of '.$type.' has '.$totallecture.' lecture. <br>';
            $i++;
        }
    }else{
        echo 'No Data Present';
    }
}

