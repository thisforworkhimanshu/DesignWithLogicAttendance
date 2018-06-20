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

$sem = $_POST['semester'];

$sqlgetYear = "SELECT DISTINCT(batch_year) as batch_year FROM student where student_semester = $sem";
$resultYear = mysqli_query($conn, $sqlgetYear);
$row = mysqli_fetch_object($resultYear);
$_SESSION['batch_year'] = $row->batch_year;


$sql = "SELECT subject_code,subject_name FROM subject where semester = $sem and dept_id = $dept_id";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result)>0){
    echo "<option value='null'>--Select Subject--</option>";
    while($row = mysqli_fetch_assoc($result)){
        $sub_code = $row['subject_code'];
        $sub_name = $row['subject_name'];
         
        echo "<option value='".$sub_code."'>$sub_name</option>";
    }
}
