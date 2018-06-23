<?php
session_start();
if (!isset($_SESSION['fid'])) {
    header("location:/DesignWithLogicAttendance/facultyLogin.php");
    return;
}
if (isset($_GET['division']) && isset($_GET['subject']) && isset($_GET['lec_type'])) {
    $div = $_GET['division'];
    $sub_code = $_GET['subject'];
    $lec_type = $_GET['lec_type'];
    $dept_id = $_SESSION['f_dept_id'];
    $fid = $_SESSION['fid'];
    $today = date("Y/m/d");
    include '../../Connection.php';
    $conn = new Connection();
    $db = $conn->createConnection();

    if (!isset($_SESSION['lec_id'])) {
        $sGenrateLectID = "INSERT INTO lecture_tb_$dept_id (date,faculty_id,subject_code,type,division) "
                . "VALUES ('$today',$fid,$sub_code,'$lec_type','$div')";
        $rGenrateLectID = $db->query($sGenrateLectID);
        if ($rGenrateLectID === TRUE) {
            $lec_id = $db->insert_id;
            $_SESSION['lec_id'] = $lec_id;
            $_SESSION['division'] = $div;
            $_SESSION['lec_type'] = $lec_type;
            $_SESSION['subject'] = $_GET['subject'];
            header("location:fac-att-fill.php");
        }
    }
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>SIM: faculty attendance</title>

        <!--cdn libraries-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                //disable combobox onload 
                $("#division").prop("disabled", true);
                $("#subject").prop("disabled", true);

                //script:button fatch allocated theory division or practical batch
                $("#theory").click(function () {
                    $("#lec_type").val($(this).val());
                    $("#division").prop("disabled", false);
                    $("#subject").prop("disabled", true);
                    $("#division").empty();
                    var sendData = {'type': 'theory'};
                    callAjax(sendData, "div");
                });
                $("#practical").click(function () {
                    $("#lec_type").val($(this).val());
                    $("#division").prop("disabled", false);
                    $("#subject").prop("disabled", true);
                    $("#division").empty();
                    var sendData = {'type': 'practical'};
                    callAjax(sendData, "div");
                });

                //script: combobox fatch subject
                $("#division").change(function () {
                    $("#subject").prop("disabled", false);
                    $("#subject").empty();
                    var sendData = {'division': $(this).val()};
                    callAjax(sendData);
                });

                function callAjax(sendData, type) {
                    $.ajax({
                        type: 'POST',
                        url: "ajax-faculty-subject.php",
                        data: sendData,
                        success: function (data, textStatus, jqXHR) {
                            if (type == 'div') {
                                appendDivision(data);
                            } else {
                                console.log(data);
                                appendSubject(data);
                            }
                        }
                    });
                }

                function appendDivision(data) {
                    jsonData = $.parseJSON(data);
                    $("#division").append($("<option>").text("--Select division--"));
                    $.each(jsonData, function (i, item) {
                        $("#division").append($("<option>").text(item).val(item));
                    });
                }

                function appendSubject(data) {
                    jsonData = $.parseJSON(data);
                    $("#subject").append($("<option>").text("--Select subject--"));
                    $.each(jsonData, function (i, item) {
                        $("#subject").append($("<option>").text(item.short_name).val(item.subject_code));
                    });
                }
            });
        </script>
    </head>
    <body>
        <div id="navbar">
            <?php include '../../faculty-nav-bar.php'; ?>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col" style="margin-top: 0.5%">
                <form action="#" method="GET">
                    <div class="btn-group form-group d-flex justify-content-center" role="group" aria-label="selection" style="align-items: ">
                        <button type="button" class="btn btn-outline-primary" id="theory" value="theory">Theory</button>
                        <button type="button" class="btn btn-outline-primary" id="practical" value="practical">Practical</button>
                    </div>
                    <input type="hidden" id="lec_type" name="lec_type" value="">
                    <div>
                        <select class="form-control form-group" id="division" name="division">
                            <option>--Select division--</option>
                        </select>
                        <select class="form-control form-group" id="subject" name="subject">
                            <option>--Select subject--</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-center"><button type="submit" value="submit" class="btn btn-primary">NEXT -></button></div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </body>
</html>
