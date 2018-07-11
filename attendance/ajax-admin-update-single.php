<?php

session_start();
$dept_id = $_SESSION['a_dept_id'];
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../Connection.php';
$conn = new Connection();
$db = $conn->createConnection();
if (isset($_POST['singleDate']) && isset($_POST['lec_type']) && isset($_POST['div'])) {
    $date = $_POST['singleDate'];
    $lec_type = $_POST['lec_type'];
    $div = $_POST['div'];

    $sGetSub = "SELECT l.date,l.subject_code,s.short_name,f.faculty_id,f.faculty_uname FROM lecture_tb_$dept_id as l INNER JOIN subject as s ON l.subject_code = s.subject_code INNER JOIN faculty as f ON l.faculty_id = f.faculty_id WHERE l.date = '$date' AND l.type = '$lec_type' AND l.division= '$div'";
    $rGetSub = $db->query($sGetSub);

    $uploadJson = array();
    if ($rGetSub->num_rows > 0) {
        while ($row = $rGetSub->fetch_assoc()) {
            $obj = array();
            $obj['sub_code'] = $row['subject_code'];
            $obj['sub_name'] = $row['short_name'];
            $obj['fac_id'] = $row['faculty_id'];
            $obj['fac_name'] = $row['faculty_uname'];

            $uploadJson[] = $obj;
        }
        echo json_encode($uploadJson);
    }
}

if (isset($_POST['sendData'])) {
    $data = json_decode($_POST['sendData']);
    $date = $data->singleDate;
    $lec_type = $data->lec_type;
    $div = $data->div;
    $sel = $data->sel;
    $fac_id = $data->fac_id;
    $sub_code = $data->sub_code;
    $action = $data->action;
    $lec_id;
    $sCheckLec = "SELECT lecture_id FROM lecture_tb_$dept_id WHERE date='$date' AND faculty_id = $fac_id AND subject_code = $sub_code AND type = '$lec_type' AND division = '$div' LIMIT 1";
    $rCheckLec = $db->query($sCheckLec);
    if ($rCheckLec->num_rows > 0) {
        $obj = mysqli_fetch_object($rCheckLec);
        $lec_id = $obj->lecture_id;

        $sUpdateAction = '';
        $i = 0;
        for ($i; $i < count($sel); $i++) {
            $enrol = $sel[$i];
            $sUpdateAction .= "UPDATE attendance_of_$dept_id SET is_present = $action WHERE enrolment = $enrol AND lecture_id = $lec_id;";
        }
        if ($db->multi_query($sUpdateAction) === TRUE) {
            echo 'change count: ' . $i;
        } else {
            echo $db->error;
        }
    }
}

if (isset($_POST['sendDataBulk'])) {
    $data = json_decode($_POST['sendDataBulk']);
    $dates = $data->dates;
    $sel = $data->sel;
    $action = $data->action;

    foreach ($dates as $date) {
        echo $date;
        $sGetLecIds = "SELECT lecture_id FROM lecture_tb_$dept_id WHERE date = '$date'";
        $rGetLecIds = $db->query($sGetLecIds);
        if ($rGetLecIds->num_rows > 0) {
            while ($row = $rGetLecIds->fetch_assoc()) {
                $lec_id = $row['lecture_id'];
                foreach ($sel as $enrol) {
                    $sUpdateBulk = "UPDATE attendance_of_$dept_id SET is_present = $action WHERE enrolment = $enrol";
                    $rUpdateBulk = $db->query($sUpdateBulk);
                    if($rUpdateBulk == TRUE) {
                        echo 'ok';
                    } else {
                        echo $db->error();
                    }
                }
            }
        } else {
            echo $db->error();
        }
    }
}
    