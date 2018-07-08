<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../Connection.php';
$conn = new Connection();
$db = $conn->createConnection();
if (isset($_POST['semester']) && isset($_POST['div'])) {

    $sem = $_POST['semester'];
    $div = $_POST['div'];
    $lec_type = $_POST['lec_type'];
    $dept_id = 16;
    $appendSql = '';
    if (isset($_POST['dateFrom']) && isset($_POST['dateTo'])) {
        if ($_POST['dateFrom'] != '' && $_POST['dateTo'] != '') {
//            echo 'php date: ' . $_POST['dateFrom'] . ' to ' . $_POST['dateTo'];
            $dateFrom = $_POST['dateFrom'];
            $dateTo = $_POST['dateTo'];
            $appendSql = " AND date BETWEEN '" . $dateFrom . "' AND '" . $dateTo . "'";
//            $appendSql = " AND date BETWEEN '2018-06-08' AND '2018-06-09'";
        }
    }

    $uploadJson = array();
    $appendSql2 = '';
    if ($lec_type == 'theory') {
        $appendSql2 = " AND student_division = '$div'";
    } else {
        $appendSql2 = " AND student_batch = '$div'";
    }
    $qStudDetail = "SELECT student_enrolment,student_name FROM student WHERE student_semester = $sem" . $appendSql2;
    $rStudDetail = $db->query($qStudDetail);

    $sSubjects = "SELECT * FROM subject WHERE semester = $sem";
    $rsubject = $db->query($sSubjects);

    //count total conducted lecture of particular subjets
    $toalLec = array();
    while ($sub = $rsubject->fetch_assoc()) {
        $subcode = $sub['subject_code'];
        $short_name = $sub['short_name'];
        $stotalLec = "SELECT COUNT(DISTINCT lecture_id) as c FROM lecture_tb_$dept_id WHERE subject_code = $subcode AND division = '$div'" . $appendSql;
        $rtotalLec = $db->query($stotalLec);
        $temp = mysqli_fetch_object($rtotalLec);
        $toalLec[$short_name] = $temp->c;
    }
    $rsubject->data_seek(0);

    if ($rStudDetail->num_rows > 0) {
        while ($row = $rStudDetail->fetch_assoc()) {
            $enrolment = $row['student_enrolment'];
            $name = $row['student_name'];
            $record = array();
            $record['enrolment'] = $enrolment;
            $record['name'] = $name;
            while ($sub = $rsubject->fetch_assoc()) {
                $subcode = $sub['subject_code'];
                $short_name = $sub['short_name'];

                //count and set total and attend lecture of student
                $sgetAttend = "SELECT COUNT(*) as c FROM attendance_of_$dept_id INNER JOIN lecture_tb_$dept_id ON attendance_of_$dept_id.lecture_id = lecture_tb_$dept_id.lecture_id where subject_code = $subcode and enrolment = $enrolment and is_present = 1 AND division = '$div'" . $appendSql;
                $rgetAttend = $db->query($sgetAttend);
                $temp = mysqli_fetch_object($rgetAttend);
                $attend = $temp->c;
                $record[$short_name]['attend'] = $attend;
                $record[$short_name]['total'] = $toalLec[$short_name];
            }
            $rsubject->data_seek(0);
            $uploadJson[] = $record;
        }
    }

    echo json_encode($uploadJson);
}

//for criteria adjust setting store

if (isset($_POST['criteria'])) {
    $criteria = $_POST['criteria'];
    $sSetCriteria = "UPDATE basic_settings SET setting_value = $criteria WHERE setting_key = 'criteria'";
    if ($db->query($sSetCriteria) === TRUE) {
        echo $criteria;
    }
}
    