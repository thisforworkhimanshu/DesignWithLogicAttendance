<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$obj = json_decode($_POST['myData']);

//echo $obj->semester." ".$obj->subject." ".$obj->faculty." ".$obj->lecturetype." ".$obj->type;

if(isset($_POST['myData'])){
    $sem = $obj->semester;
    $sub = $obj->subject;
    $fac = $obj->faculty;
    $lectype = $obj->lecturetype;
    $type = $obj->type;
    $hours = $obj->lecture_hour;
    $expected_lecture = $obj->lecture_total;
    
    session_start();
    $dept_id = $_SESSION['a_dept_id'];
    $batch_year = $_SESSION['batch_year'];
    require_once '../../Connection.php';
    
    $connection = new Connection();
    $conn = $connection->createConnection("college");
    
    if(!$conn){
        die('Connection Failed');
    }else{
        
        $sqlcheck = "SELECT * FROM subject_faculty_allocation where subject_code= $sub and faculty_id= $fac and semester= $sem and dept_id= $dept_id and lecture_type= '".$lectype."' and type= '".$type."'";
        $resultcheck = mysqli_query($conn, $sqlcheck);
        
        if(mysqli_num_rows($resultcheck)>0){
            $status=FALSE;
            mysqli_autocommit($conn, FALSE);
            
            $rowcheck = mysqli_fetch_assoc($resultcheck);
            $allocatedhour = $rowcheck['total_hours'];
            $allocatedlecture = $rowcheck['expected_total_lecture'];
            
            if($lectype=="theory"){
                $lefthour = $_SESSION['lec_hour_left'];
                $updatehour = $lefthour-$hours;
                $finalhour = $hours + $allocatedhour;
                $finalecture = $allocatedlecture+$expected_lecture;
                
                $sqlupdate = "UPDATE track_theory_hour SET total_theory = $updatehour WHERE type = '".$type."' and subject_code = $sub";
                if(mysqli_query($conn, $sqlupdate)){
                    $sqldupupdate = "UPDATE duplicate_subject_faculty_allocation SET total_hours = $finalhour, expected_total_lecture = $finalecture WHERE batch_year = $batch_year and subject_code = $sub and faculty_id = $fac and semester = $sem and dept_id = $dept_id and lecture_type = '".$lectype."' and type = '".$type."'";
                    $sqlorigupdate = "UPDATE subject_faculty_allocation SET total_hours = $finalhour, expected_total_lecture = $finalecture WHERE subject_code = $sub and faculty_id = $fac and semester = $sem and dept_id = $dept_id and lecture_type = '".$lectype."' and type = '".$type."'";
                    if(mysqli_query($conn, $sqlorigupdate)&& mysqli_query($conn, $sqldupupdate)){
                        $status=TRUE;
                    }else{
                        $status=FALSE;
                    }
                }else{
                    $status=true;
                }
            }else if($lectype==="practical"){
                $lefthour = $_SESSION['prac_hour_left'];
                $updatehour = $lefthour-$hours;
                
                $finalhour = $allocatedhour+$hours;
                $finalecture = $allocatedlecture+$expected_lecture;
                
                $sqlupdate = "UPDATE track_practical_hour SET total_practical = $updatehour WHERE type = '".$type."' and subject_code = $sub";
                
                if(mysqli_query($conn, $sqlupdate)){
                    $sqldupupdate = "UPDATE duplicate_subject_faculty_allocation SET total_hours = $finalhour, expected_total_lecture = $finalecture WHERE batch_year = $batch_year and subject_code = $sub and faculty_id = $fac and semester = $sem and dept_id = $dept_id and lecture_type = '".$lectype."' and type = '".$type."'";
                    $sqlorigupdate = "UPDATE subject_faculty_allocation SET total_hours = $finalhour, expected_total_lecture = $finalecture WHERE subject_code = $sub and faculty_id = $fac and semester = $sem and dept_id = $dept_id and lecture_type = '".$lectype."' and type = '".$type."'";
                    if(mysqli_query($conn, $sqlorigupdate)&& mysqli_query($conn, $sqldupupdate)){
                        $status=TRUE;
                    }else{
                        $status=FALSE;
                    }
                }else{
                    $status= FALSE;
                }
            }
            
            if($status){
                mysqli_commit($conn);
                echo 'Updated Successfully';
            }else{
                mysqli_rollback($conn);
                echo 'Not Eligible';
            }
            
//            echo "These Allocation Is Already Present";
        }else{
            $status=FALSE;
            mysqli_autocommit($conn, FALSE);
            if($lectype=="theory"){
                
                $lefthour = $_SESSION['lec_hour_left'];
                $updatehour = $lefthour-$hours;
                
                $sqlupdate = "UPDATE track_theory_hour SET total_theory = $updatehour WHERE type = '".$type."' and subject_code = $sub";
                
                if(mysqli_query($conn, $sqlupdate)){
                    $sqlinsertdup = "INSERT INTO duplicate_subject_faculty_allocation(batch_year,subject_code,faculty_id,semester,dept_id,lecture_type,type,total_hours,expected_total_lecture) "
                            . "VALUES($batch_year,$sub,$fac,$sem,$dept_id,'".$lectype."','".$type."',$hours,$expected_lecture)";
                    
                    $sqlinsertorig = "INSERT INTO subject_faculty_allocation(subject_code,faculty_id,semester,dept_id,lecture_type,type,total_hours,expected_total_lecture) "
                            . "VALUES($sub,$fac,$sem,$dept_id,'".$lectype."','".$type."',$hours,$expected_lecture)";
                    
                    if(mysqli_query($conn, $sqlinsertdup) && mysqli_query($conn, $sqlinsertorig)){
                        $status = TRUE;
                    }else{
                        $status=FALSE;
                    }                    
                }else{
                    $status=FALSE;
                }
                
                if($status){
                    mysqli_commit($conn);
                    echo "Subject Allocation Succeeded";
                }else{
                    mysqli_rollback($conn);
                    echo "Subject Allocation Failed! Try After Some Time";
                }
                
            }else if($lectype=="practical"){
                
                $lefthour = $_SESSION['prac_hour_left'];
                $updatehour = $lefthour-$hours;
                
                $sqlupdate = "UPDATE track_practical_hour SET total_practical = $updatehour WHERE type = '".$type."' and subject_code = $sub";
                
                if(mysqli_query($conn, $sqlupdate)){
                    
                    $sqlinsertdup = "INSERT INTO duplicate_subject_faculty_allocation(batch_year,subject_code,faculty_id,semester,dept_id,lecture_type,type,total_hours,expected_total_lecture) "
                            . "VALUES($batch_year,$sub,$fac,$sem,$dept_id,'".$lectype."','".$type."',$hours,$expected_lecture)";
                    
                    $sqlinsertorig = "INSERT INTO subject_faculty_allocation(subject_code,faculty_id,semester,dept_id,lecture_type,type,total_hours,expected_total_lecture) "
                            . "VALUES($sub,$fac,$sem,$dept_id,'".$lectype."','".$type."',$hours,$expected_lecture)";
                    
                    if(mysqli_query($conn, $sqlinsertdup) && mysqli_query($conn, $sqlinsertorig)){
                        $status = TRUE;
                    }else{
                        $status=FALSE;
                    }                    
                }else{
                    $status=FALSE;
                }
                
                if($status){
                    mysqli_commit($conn);
                    echo "Subject Allocation Succeeded";
                }else{
                    mysqli_rollback($conn);
                    echo "Subject Allocation Failed! Try After Some Time";
                }
            }
        }
    }
}else{
    header("Location: ../../index.php");
}