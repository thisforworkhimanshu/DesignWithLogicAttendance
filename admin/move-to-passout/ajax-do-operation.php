<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_POST['batchyear'])&&isset($_POST['fromDate'])&&isset($_POST['toDate'])){
    $fromDate = $_POST['fromDate'];
    $toDate = $_POST['toDate'];
    $batchyear = $_POST['batchyear'];
    session_start();
    $dept_id = $_SESSION['a_dept_id'];
    $semester = $_SESSION['semester_cur'];
    $nextSem = $semester+1;
    
    require_once '../../Connection.php';
    $connection = new Connection();
    $conn = $connection->createConnection("college");
    
    $bolstat = FALSE;
    mysqli_autocommit($conn, FALSE);
    $sqlins = "INSERT INTO term_duration VALUES (0,$nextSem,$batchyear,'".$fromDate."','".$toDate."',$dept_id)";
    
    if(mysqli_query($conn, $sqlins)){
        $sqlupdate = "UPDATE student SET student_semester = $nextSem WHERE batch_year = $batchyear and student_dept_id = $dept_id";
        if(mysqli_query($conn, $sqlupdate)){
            $sqldel = "DELETE FROM subject_faculty_allocation WHERE semester = $semester and dept_id = $dept_id";
            if(mysqli_query($conn, $sqldel)){
                $sqlteaching = "SELECT * FROM teaching_scheme WHERE semester = $semester and dept_id = $dept_id";
                $resultteaching = mysqli_query($conn, $sqlteaching);
                if(mysqli_num_rows($resultteaching)>0){
                    while ($rowteach = mysqli_fetch_assoc($resultteaching)){
                        
                        $sub_code = $rowteach['subject_code'];
                        $total_theory = $rowteach['total_theory'];
                        $total_practical = $rowteach['total_practical'];
                        
                        $sqlupdateTheory = "UPDATE track_theory_hour SET total_theory = $total_theory WHERE subject_code = $sub_code";
                        $sqlupdatePractical = "UPDATE track_practical_hour SET total_practical = $total_practical WHERE subject_code = $sub_code";
                        
                        if(mysqli_query($conn, $sqlupdateTheory)&& mysqli_query($conn, $sqlupdatePractical)){
                            $bolstat = TRUE;
                        }else{
                            $bolstat = FALSE;
                        }
                    }
                }else{
                    $bolstat = FALSE;
                }
            }else{
                $bolstat = FALSE;
            }
        }else{
            $bolstat = FALSE;
        }
    }else{
        $bolstat = FALSE;
    }
    
    if($bolstat){
        mysqli_commit($conn);
        echo "success";
    }else{
        mysqli_rollback($conn);
        echo "failed";
    }
}
