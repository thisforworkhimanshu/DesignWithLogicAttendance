<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_POST['facultyid'])){
    
    $conn = mysqli_connect("localhost", "root", "", "college");
    if(!$conn){
        die('Failed');
    }

    session_start();

    $dept_id = $_SESSION['a_dept_id'];
    
    $facultyid = $_POST['facultyid'];

    $sql = "SELECT * FROM faculty where faculty_id = $facultyid";

    $result = mysqli_query($conn, $sql);

    $return_arr = array();
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            $rowarray['faculty_fname'] = $row['faculty_fname'];
            $rowarray['faculty_uname'] = $row['faculty_uname'];
            $rowarray['faculty_pass'] = $row['faculty_pass'];
            $rowarray['dept_id'] = $row['dept_id'];
            $rowarray['faculty_email'] = $row['faculty_email'];
            $rowarray['faculty_cellno'] = $row['faculty_cellno'];
            $rowarray['faculty_gender'] = $row['faculty_gender'];
            array_push($return_arr, $rowarray);
        }
        echo json_encode($return_arr);
    }
}
