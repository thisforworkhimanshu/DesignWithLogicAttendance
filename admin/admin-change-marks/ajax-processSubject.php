<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$conn = mysqli_connect("localhost", "root", "", "college");

if(!$conn){
    die('Failed');
}

session_start();

$dept_id = $_SESSION['a_dept_id'];

$semester = $_POST['semester'];
$examtype = $_POST['examtype'];

$sqlgetYear = "SELECT DISTINCT(batch_year) as batch_year FROM student where student_semester = $sem";
$resultYear = mysqli_query($conn, $sqlgetYear);
$row = mysqli_fetch_object($resultYear);
$_SESSION['batch_year'] = $row->batch_year;

if($examtype=="m"||$examtype=="r"){
    $sqlsubject = "SELECT subject.subject_code,subject.subject_name,teaching_scheme.total_theory FROM subject INNER JOIN teaching_scheme ON teaching_scheme.subject_code=subject.subject_code WHERE subject.semester= $semester and subject.dept_id= $dept_id and teaching_scheme.total_theory >0";
    $resultSubject = mysqli_query($conn, $sqlsubject);
    
}else if($examtype=="v"){
    $sqlsubject = "SELECT subject.subject_code,subject.subject_name,teaching_scheme.total_theory FROM subject INNER JOIN teaching_scheme ON teaching_scheme.subject_code=subject.subject_code WHERE subject.semester= $semester and subject.dept_id= $dept_id and teaching_scheme.total_practical >0";
    $resultSubject = mysqli_query($conn, $sqlsubject);
}

if(mysqli_num_rows($resultSubject)>0){
    echo "<option value='null'>--Select Subject--</option>";
    while($row = mysqli_fetch_assoc($resultSubject)){
        $sub_code = $row['subject_code'];
        $sub_name = $row['subject_name'];
         
        echo "<option value='".$sub_code."'>$sub_name</option>";
    }
}
