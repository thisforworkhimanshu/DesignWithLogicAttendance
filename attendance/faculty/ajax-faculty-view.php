<?php

session_start();

if (isset($_POST['jsonData'])) {
    $data = json_decode($_POST['jsonData']);
    $div = $data->div;
    $sub = $data->subject;
    $lec_type = $data->lec_type;
    $dept_id = $_SESSION['f_dept_id'];
}


