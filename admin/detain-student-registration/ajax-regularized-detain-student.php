<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
error_reporting(E_ALL ^ E_WARNING);
if(isset($_POST['enrolment'])){
    require_once '../../Connection.php';
    $connection = new Connection();
    $conn = $connection->createConnection("college");
    session_start();
    $dept_id = $_SESSION['a_dept_id'];
    
    $enrol = $_POST['enrolment'];
    $batchyear = $_POST['batchyear'];
    
    $sqlcheckbatchyear = "Select year from adm_yrs_eq where year = $batchyear";
    $sqlresultbatchyear = mysqli_query($conn, $sqlcheckbatchyear);
    $no_of_row = mysqli_num_rows($sqlcheckbatchyear);
    if($no_of_row>0){
        $sqlcheckdet = "SELECT detain_stud.enrolment,student.student_adm_yr from detain_stud INNER JOIN student ON detain_stud.enrolment = student.student_enrolment WHERE enrolment = $enrol";
        $resultdet = mysqli_query($conn, $sqlcheckdet);
    
        if(mysqli_num_rows($resultdet)>0){
            $row = mysqli_fetch_assoc($resultdet);
            $adm_yr = $row['student_adm_yr'];

            if($batchyear == ($adm_yr+1) || $batchyear == $adm_yr || $batchyear < $adm_yr){
                echo "notvalid";
            }else{
                mysqli_autocommit($conn, FALSE);
                $bolstat = false;
                $sqldet = "UPDATE student SET batch_year = $batchyear,student_division = 'A', student_batch = 'B1' WHERE student_enrolment = $enrol";
                if(mysqli_query($conn, $sqldet)){
                    $sqlins = "DELETE FROM detain_stud WHERE enrolment = $enrol";
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
    }else{
        echo "notvalid";
    }
}
