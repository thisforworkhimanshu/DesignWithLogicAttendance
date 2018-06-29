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
        <title></title>
        <!--cdn libraries-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="../custom.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> <!-- cdn google icons -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="paginathing.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
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

                        } else {
                            var index = sel.indexOf(temp);
                            if (index > -1) {
                                sel.splice(index, 1);
                            }
                        }

                    }

                    if (sel.length != 0 && $("#cbbtn").val() == 'c') {
                        $("#cbbtn").val('u').text('u');
                    } else if (sel.length == 0 && $("#cbbtn").val() == 'u') {
                        $("#cbbtn").val('c').text('c');
                    }
                });
                $(document).on("change", "#attendance-table input[type='checkbox']", function (event) {
                    if ($(this).is(":checked")) {
                        $(this).closest('tr').addClass("highlight_row");
                    } else {
                        $(this).closest('tr').removeClass("highlight_row");
                    }
                });

                //script:button
                $("#cbbtn").click(function () {
                    if ($(this).val() == 'c') {
                        $(".record_table input[type='checkbox']").prop("checked", true);
                        $(this).val("u").text('u');
                    } else {
                        $(".record_table input[type='checkbox']").prop("checked", false);
                        $(this).val('c').text('c');
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
                            $("#count").append(data);
                            $("#info").css("display", "block").fadeIn(2000);
                            $("#make").text('Submitted :)').prop("disabled", true);

                        }
                    });
                });
            });
        </script>
    </head>
    <body>
        <div id="test"></div>
        <?php
        include '../../master-layout/faculty/master-faculty-layout.php';
        ?>
        <div class="row">
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
                echo '<div class="col" style="margin-top: 1%">';
                echo '<div><button id="cbbtn" class="btn btn-light" style="float:right" value="c">c</button></div>';
                echo '<table class="record_table table-sm table-responsive">';
                echo '<thead>'
                . '<tr><th>enrolment</th><th class="d-none d-sm-table-cell">name</th></tr>'
                . '</thead>';
                echo '<tbody>';
                while ($row = $rGetStud->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td><input type="checkbox">' . $row['student_enrolment'] . '</td>'
                    . '<td class="d-none d-sm-table-cell">' . $row['student_name'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>'
                . '</table>';
                ?>
                <nav id="page"></nav>
                <div class="row" style="height: 3%">
                    <button id="make" class="btn  btn-primary" style="width: 34%; height:">Make Attendance</button>
                    <div id="info" class="alert alert-warning alert-dismissible fade show col" role="alert" style="width: 65%;float: right;margin: 0.5%;display: none; text-align: center">
                        <label id="count" style="font-size: 10pt"> absent count: </label>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <?php
                echo '</div>';
            } else {
                ?>
                <div class="alert alert-info" role="alert" style="margin: 1%">
                    <b>Info! &nbsp;</b>it seems, you try to reloading page or any error occur...<br/> 
                    Would you like to fill attendance?&nbsp;<a href="fac-att-sel.php" class="alert-link">click here</a> <br/> 
                    or go to <a href="../../welcomefaculty.php" class="alert-link">home page</a> <br/>
                </div>
                <?php
            }
            ?>
            <div class="col"></div>
        </div>
    </body>
</html>
