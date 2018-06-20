<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_POST['lecture_hour'])||isset($_POST['subcode'])){
    
    $subcode = $_POST['subcode'];
    $lechours = $_POST['lecture_hour'];
    $type= $_POST['type'];
    
    require_once '../../Connection.php';
    $connection = new Connection();
    $conn = $connection->createConnection("college");
    if(!$conn){
        die('Failed');
    }else{
        $sqlcheck = "SELECT * FROM `track_practical_hour` WHERE subject_code=".$subcode." and type = '".$type."'";
        $result = mysqli_query($conn, $sqlcheck);
        if(mysqli_num_rows($result)>0){
            $row = mysqli_fetch_assoc($result);
            $lechoursrow = $row['total_practical'];
            if($lechoursrow<$lechours){
                echo "noteligible";
            }else{
                session_start();
                $_SESSION['prac_hour_left'] = $row['total_practical'];
                echo "eligible";
            }
        }else{
            echo "noteligible";
        }
    }
}
