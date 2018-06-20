<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_POST['batchyear'])){
    $batchyear = $_POST['batchyear'];
    
    require_once '../../Connection.php';
    $connection = new Connection();
    $conn = $connection->createConnection("college");
    
    session_start();
    $dept_id = $_SESSION['a_dept_id'];
    
    $sqlsem = "SELECT DISTINCT(student_semester) as student_semester FROM student WHERE batch_year = $batchyear and student_dept_id = $dept_id";
    $resultsem = mysqli_query($conn, $sqlsem);
    if(mysqli_num_rows($resultsem)>0){
        $row = mysqli_fetch_assoc($resultsem);
        $sem = $row['student_semester'];
        
        session_start();
        $_SESSION['semester_cur'] = $sem;
        $_SESSION['batch_year_cur'] = $batchyear;
        
        $sqlcheckbatchyear = "SELECT * FROM term_duration where batch_year = $batchyear and semester = $sem and dept_id = $dept_id";
        $resultcheck = mysqli_query($conn, $sqlcheckbatchyear);
        if(mysqli_num_rows($resultcheck)>0){
            $rowdate = mysqli_fetch_assoc($resultcheck);
            $enddate = $rowdate['end_date'];
            $curdate = date("Y-m-d");
            if(strtotime($curdate)< strtotime($enddate)){
                echo "notnow";
            }else{
                $jsonArray = array("sem"=>$sem,"status"=>"present");
                echo json_encode($jsonArray);
//                echo "present";
            }
        }else{
            echo "notpresent";
        }
    }
}
