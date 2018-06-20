<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_POST['semester'])){
    session_start();
    $dept_id= $_SESSION['s_dept_id'];
    $enrolment = $_SESSION['enrolment'];
    $semester = $_POST['semester'];
    
    require_once '../../Connection.php';
    $connection = new Connection();
    $conn = $connection->createConnection("college");
    
    $sqlGetSubject = "select subject_code,subject_name from subject where dept_id = $dept_id and semester = $semester";
    $resultSub = mysqli_query($conn, $sqlGetSubject);
    if(mysqli_num_rows($resultSub)>0){
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped table-hover">'
        . '<tr>'
                . '<th colspan="4" class="text-center">Semester: '.$semester.' </th>'
        . '</tr>'
        . '<tr>'
                . '<th>Subject Code</th>'
                . '<th>Subject Name</th>'
                . '<th>Mid Marks</th>'
                . '<th>Re-Mid</th>'
        . '</tr>';
        while ($row = mysqli_fetch_assoc($resultSub)) {
            $sub_code = $row['subject_code'];
            $sub_name = $row['subject_name'];
            $sqlGetMarkMid = "select ".$sub_code."_m as mid from sem".$semester."_".$dept_id." where enrolment = $enrolment";
            $resultmid = mysqli_query($conn, $sqlGetMarkMid);
            $rowmid = mysqli_fetch_assoc($resultmid);
            $midmark = $rowmid['mid'];
            if($midmark<12){
                $sqlGetMarkreMid = "select ".$sub_code."_r as remid from sem".$semester."_".$dept_id."_r where enrolment = $enrolment";
                $resultremid = mysqli_query($conn, $sqlGetMarkreMid);
                $rowremid = mysqli_fetch_assoc($resultremid);
                $remidmark = $rowremid['remid'];
            }else{
                $remidmark = "--";
            }
            
            echo '<tr>'
                        . '<td>'.$sub_code.'</td>'
                        . '<td>'.$sub_name.'</td>'
                        . '<td>'.$midmark.'</td>'
                        . '<td>'.$remidmark.'</td>'
                . '</tr>';
        }
        echo '</table>'
        . '</div>';
    }else{
        echo 'No Data';
    }
}
