<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_POST["submit_file"]))
{
    $dept_id=16;
    $i=0;
    $file = $_FILES["file"]["tmp_name"];
    $file_open = fopen($file,"r");
    $isvalid = false;
    
    $sem = $_POST['semester'];
    $subcode = $_POST['subject'];
    $examtype = $_POST['examtype'];
    $division = $_POST['division'];

    while(($csvval = fgetcsv($file_open,1000,","))!==FALSE){
        if($i>0) {
            
            $enrol = $csvval[0];
            $mark = $csvval[2];
            
            if(empty ($enrol)||empty ($mark)){
                $isvalid =false;
                break;
            }
            $isvalid = true;
        }
        $i++;
    }

    if($isvalid){
        $conn = mysqli_connect("localhost", "root", "", "college");
        $k=0;
        echo 'Entered';
        $file = $_FILES["file"]["tmp_name"];
        $file_open = fopen($file,"r");
        $isoperated = false;
        comehere:
        while(($csv = fgetcsv($file_open, 1000, ",")) !== false)
        {
            $isoperated = false;
            mysqli_autocommit($conn, FALSE);
            if($k>0) {
                $enrol = $csv[0];
                $mark = $csv[2];
                echo $enrol;
                
                $sqlcheck = "SELECT enrolment FROM detain_stud where enrolment = $enrol";
                $result1 = mysqli_query($conn, $sqlcheck);
                if(mysqli_num_rows($result1)){
                    goto comehere;
                }
                
                $sqlcheckenrol = "SELECT * FROM `student` WHERE student_enrolment = $enrol and student_division = '".$division."'";
                $result = mysqli_query($conn,$sqlcheckenrol);
                
                if(mysqli_num_rows($result)>0){
                    $row = mysqli_fetch_assoc($result);
                    $year = $row['batch_year'];
                    
                    if($examtype==="r"){
                        $sqlins = "UPDATE sem".$sem."_".$dept_id."_r SET year = $year, ".$subcode."_r = $mark WHERE enrolment = $enrol";
                        if(mysqli_query($conn, $sqlins)){
                            $isoperated = TRUE;
                        }else{
                            $isoperated = FALSE;
                            break;
                        }
                    }else if($examtype==="m"){
                        $sqlins = "UPDATE sem".$sem."_".$dept_id." SET year = $year, ".$subcode."_m = $mark WHERE enrolment = $enrol";
                        if(mysqli_query($conn, $sqlins)){
                            $isoperated = TRUE;
                        }else{
                            $isoperated = FALSE;
                            break;
                        }
                    }else if($examtype==="v"){
                        $sqlins = "UPDATE sem".$sem."_".$dept_id." SET year = $year, ".$subcode."_v = $mark WHERE enrolment = $enrol";
                        if(mysqli_query($conn, $sqlins)){
                            $isoperated = TRUE;
                        }else{
                            $isoperated = FALSE;
                            break;
                        }
                    }
                    
                }else{
                    $isoperated = false;
                    break;
                }
            }
                $k++;
        }
            
        if($isoperated){
            mysqli_commit($conn);
            mysqli_close($conn);
            header("Location: faculty-marks-entry.php?status=success");
        }else{
            mysqli_rollback($conn);
            mysqli_close($conn);
            echo 'Failed with Rollback';
            header("Location: faculty-marks-entry.php?status=failed");
        }
    }else{
        mysqli_close($conn);
        echo 'File Type Not valid';
        header("Location: faculty-marks-entry.php?status=notvalid");
    }
}
