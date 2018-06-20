<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_POST['batchyear'])&&isset($_POST['divVal'])){
    require_once '../../Connection.php';
    $connection = new Connection();
    $conn = $connection->Connect("college");
    if(!$conn){
        die("Connection Failed");
    }else{
        $batchyear = $_POST['batchyear'];
        $divVal = $_POST['divVal'];
        if($divVal==="A"){
            $conn->where("batch_year",$batchyear);
            $result = $conn->getOne("student");
            $from = $result['student_enrolment'];
            
            $sqlcount="SELECT COUNT(*) as total FROM `student` where batch_year = $batchyear";
            $resultcount = $conn->ObjectBuilder()->rawQueryOne($sqlcount);
            $no_of_row = $conn->count;
            $totalstud = $resultcount->total;
            
            $limit = floor($totalstud/2);
            
            $sqlavg = "SELECT student_enrolment FROM (SELECT * FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment DESC LIMIT $limit) AS T WHERE batch_year = $batchyear ORDER BY student_enrolment ASC LIMIT 1";
            $resultavg = $conn->ObjectBuilder()->rawQueryOne($sqlavg);
            $upto = ($resultavg->student_enrolment)-1;
            
            $return_arr = array("toenrol"=>$upto,"fromenrol"=>$from);
            
            $jsonObj = json_encode($return_arr);
            echo $jsonObj;
        }else if($divVal==="B"){
            
            $sqllast = "SELECT * FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment DESC LIMIT 1";
            $resultlast = $conn->ObjectBuilder()->rawQueryOne($sqllast);
            $upto = $resultlast->student_enrolment;
            
            $sqlcount="SELECT COUNT(*) as total FROM `student` where batch_year = $batchyear";
            $resultcount = $conn->ObjectBuilder()->rawQueryOne($sqlcount);
            $no_of_row = $conn->count;
            $totalstud = $resultcount->total;
            
            $limit = floor($totalstud/2);
            
            $sqlavg = "SELECT student_enrolment FROM (SELECT * FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment DESC LIMIT $limit) AS T WHERE batch_year = $batchyear ORDER BY student_enrolment ASC LIMIT 1";
            $resultavg = $conn->ObjectBuilder()->rawQueryOne($sqlavg);
            $from = ($resultavg->student_enrolment);
            
            $return_arr = array("toenrol"=>$upto,"fromenrol"=>$from);
            
            $jsonObj = json_encode($return_arr);
            echo $jsonObj;
        }
        
    }
}
