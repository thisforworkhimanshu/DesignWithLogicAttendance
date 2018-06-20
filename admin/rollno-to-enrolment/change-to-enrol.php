<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$year = date("Y");

$deptid = $_SESSION['a_dept_id'];
ini_set('max_execution_time', 5000);

require_once '../../Connection.php';

$connection = new Connection();
$conn = $connection->createConnection("college");

mysqli_autocommit($conn, FALSE);
if(isset($_POST['btnSumit'])){
    
    $i=0;
    $file = $_FILES["file"]["tmp_name"];
    $file_open = fopen($file,"r");
    $isvalid = false;
    
    $merawalabatch= 0;
    while(($csvval = fgetcsv($file_open,1000,","))!==FALSE){
        if($i>0) {
            
            $rollno = $csvval[0];
            $enrol = $csvval[1];
            $name = $csvval[2];
            $semester = $csvval[3];
            $dept_id = $csvval[4];
            $adm_yr = $csvval[5];
            $batch_year = $csvval[6];
            
            $email = $csvval[7];
            $cellno = $csvval[8];
            
            if($batch_year!=$year){
                $isvalid = false;
                break;
            }else if($adm_yr!=$year){
                $isvalid = false;
                break;
            }else if(empty($enrol)||empty($name)||empty($semester)||empty($dept_id)||empty($adm_yr)||empty($batch_year)||empty($email)||empty($cellno)){
                $isvalid = false;
                break;
            }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $isvalid = false;
                break;
            }else if(strlen($cellno)>10|| strlen($cellno)<10){
                $isvalid = false;
                break;
            }else if($dept_id!=$deptid){
                $isvalid = false;
                break;
            }else if($semester!=1){
                $isvalid = false;
                break;
            }
            $merawalabatch = $batch_year;
            $isvalid = true;
         }
        $i++;
    }
    
    if($isvalid){
        
        $k=0;
        $file = $_FILES["file"]["tmp_name"];
        $file_open = fopen($file,"r");
        $isoperated=false;
        
        while(($csv = fgetcsv($file_open, 1000, ",")) !== false)
        {
            $isoperated = false;
            mysqli_autocommit($conn, FALSE);
            if($k>0) {
                
                $rollno = $csv[0];
                $enrol = $csv[1];
                $name = $csv[2];
                $semester = $csv[3];
                $dept_id = $csv[4];
                $adm_yr = $csv[5];
                $batch_year = $csv[6];
                $email = $csv[7];
                $cellno = $csv[8];
                
                $sql = "UPDATE student SET student_enrolment = $enrol WHERE student_enrolment = $rollno";
                $sqlins = "UPDATE sem1_".$dept_id." SET enrolment = $enrol WHERE enrolment = $rollno";
                $sqlins1 = "UPDATE sem1_".$dept_id."_r SET enrolment = $enrol WHERE enrolment = $rollno";
                $sqlins2 = "UPDATE sem2_".$dept_id." SET enrolment = $enrol WHERE enrolment = $rollno";
                $sqlins3 = "UPDATE sem2_".$dept_id."_r SET enrolment = $enrol WHERE enrolment = $rollno";
                $sqlins4= "UPDATE sem3_".$dept_id." SET enrolment = $enrol WHERE enrolment = $rollno";
                $sqlins5= "UPDATE sem3_".$dept_id."_r SET enrolment = $enrol WHERE enrolment = $rollno";
                $sqlins6= "UPDATE sem4_".$dept_id." SET enrolment = $enrol WHERE enrolment = $rollno";
                $sqlins7= "UPDATE sem4_".$dept_id."_r SET enrolment = $enrol WHERE enrolment = $rollno";
                $sqlins8= "UPDATE sem5_".$dept_id." SET enrolment = $enrol WHERE enrolment = $rollno";
                $sqlins9= "UPDATE sem5_".$dept_id."_r SET enrolment = $enrol WHERE enrolment = $rollno";
                $sqlins10= "UPDATE sem6_".$dept_id." SET enrolment = $enrol WHERE enrolment = $rollno";
                $sqlins11= "UPDATE sem6_".$dept_id."_r SET enrolment = $enrol WHERE enrolment = $rollno";
                $sqlins12= "UPDATE sem7_".$dept_id." SET enrolment = $enrol WHERE enrolment = $rollno";
                $sqlins13= "UPDATE sem7_".$dept_id."_r SET enrolment = $enrol WHERE enrolment = $rollno";
                $sqlins14= "UPDATE sem8_".$dept_id." SET enrolment = $enrol WHERE enrolment = $rollno";
                $sqlins15= "UPDATE sem8_".$dept_id."_r SET enrolment = $enrol WHERE enrolment = $rollno";
                if(mysqli_query($conn, $sqlins15)&& mysqli_query($conn, $sqlins14)&&
                mysqli_query($conn, $sqlins13)&& mysqli_query($conn, $sqlins12)
                        && mysqli_query($conn, $sqlins11)&& mysqli_query($conn, $sqlins10)
                        && mysqli_query($conn, $sqlins9)&& mysqli_query($conn, $sqlins8)
                        && mysqli_query($conn, $sqlins7)&& mysqli_query($conn, $sqlins6)
                        && mysqli_query($conn, $sqlins5)&& mysqli_query($conn, $sqlins4)
                        && mysqli_query($conn, $sqlins3)&& mysqli_query($conn, $sqlins2)
                        && mysqli_query($conn, $sqlins1)&& mysqli_query($conn, $sqlins)
                        && mysqli_query($conn, $sql)){
                    $isoperated = true;
                }else{
                    $isoperated = false;
                }
            }
            $k++;
        }
        
        if($isoperated){
            mysqli_commit($conn);
            mysqli_close($conn);
            header("Location: roll-to-enrolment.php?status=success");
        }else{
            mysqli_rollback($conn);
            mysqli_close($conn);
            header("Location: roll-to-enrolment.php?status=failed");
        }
    }else{
        header("Location: roll-to-enrolment.php?status=notvalid");
    }
}
