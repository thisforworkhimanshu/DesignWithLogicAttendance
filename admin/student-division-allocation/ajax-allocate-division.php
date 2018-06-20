<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_POST['toenrol'])&& isset($_POST['fromenrol'])&& isset($_POST['divVal']) && isset($_POST['batchyear'])){
    $fromenrol = $_POST['fromenrol'];
    $toenrol = $_POST['toenrol'];
    $divVal = $_POST['divVal'];
    $batchyear = $_POST['batchyear'];
    
    require_once '../../Connection.php';
    $connection = new Connection();
    $conn = $connection->Connect("college");
    
    if(!$conn){
        die("Connection Failed");
    }else{
        $sqlsel = "Select student_enrolment from student where student_enrolment<=? AND student_enrolment>=? AND batch_year = ? ";
        $bindparam = array($toenrol,$fromenrol,$batchyear);
        $enrolments = $conn->rawQuery($sqlsel,$bindparam);
        $data = Array("student_division"=>$divVal);
        foreach ($enrolments as $enrolment) {
            $enrol = $enrolment['student_enrolment'];
            $conn->where("student_enrolment",$enrol);
            $conn->update('student',$data);
        }
        $affected = $conn->count;
        if($affected>0){
            echo "ok";
        }
    }
}
