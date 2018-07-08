<?php
session_start();
if (!isset($_SESSION['fid'])) {
    header("location:/DesignWithLogicAttendance/facultyLogin.php");
    return;
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
@author sahil
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>SIM: feculty attendance filling</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="../custom.css">
        <link rel="stylesheet" href="../../jquery/jquery-ui-1.12.1.custom/jquery-ui.min.css"> <!-- jquery-ui css -->
        <link rel="stylesheet" href="../../bootstrap-4.1.1-dist/css/bootstrap.min.css"> <!-- bootstrap css -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> <!-- cdn google icons -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="../../jquery/jquery-3.3.1.js"></script> <!-- jquery js -->
        <script src="../../bootstrap-4.1.1-dist/js/bootstrap.min.js"></script> <!-- bootstrap js -->
        <script src="../../jquery/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script> <!-- jquery-ui css -->
        <script src="../../Paginathing/paginathing.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {

                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                    $(document).tooltip();
                } else {
                    $('.record_table :checkbox').removeAttr('title');
                }
                var sel = [];

                $(".record_table tbody").paginathing({
                    perPage: 15,
                    ulClass: 'pagination justify-content-center',
                    liClass: 'page-item',
                    insertAfter: '#page',
                    activeClass: 'active',
                    disabledClass: 'disabled'
                });


                //script:event table click event and selection
                $(document).on("click", ".record_table tr", function (event) {
                    if (event.target.type !== 'checkbox') {
                        $(':checkbox', this).trigger('click');
                        var temp = $("td:first", this).text();
                        if ($(':checkbox', this).is(":checked")) {
                            if (!sel.includes(temp)) {
                                sel.push(temp);
                            }
                            console.log('clk check: ' + sel);
                        } else {
                            var index = sel.indexOf(temp);
                            if (index > -1) {
                                sel.splice(index, 1);
                            }
                            console.log('clk uncheck: ' + sel);
                        }
                    }
                    if (sel.length != 0 && $("#cbbtn").val() == 'c') {
                        $("#cbbtn").val('u').html('<i class="material-icons" style="vertical-align: bottom; padding-right:2px">check_box_outline_blank</i>Uncheck All');
                    } else if (sel.length == 0 && $("#cbbtn").val() == 'u') {
                        $("#cbbtn").val('c').html('<i class="material-icons" style="vertical-align: bottom; padding-right:2px">check_box</i>Check All');
                    }
                });
                $(document).on("change", ".record_table input[type='checkbox']", function (event) {
                    if ($(this).is(":checked")) {
                        $(this).closest('tr').css('background', '#ffcccc');
                    } else {
                        $(this).closest('tr').css('background', '');
                    }
                });

                //script:button
                $("#cbbtn").click(function () {
                    if ($(this).val() == 'c') {
                        $(".record_table input[type='checkbox']").prop("checked", true);
                        $(this).val("u").html('<i class="material-icons" style="vertical-align: bottom; padding-right:2px">check_box_outline_blank</i>Uncheck All');
                        $('.record_table tbody tr').css('background', '#ffcccc');

                        $('.record_table > tbody tr td:first-child').each(function (i, item) {
                            if (!sel.includes($(item).text())) {
                                sel.push($(item).text());
                            }
                        });
                        console.log('check: ' + sel);
                    } else {
                        $(".record_table input[type='checkbox']").prop("checked", false);
                        $(this).val('c').html('<i class="material-icons" style="vertical-align: bottom; padding-right:2px">check_box</i>Check All');
                        $('.record_table tbody tr').css('background', '');
                        sel = [];
                        console.log('uncheck: ' + sel);

                    }
                });

                //script:button, make attendance
                $("#make").click(function () {
                    var sendData = {lec_id: $("#lec_id").val(), div: $("#div").val(), sem: $("#sem").val(), lec_type: $("#lec_type").val(), enrolment: sel};
                    $.ajax({
                        url: 'ajax-faculty-make-att.php',
                        type: 'POST',
                        data: {jsonData: JSON.stringify(sendData)},
                        success: function (data, textStatus, jqXHR) {
                            $("#info").css("display", "block").fadeIn(2000);
                            $("#make").text('Submitted :)').prop("disabled", true);
                            $('#subMsg').text(data).fadeIn('slow');
                            $('.record_table tbody tr').prop("disabled", true);
                            $('#cbbtn').prop("disabled", true);
                        }
                    });
                });
            });
        </script>
    </head>
    <body>
        <?php
        include '../../master-layout/faculty/master-faculty-layout.php';
        ?>
        <div class="container">
            <div class="row mt-2">
                <div class="col"></div>
                <?php
                if (isset($_SESSION['division']) && isset($_SESSION['subject']) && isset($_SESSION['lec_type']) && isset($_SESSION['lec_id'])) {
                    $div = $_SESSION['division'];
                    $sub_code = $_SESSION['subject'];
                    $lec_type = $_SESSION['lec_type'];
                    echo '<input type="hidden" id="lec_type" value="' . $lec_type . '">';
                    $dept_id = $_SESSION['f_dept_id'];
                    $fid = $_SESSION['fid'];
                    $today = date("Y/m/d");
                    echo '<input type="hidden" id="div" value="' . $div . '">';
                    $lec_id = $_SESSION['lec_id'];
                    echo '<input type="hidden" id="lec_id" value="' . $lec_id . '">';

                    include '../../Connection.php';
                    $conn = new Connection ();
                    $db = $conn->createConnection();

                    $sGetSem = "SELECT semester FROM subject WHERE subject_code = $sub_code LIMIT 1";
                    $rGetSem = $db->query($sGetSem);
                    $temp = $rGetSem->fetch_object();
                    $sem = $temp->semester;
                    echo '<input type="hidden" id="sem" value="' . $sem . '">';
                    $appendSql = '';
                    if ($lec_type == 'theory') {
                        $appendSql = " AND student_division = '$div'";
                    } else {
                        $appendSql = " AND student_batch = '$div'";
                    }

                    $sGetStud = "SELECT student_enrolment,student_name FROM student WHERE student_semester = $sem" . $appendSql;
                    $rGetStud = $db->query($sGetStud);
                    echo '<div class="col-lg-6">';
                    echo '<div class="row justify-content-end pl-1 pr-1"><button id="cbbtn" class="btn btn-light" style="float:right; width:130px" value="c"><i class="material-icons" style="vertical-align: bottom; padding-right:2px">check_box</i>Check All</button></div>';
                    echo '<div class="row pl-1 pr-1">';
                    echo '<table class="record_table table">';
                    echo '<thead>'
                    . '<tr><th>enrolment</th><th class="d-none d-sm-table-cell">name</th></tr>'
                    . '</thead>';
                    echo '<tbody>';
                    while ($row = $rGetStud->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td><input type="checkbox" title="' . $row['student_name'] . '">' . $row['student_enrolment'] . '</td>'
                        . '<td class="d-none d-sm-table-cell">' . $row['student_name'] . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody>'
                    . '</table>'
                    . '</div>';
                    ?>
                    <div class="row pl-1 pr-1  justify-content-center"><nav id="page"></nav></div>
                    <div class="row pl-1 pr-1 mb-2">
                        <div class="col-6 col-md-6"><button id="make" class="btn btn-block btn-primary">Make Attendance</button></div>
                        <div id="subMsg" class="border rounded border-danger col-6 col-md-6" style="display: none;text-align: center; color: red"></div>
                    </div> 
                    <?php
                    echo '</div>';
                } else {
                    ?>
                    <div class="alert alert-info m-1" role="alert">
                        <b>Info! &nbsp;</b>it seems, you try to reloading page or any error occur...<br/> 
                        Would you like to fill attendance?&nbsp;<a href="fac-att-sel.php" class="alert-link">click here</a> <br/> 
                        or go to <a href="../../welcomefaculty.php" class="alert-link">home page</a> <br/>
                    </div>
                    <?php
                }
                ?>
                <div class="col"></div>
            </div>
        </div>
    </body>
</html>
