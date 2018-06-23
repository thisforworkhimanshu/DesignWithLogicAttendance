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
        
        session_start();
        $semester = $_SESSION['batch_sem'];
        
        if($semester==1||$semester==2){
            if($divVal==="B1"){
                $conn->where("batch_year",$batchyear);
                $result = $conn->getOne("student");
                $from = $result['student_enrolment'];

                $sqlavg = "SELECT student_enrolment FROM ( SELECT student_enrolment,batch_year FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment ASC LIMIT 25) AS T WHERE batch_year = $batchyear ORDER BY student_enrolment DESC LIMIT 1";
                $resultavg = $conn->ObjectBuilder()->rawQueryOne($sqlavg);
                $upto = ($resultavg->student_enrolment);

                $return_arr = array("toenrol"=>$upto,"fromenrol"=>$from);

                $jsonObj = json_encode($return_arr);
                echo $jsonObj;
                
            }else if($divVal==="B2"){
                
                $sqlfrom = "SELECT student_enrolment FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment ASC LIMIT 25 OFFSET 25";
                $resultfrom = $conn->ObjectBuilder()->rawQueryOne($sqlfrom);
                $from = ($resultfrom->student_enrolment);
                
                $sqlto = "SELECT student_enrolment FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment ASC LIMIT 25 OFFSET 49";
                $resultto = $conn->ObjectBuilder()->rawQueryOne($sqlto);
                $upto = ($resultto->student_enrolment);

                $return_arr = array("toenrol"=>$upto,"fromenrol"=>$from);

                $jsonObj = json_encode($return_arr);
                echo $jsonObj;
                
            }else if($divVal==="B3"){
                
                $sqlfrom = "SELECT student_enrolment FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment ASC LIMIT 25 OFFSET 50";
                $resultfrom = $conn->ObjectBuilder()->rawQueryOne($sqlfrom);
                $from = ($resultfrom->student_enrolment);
                
                $sqlto = "SELECT student_enrolment FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment ASC LIMIT 25 OFFSET 74";
                $resultto = $conn->ObjectBuilder()->rawQueryOne($sqlto);
                $upto = ($resultto->student_enrolment);

                $return_arr = array("toenrol"=>$upto,"fromenrol"=>$from);

                $jsonObj = json_encode($return_arr);
                echo $jsonObj;
            }else if($divVal==="B4"){
                
                $sqlfrom = "SELECT student_enrolment FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment ASC LIMIT 25 OFFSET 75";
                $resultfrom = $conn->ObjectBuilder()->rawQueryOne($sqlfrom);
                $from = ($resultfrom->student_enrolment);
                
                $sqlto = "SELECT student_enrolment FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment DESC LIMIT 1";
                $resultto = $conn->ObjectBuilder()->rawQueryOne($sqlto);
                $upto = ($resultto->student_enrolment);

                $return_arr = array("toenrol"=>$upto,"fromenrol"=>$from);

                $jsonObj = json_encode($return_arr);
                echo $jsonObj;
            }
        }else{
            if($divVal==="B1"){
                $conn->where("batch_year",$batchyear);
                $result = $conn->getOne("student");
                $from = $result['student_enrolment'];

                $sqlavg = "SELECT student_enrolment FROM ( SELECT student_enrolment,batch_year FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment ASC LIMIT 25) AS T WHERE batch_year = $batchyear ORDER BY student_enrolment DESC LIMIT 1";
                $resultavg = $conn->ObjectBuilder()->rawQueryOne($sqlavg);
                $upto = ($resultavg->student_enrolment)-1;

                $return_arr = array("toenrol"=>$upto,"fromenrol"=>$from);

                $jsonObj = json_encode($return_arr);
                echo $jsonObj;
                
            }else if($divVal==="B2"){
                
                $sqlfrom = "SELECT student_enrolment FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment ASC LIMIT 25 OFFSET 25";
                $resultfrom = $conn->ObjectBuilder()->rawQueryOne($sqlfrom);
                $from = ($resultfrom->student_enrolment);
                
                $sqlto = "SELECT student_enrolment FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment ASC LIMIT 25 OFFSET 50";
                $resultto = $conn->ObjectBuilder()->rawQueryOne($sqlto);
                $upto = ($resultto->student_enrolment);

                $return_arr = array("toenrol"=>$upto,"fromenrol"=>$from);

                $jsonObj = json_encode($return_arr);
                echo $jsonObj;
                
            }else if($divVal==="B3"){
                
                $sqlfrom = "SELECT student_enrolment FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment ASC LIMIT 25 OFFSET 51";
                $resultfrom = $conn->ObjectBuilder()->rawQueryOne($sqlfrom);
                $from = ($resultfrom->student_enrolment);
                
                $sqlto = "SELECT student_enrolment FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment ASC LIMIT 25 OFFSET 75";
                $resultto = $conn->ObjectBuilder()->rawQueryOne($sqlto);
                $upto = ($resultto->student_enrolment);

                $return_arr = array("toenrol"=>$upto,"fromenrol"=>$from);

                $jsonObj = json_encode($return_arr);
                echo $jsonObj;
            }else if($divVal==="B4"){
                
                $sqlfrom = "SELECT student_enrolment FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment ASC LIMIT 25 OFFSET 76";
                $resultfrom = $conn->ObjectBuilder()->rawQueryOne($sqlfrom);
                $from = ($resultfrom->student_enrolment);
                
                $sqlto = "SELECT student_enrolment FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment ASC LIMIT 25 OFFSET 100";
                $resultto = $conn->ObjectBuilder()->rawQueryOne($sqlto);
                $upto = ($resultto->student_enrolment);

                $return_arr = array("toenrol"=>$upto,"fromenrol"=>$from);

                $jsonObj = json_encode($return_arr);
                echo $jsonObj;
                
            }else if($divVal==="B5"){
                
                $sqlfrom = "SELECT student_enrolment FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment ASC LIMIT 25 OFFSET 101";
                $resultfrom = $conn->ObjectBuilder()->rawQueryOne($sqlfrom);
                $from = ($resultfrom->student_enrolment);
                
                $sqlto = "SELECT student_enrolment FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment ASC LIMIT 25 OFFSET 125";
                $resultto = $conn->ObjectBuilder()->rawQueryOne($sqlto);
                $upto = ($resultto->student_enrolment);

                $return_arr = array("toenrol"=>$upto,"fromenrol"=>$from);

                $jsonObj = json_encode($return_arr);
                echo $jsonObj;
            }else if($divVal==="B6"){
                
                $sqlfrom = "SELECT student_enrolment FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment ASC LIMIT 25 OFFSET 126";
                $resultfrom = $conn->ObjectBuilder()->rawQueryOne($sqlfrom);
                $from = ($resultfrom->student_enrolment);
                
                $sqlto = "SELECT student_enrolment FROM student WHERE batch_year = $batchyear ORDER BY student_enrolment DESC LIMIT 1";
                $resultto = $conn->ObjectBuilder()->rawQueryOne($sqlto);
                $upto = ($resultto->student_enrolment);

                $return_arr = array("toenrol"=>$upto,"fromenrol"=>$from);

                $jsonObj = json_encode($return_arr);
                echo $jsonObj;
            }
        }
    }
}
