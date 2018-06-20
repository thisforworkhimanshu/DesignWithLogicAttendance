<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_POST['enrolment'])){
    require_once '../../Connection.php';
    $connection = new Connection();
    $conn = $connection->createConnection("college");
    session_start();
    $dept_id = $_SESSION['a_dept_id'];
    $enrol = $_POST['enrolment'];
    $sqlcheckenrol = "SELECT student_enrolment from student where student_enrolment = $enrol AND student_dept_id = $dept_id";
    $result = mysqli_query($conn, $sqlcheckenrol);
    if(mysqli_num_rows($result)){
        $sqlcheckdet = "SELECT enrolment from detain_stud where enrolment = $enrol";
        $resultdet = mysqli_query($conn, $sqlcheckdet);
        if(mysqli_num_rows($resultdet)>0){
            echo "already";
        }else{
            mysqli_autocommit($conn, FALSE);
            $bolstat = false;
            $sqldet = "UPDATE student SET batch_year = 0,student_division = NULL, student_batch = NULL WHERE student_enrolment = $enrol";
            if(mysqli_query($conn, $sqldet)){
                $sqlins = "INSERT INTO detain_stud(enrolment) VALUE($enrol)";
                if(mysqli_query($conn, $sqlins)){
                    $bolstat=true;
                }
            }else{
                $bolstat = false;
            }
            
            if($bolstat){
                mysqli_commit($conn);
                echo 'success';
            }else{
                mysqli_rollback($conn);
                echo 'failed';
            }
        }
    }else{
        echo "norecord";
    }
}
