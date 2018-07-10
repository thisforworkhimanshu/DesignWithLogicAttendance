<?php

session_start();
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
    $dept_id = $_SESSION['a_dept_id'];

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
    $fac_id = $data->fac_id
    $action = $data->action;
    
    
}