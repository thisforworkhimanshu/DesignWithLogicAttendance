<?php

session_start();

if (isset($_POST['lec_type']) && isset($_POST['div']) && isset($_POST['sub'])) {
    $lec_type = $_POST['lec_type'];
    $div = $_POST['div'];
    $subcode = $_POST['sub'];
    $fac_id = $_SESSION['fid'];
    $dept_id = 16;

    include '../../Connection.php';
    $conn = new Connection();
    $db = $conn->createConnection();

    $uploadJson = array();
    $appendSql = '';
    if ($lec_type == 'theory') {
        $appendSql = " AND student_division = '$div'";
    } else {
        $appendSql = " AND student_batch = '$div'";
    }

    $sGetSem = "SELECT semester FROM subject WHERE subject_code = $subcode LIMIT 1";
    $rGetSem = $db->query($sGetSem);
    $temp = $rGetSem->fetch_object();
    $sem = $temp->semester;

    $sGetStud = "SELECT student_enrolment,student_name FROM student WHERE student_semester = $sem" . $appendSql;
    $rGetStud = $db->query($sGetStud);
    if ($rGetStud->num_rows > 0) {
        while ($row = $rGetStud->fetch_assoc()) {
            $enrolment = $row['student_enrolment'];
            $name = $row['student_name'];

            $record = array();
            $record['enrolment'] = $enrolment;
            $record['name'] = $name;

            $sgetAttend = "SELECT date,is_present FROM attendance_of_$dept_id INNER JOIN lecture_tb_$dept_id ON attendance_of_$dept_id.lecture_id = lecture_tb_$dept_id.lecture_id where subject_code = $subcode and enrolment = $enrolment and faculty_id = $fac_id AND division = '$div'";
            $rgetAttend = $db->query($sgetAttend);
            if ($rgetAttend->num_rows > 0) {
                while ($dates = $rgetAttend->fetch_assoc()) {
                    $date = $dates['date'];
                    $record[$date] = $dates['is_present'];
                }
            }
            $uploadJson[] = $record;
        }
    }
    echo json_encode($uploadJson);
}