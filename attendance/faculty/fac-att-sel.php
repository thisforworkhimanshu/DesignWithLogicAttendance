<?php
session_start();
if (!isset($_SESSION['fid'])) {
    header("location:/DesignWithLogicAttendance/facultyLogin.php");
    return;
}

$bool = FALSE;
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

    $sCheckLec = "SELECT lecture_id FROM lecture_tb_$dept_id WHERE date='$today' AND faculty_id = $fid AND subject_code = $sub_code AND type = '$lec_type' AND division = '$div' LIMIT 1";
    $rCheckLec = $db->query($sCheckLec);
    if ($rCheckLec->num_rows > 0) {
        $bool = TRUE;
    } else {
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
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="../../bootstrap-4.1.1-dist/css/bootstrap.min.css"> <!-- bootstrap css -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> <!-- cdn google icons -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="../../bootstrap-4.1.1-dist/js/bootstrap.min.js"></script> <!-- bootstrap js -->
        <script src="../../jquery/jquery-3.3.1.js"></script> <!-- jquery js -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        
        <script>
            //script:highlight the active link in navigation bar
            $(document).ready(function () {
                var current = location.pathname;
                $('#nav li a').each(function () {
                    var $this = $(this);
                    // if the current path is like this link, make it active
                    if ($this.attr('href').indexOf(current) !== -1) {
                        $this.addClass('active');
                        return false;
                    }
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                //script:highlight the active link in navigation bar
                var current = location.pathname;
                $('#nav li a').each(function () {
                    var $this = $(this);
                    // if the current path is like this link, make it active
                    if ($this.attr('href').indexOf(current) !== -1) {
                        $this.addClass('active');
                        return false;
                    }
                });

                //disable combobox onload 
                $("#division").prop("disabled", true);
                $("#subject").prop("disabled", true);

                //script:button fatch allocated theory division or practical batch
                $("#theory").click(function () {
                    $("#lec_type").val($(this).val());
                    $("#division").prop("disabled", false);
                    $("#subject").prop("disabled", true);
                    $('#next').prop('disabled', true);
                    $("#division").empty();
                    var sendData = {'lec_type': 'theory'};
                    callAjax(sendData, "div");
                });
                
                $("#practical").click(function () {
                    $("#lec_type").val($(this).val());
                    $("#division").prop("disabled", false);
                    $("#subject").prop("disabled", true);
                    $('#next').prop('disabled', true);
                    $("#division").empty();
                    var sendData = {'lec_type': 'practical'};
                    callAjax(sendData, "div");
                });

                //script: combobox fatch subject
                $("#division").change(function () {
                    $('#next').prop('disabled', true);
                    $("#subject").prop("disabled", false);
                    $("#subject").empty();
                    var sendData = {'division': $(this).val()};
                    callAjax(sendData);
                });

                $('#subject').change(function () {
                    if (this.selectedIndex != 0) {
                        $('#next').prop('disabled', false);
                    } else {
                        $('#next').prop('disabled', true);
                    }
                });

                function callAjax(sendData, type) {
                    $.ajax({
                        type: 'POST',
                        url: "ajax-faculty-subject.php",
                        data: sendData,
                        success: function (data, textStatus, jqXHR) {
                            if (type == 'div') {
                                console.log(data);
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
            <?php include '../../master-layout/faculty/master-faculty-layout.php'; ?>
        </div>
        <div class="container">
            <div class="row mt-2">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
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
                        <?php
                        if ($bool) {
                            ?> 
                            <div class="alert alert-info" style="display: block">
                                <i class="material-icons" style="vertical-align: text-bottom;padding-right: 2px; font-size: 16pt">error_outline</i>Please Note:
                                <br/>Today's attendance for selected subject has been made early
                            </div>
                        <?php }
                        ?>
                        <div class="d-flex justify-content-center"><button id="next" type="submit" value="submit" class="btn btn-primary" disabled="true">NEXT &raquo;</button></div>
                    </form>
                </div>
                <div class="col-sm-4"></div>
            </div>
        </div>
    </body>
</html>
