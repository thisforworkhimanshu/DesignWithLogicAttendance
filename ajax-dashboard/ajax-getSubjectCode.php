<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$dept_id = $_SESSION['f_dept_id'];
$fac_id = $_SESSION['fid'];

require_once '../Connection.php';

$connection = new Connection();
$conn = $connection->createConnection();

$sqlGetSubjectCode = "SELECT DISTINCT subject_code from subject_faculty_allocation where dept_id = $dept_id and faculty_id = $fac_id";
$resultGetSubject = mysqli_query($conn, $sqlGetSubjectCode);
if(mysqli_num_rows($resultGetSubject)>0){
    echo '<option>--Select Subject Code--</option>';
    while($row = mysqli_fetch_assoc($resultGetSubject)){
        echo '<option value='.$row['subject_code'].'>'.$row['subject_code'].'</option>';
    }
}else{
    echo "No Data Present";
}