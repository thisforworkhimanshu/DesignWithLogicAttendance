<?php
session_start();
$year = date("Y")-1;
$curyear = date("Y");
//$year = 2015;
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
            }else if($curyear!=$adm_yr){
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
            }elseif ($semester!=3) {
                $isvalid = false;
                break;
            }
            $isvalid = true;
         }
        $i++;
    }

    if($isvalid){
        $k=0;
        $file = $_FILES["file"]["tmp_name"];
        $file_open = fopen($file,"r");
        $isoperated = false;
        $sqlcheck = "SELECT * FROM adm_yrs_eq where year =".$year." and dept_id = $dept_id";
        $resultcheck = mysqli_query($conn, $sqlcheck);
        if(mysqli_num_rows($resultcheck)>0){
            mysqli_autocommit($conn, FALSE);
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
                    $sql = "INSERT INTO `student`(`student_enrolment`, `student_name`, `student_semester`, `student_dept_id`, `student_adm_yr`, `batch_year`, `student_email`,`student_cellno`,`student_password`) VALUES ($enrol,'".$name."',$semester,$dept_id,$adm_yr,$batch_year,'".$email."',$cellno,'".$enrol."')";
                    if(mysqli_query($conn,$sql)){
                        $isoperated = true;
                    }else{
                        $isoperated = false;
                    }
                }
                $k++;
            } 
        }else{
            header("Location: student-registration.php?status=failed");
            mysqli_close($conn);
        }
        
        if(!$isoperated){
            mysqli_rollback($conn);
            header("Location: student-registration.php?status=failed");
            mysqli_close($conn);
        }else{
            mysqli_commit($conn);
            header("Location: student-registration.php?status=success");
            mysqli_close($conn);
        }
    }else{
        header("Location: student-registration.php?status=failed");
        mysqli_close($conn);
    }
}else{
    header("Location: student-registration.php?status=failed");
    mysqli_close($conn);
}