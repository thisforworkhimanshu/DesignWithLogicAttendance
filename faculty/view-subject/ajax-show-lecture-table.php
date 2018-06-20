<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['semester'])){
    
    session_start();
    $fid = $_SESSION['fid'];
    $dept_id = $_SESSION['f_dept_id'];
    $semester = $_POST['semester'];
    require_once '../../Connection.php';
    $connection = new Connection();
    $conn = $connection->createConnection("college");
    
    if(!$conn){
        die('Connection Failed');
    }else{
        $sqlget = "SELECT subject_code,lecture_type,type FROM subject_faculty_allocation where semester = $semester and faculty_id = $fid and dept_id = $dept_id";
        $resultget = mysqli_query($conn, $sqlget);
        if(mysqli_num_rows($resultget)>0){
            echo '<div class="table-responsive">';
            echo '<table border=1 class="table table-striped table-hover table-borderless">';
                echo '<tr>'
                        . '<th>Subject Code</th>'
                        . '<th>Subject Name</th>'
                        . '<th>Theory/Practical'
                        . '<th>Division/Batch</th>';
                echo '</tr>';
                
            while($row = mysqli_fetch_assoc($resultget)){
                $division = $row['type'];
                $sub_code = $row['subject_code'];
                $lectype = $row['lecture_type'];
                if($lectype==="theory"){
                    $lectype = "Theory";
                }else{
                    $lectype = "Practical";
                }
                $sqlsubname = "SELECT subject_name from subject where subject_code = $sub_code";
                $resultname = mysqli_query($conn, $sqlsubname);
                $rowname = mysqli_fetch_assoc($resultname);
                $sub_name = $rowname['subject_name'];
                echo '<tr>'
                        . '<td>'.$sub_code.'</td>'
                        . '<td>'.$sub_name.'</td>'
                        . '<td>'.$lectype.'</td>'
                        . '<td>'.$division.'</td>';
                echo '</tr>';
            }
            echo '</div>';
        }else{
            echo 'No data Present';
        }
    }
}else{
    header("Location: view-subject-lecture.php");
}