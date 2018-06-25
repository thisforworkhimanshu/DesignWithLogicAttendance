<?php

session_start();
$fac_id = $_SESSION['fid'];
include '../../Connection.php';
$conn = new Connection();
$db = $conn->createConnection();
$uploadJson = array();

if (isset($_POST['lec_type'])) {
    $lec_type = $_POST['lec_type'];
    $sgetSub = "SELECT DISTINCT f.subject_code,s.short_name FROM sub_fac_allocation as f LEFT JOIN subject as s ON f.subject_code = s.subject_code WHERE f.faculty_id = $fac_id AND lecture_type = '$lec_type'";
    $rgetSub = $db->query($sgetSub);
    if ($rgetSub->num_rows > 0) {
        while ($row = $rgetSub->fetch_assoc()) {
            $uploadJson[] = $row;
        }
        echo json_encode($uploadJson);
    }
}

if (isset($_POST['lec_typed']) && isset($_POST['sub'])) {
    $lec_type = $_POST['lec_typed'];
    $sub_code = $_POST['sub'];
    $sgetDiv = "SELECT DISTINCT type FROM sub_fac_allocation WHERE faculty_id = $fac_id AND lecture_type = '$lec_type' AND subject_code = $sub_code";
    $rgetDiv = $db->query($sgetDiv);
    if ($rgetDiv->num_rows > 0) {
        while ($row = $rgetDiv->fetch_assoc()) {
            $uploadJson[] = $row['type'];
        }
        echo json_encode($uploadJson);
    }
}