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

$conn = mysqli_connect("localhost", "root", "", "college");
if(!$conn){
    die('Connection Failed');
}

mysqli_autocommit($conn, FALSE);
if(isset($_POST["submit_file"]))
{
    $i=0;
    $file = $_FILES["file"]["tmp_name"];
    $file_open = fopen($file,"r");
    $isvalid = false;
    
    $fromDate = $_POST['fromDate'];
    $toDate = $_POST['toDate'];
    $merawalabatch= 0;
    while(($csvval = fgetcsv($file_open,1000,","))!==FALSE){
        if($i>0) {
            
            $enrol = $csvval[0];
            $name = $csvval[1];
            $semester = $csvval[2];
            $dept_id = $csvval[3];
            $adm_yr = $csvval[4];
            $batch_year = $csvval[5];
            
            $email = $csvval[6];
            $cellno = $csvval[7];
            
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
        $isoperated = false;
        
        $sqlcheck = "SELECT * FROM adm_yrs_eq where dept_id = $dept_id and year =".$year;
        $resultcheck = mysqli_query($conn, $sqlcheck);
        if(mysqli_num_rows($resultcheck)>0){
            header("Location: student-registration.php?status=failed");
            mysqli_close($conn);
        }else{
            mysqli_autocommit($conn, FALSE);
            $sql = "insert into adm_yrs_eq(year,status,dept_id) values($merawalabatch,'running',$dept_id)";
            if(mysqli_query($conn, $sql)){
                $sqlterm = "INSERT INTO term_duration VALUES (0,$semester,$merawalabatch,'".$fromDate."','".$toDate."',$dept_id)";
                if(mysqli_query($conn, $sqlterm)){
                    while(($csv = fgetcsv($file_open, 1000, ",")) !== false)
                    {
                        $isoperated = false;
                        mysqli_autocommit($conn, FALSE);
                        if($k>0) {
                            $enrol = $csv[0];
                            $name = $csv[1];
                            $semester = $csv[2];
                            $dept_id = $csv[3];
                            $adm_yr = $csv[4];
                            $batch_year = $csv[5];
                            $email = $csv[6];
                            $cellno = $csv[7];
                            $sql = "INSERT INTO `student`(`student_enrolment`, `student_name`, `student_semester`, `student_dept_id`, `student_adm_yr`, `batch_year`, `student_email`,`student_cellno`,`student_password`) VALUES ($enrol,'".$name."',$semester,$dept_id,$adm_yr,$batch_year,'".$email."',$cellno,'".$enrol."');";
                            $sqlins = "INSERT INTO sem1_".$dept_id."(`enrolment`) VALUE($enrol);";
                            $sqlins1 = "INSERT INTO sem1_".$dept_id."_r(`enrolment`) VALUE($enrol);";
                            $sqlins2 = "INSERT INTO sem2_".$dept_id."(`enrolment`) VALUE($enrol);";
                            $sqlins3 = "INSERT INTO sem2_".$dept_id."_r(`enrolment`) VALUE($enrol);";
                            $sqlins4= "INSERT INTO sem3_".$dept_id."(`enrolment`) VALUE($enrol);";
                            $sqlins5= "INSERT INTO sem3_".$dept_id."_r(`enrolment`) VALUE($enrol);";
                            $sqlins6= "INSERT INTO sem4_".$dept_id."(`enrolment`) VALUE($enrol);";
                            $sqlins7= "INSERT INTO sem4_".$dept_id."_r(`enrolment`) VALUE($enrol);";
                            $sqlins8= "INSERT INTO sem5_".$dept_id."(`enrolment`) VALUE($enrol);";
                            $sqlins9= "INSERT INTO sem5_".$dept_id."_r(`enrolment`) VALUE($enrol);";
                            $sqlins10= "INSERT INTO sem6_".$dept_id."(`enrolment`) VALUE($enrol);";
                            $sqlins11= "INSERT INTO sem6_".$dept_id."_r(`enrolment`) VALUE($enrol);";
                            $sqlins12= "INSERT INTO sem7_".$dept_id."(`enrolment`) VALUE($enrol);";
                            $sqlins13= "INSERT INTO sem7_".$dept_id."_r(`enrolment`) VALUE($enrol);";
                            $sqlins14= "INSERT INTO sem8_".$dept_id."(`enrolment`) VALUE($enrol);";
                            $sqlins15= "INSERT INTO sem8_".$dept_id."_r(`enrolment`) VALUE($enrol)";
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
                }else{
                    $isoperated = false;
                }
            }else{
                $isoperated = false;
            }
            
            if($isoperated){
                mysqli_commit($conn);
                mysqli_close($conn);
                header("Location: student-registration.php?status=success");

            }else{
                mysqli_rollback($conn);
                mysqli_close($conn);
                header("Location: student-registration.php?status=failed");
            }
        }
    }else{
        mysqli_close($conn);
        header("Location: student-registration.php?status=failed");
    }
}