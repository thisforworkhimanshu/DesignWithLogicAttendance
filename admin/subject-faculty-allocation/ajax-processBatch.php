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

$sql = "SELECT DISTINCT(student_batch) as batch FROM student WHERE student_batch IS NOT NULL AND student_semester= ".$sem." AND student_dept_id = ".$dept_id;

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result)>0){
    echo "<option value='null'>--Select Batch--</option>";
    while($row = mysqli_fetch_assoc($result)){
        $div = $row['batch'];
        
        echo "<option value='".$div."'>$div</option>";
    }
}

