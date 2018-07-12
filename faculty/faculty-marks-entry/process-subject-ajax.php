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

$dept_id = $_SESSION['f_dept_id'];
$fid = $_SESSION['fid'];

$sem = $_POST['semester'];

if($dept_id==1){
    $sql = "SELECT DISTINCT(subject_code) FROM subject_faculty_allocation where semester = $sem and faculty_id = $fid";
}else{
    $sql = "SELECT DISTINCT(subject_code) FROM subject_faculty_allocation where semester = $sem and dept_id = $dept_id and faculty_id = $fid";
}

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result)>0){
    echo "<option value='null'>--Select Subject--</option>";
    while($row = mysqli_fetch_assoc($result)){
        $sub_code = $row['subject_code'];
        $sqlname = "SELECT subject_name FROM subject where subject_code = $sub_code";
        $resultname = mysqli_query($conn, $sqlname);
        $rowname = mysqli_fetch_assoc($resultname);
        $sub_name = $rowname['subject_name'];
         
        echo "<option value='".$sub_code."'>$sub_name</option>";
    }
}
