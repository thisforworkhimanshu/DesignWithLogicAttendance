<?php

session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_POST['jsonData'])) {
    $data = json_decode($_POST['jsonData']);
    $div = $data->div;
    $lec_id = $data->lec_id;
    $abenrol = $data->enrolment;
    $sem = $data->sem;
    $lec_type = $data->lec_type;
    $dept_id = $_SESSION['f_dept_id'];

    include '../../Connection.php';
    $conn = new Connection();
    $db = $conn->createConnection();
    $appendSql = '';
    if ($lec_type == 'theory') {
        $appendSql = " AND student_division = '$div'";
    } else {
        $appendSql = " AND student_batch = '$div'";
    }

    $sGetStud = "SELECT student_enrolment FROM student WHERE student_semester = $sem" . $appendSql;
    $rGetStud = $db->query($sGetStud);
    if ($rGetStud->num_rows > 0) {

        $sInsertEnrol = "";
        while ($row = $rGetStud->fetch_assoc()) {
            $enrolment = $row['student_enrolment'];
            $sInsertEnrol .= "INSERT INTO attendance_of_$dept_id (enrolment,lecture_id,is_present) VALUES ($enrolment,$lec_id,1);";
        }
        if ($db->multi_query($sInsertEnrol) === TRUE) {
            $sInsertAbsent = '';
            $i = 0;
            for ($i; $i < count($abenrol); $i++) {
                $enrolment = $abenrol[$i];
                $sInsertAbsent .= "UPDATE attendance_of_$dept_id SET is_present = 0 WHERE enrolment = $enrolment AND lecture_id = $lec_id ;";
            }
            $db->close();
            $db2 = $conn->createConnection();
            if ($db2->multi_query($sInsertAbsent) === TRUE) {
                echo 'absent count: '.$i;
                unset($_SESSION['lec_id']);
                unset($_SESSION['division']);
                unset($_SESSION['lec_type']);
                unset($_SESSION['subject']);
            } else {
                echo $db2->error;
            }
        }
    }
}