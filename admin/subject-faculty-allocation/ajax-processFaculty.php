<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['subject'])){
    
    $conn = mysqli_connect("localhost", "root", "", "college");
    if(!$conn){
        die('Failed');
    }

    session_start();

    $dept_id = $_SESSION['a_dept_id'];
    $sem = $_POST['semester'];
    
    if($sem==1||$sem==2){
        $sql = "SELECT * FROM faculty where dept_id  in ($dept_id,1)";
    } else {
        $sql = "SELECT * FROM faculty where dept_id  = $dept_id";
    }
    
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result)>0){
        echo "<option value='null'>--Select Faculty--</option>";
        while($row = mysqli_fetch_assoc($result)){
            $fac_id = $row['faculty_id'];
            $fac_name = $row['faculty_fname'];

            echo "<option value='".$fac_id."'>$fac_name</option>";
        }
    }

}

