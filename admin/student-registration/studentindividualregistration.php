<?php
session_start();
if (!isset($_SESSION['aid'])) {
    header("Location: ../../index.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Student - Individual Registration</title>
        <link rel="stylesheet" href="../../bootstrap-4.1.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/style.css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> <!-- cdn google icons -->
        <script src="../../node_modules/jquery/dist/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
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
                })
            });
        </script>
    </head>
    <body>
        <div class="container">
            <?php
            require_once '../../master-layout/admin/master-page-admin.php';
            ?>
            <div class="badge-light" style="margin-top: 1%;">
                <div class="text-center">
                    <h5>Student - Individual Registration</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <form>			
                        <div class="form-group">
                            <label for="enrolment_no" class="control-label">Enrolment No</label>
                            <div>
                                <input type="text" id="enrolment_no" placeholder="Enrolment No" class="form-control" autofocus required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="student_name" class="control-label">Name</label>
                            <div>
                                <input type="text" id="student_name" placeholder="Student Name" class="form-control" autofocus required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="student_semester" class="control-label">Semester</label>
                            <div>
                                <select name="semester" id="student_semester" class="form-control" autofocus required="required">
                                    <option value="">--Select Semester--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="student_dept_id" class="control-label">Department Id</label>
                            <div>
                                <input type="text" id="student_dept_id" placeholder="Student Department Id" class="form-control" autofocus required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="student_adm_yr" class="control-label">Admission Year</label>
                            <div>
                                <input type="text" id="student_adm_yr" placeholder="Student Admission Year" class="form-control" autofocus required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="student_batch_year" class="control-label">Batch Year</label>
                            <div>
                                <input type="text" id="student_batch_year" placeholder="Student Batch Year" class="form-control" autofocus required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="student_division" class="control-label">Division</label>
                            <div>
                                <select name="division" id="student_division" class="form-control" autofocus required="required">
                                    <option value="">Select Division</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="student_batch" class="control-label">Batch</label>
                            <div>
                                <select name="batch" id="student_batch" class="form-control" autofocus required="required">
                                    <option value="">Select Batch</option>
                                    <option value="B1">B1</option>
                                    <option value="B2">B2</option>
                                    <option value="B3">B3</option>
                                    <option value="B4">B4</option>
                                    <option value="B5">B5</option>
                                    <option value="B6">B6</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="student_email" class="control-label">Email</label>
                            <div>
                                <input type="email" id="student_email" placeholder="Student Email" class="form-control" required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="student_cellno" class="control-label">Cell No</label>
                            <div>
                                <input type="text" id="student_cellno" placeholder="Student Mobile Number" class="form-control" required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="student_password" class="control-label">Password</label>
                            <div>
                                <input type="password" id="student_password" placeholder="Student Password" class="form-control" required="required">
                            </div>
                        </div>


                        <script>
                            $(document).ready(function () {
                                $("#btnSubmit").click(function () {
                                    var enrol = $("#enrolment_no").val();
                                    var name = $("#student_name").val();
                                    var semester = $("#student_semester option:selected").val();
                                    var dept_id = $("#student_dept_id").val();
                                    var adm_yr = $("#student_adm_yr").val();
                                    var batch_yr = $("#student_batch_year").val();
                                    var division = $("#student_division option:selected").val();
                                    var batch = $("#student_batch option:selected").val();
                                    var email = $("#student_email").val();
                                    var cellno = $("#student_cellno").val();
                                    var password = $("#student_password").val();

                                    if (enrol === "" || name === "" || semester === "" || dept_id === "" || adm_yr === "" || batch_yr === "" || division === "" || batch === "" || email === "" || cellno === "" || password === "") {
                                        $("#error").fadeIn(1000, function () {
                                            $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> Please Fill All Details !</div>');
                                            $("#error").fadeOut(4000, function () {
                                                $("#error").hide();
                                            });
                                        });
                                    } else if (cellno.length < 10 || cellno.length > 10) {
                                        $("#error").fadeIn(1000, function () {
                                            $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> Mobile Number Consist 10 Digit Only !</div>');
                                            $("#error").fadeOut(4000, function () {
                                                $("#error").hide();
                                            });
                                        });
                                    } else {
                                        var dataString = 'enrol=' + enrol + '&name=' + name + '&semester=' + semester + '&dept_id=' + dept_id + '&adm_yr=' + adm_yr + '&batch_yr=' + batch_yr + '&division=' + division + '&batch=' + batch + '&email=' + email + '&cellno=' + cellno + '&password=' + password;
                                        $.ajax({
                                            type: 'POST',
                                            url: "ajax-student-registration-individual.php",
                                            data: dataString,
                                            cache: false,
                                            beforeSend: function () {
                                                $(":submit").attr("disabled", true);
                                                $("#btnSubmit").html('<span class="glyphicon glyphicon-transfer"></span> In Progress...');
                                            },
                                            success: function (response) {
                                                if (response === "ok") {
                                                    $("#btnSubmit").html('<span class="glyphicon glyphicon-transfer"></span> Successfully Registered');
                                                } else {
                                                    $("#error").fadeIn(1000, function () {
                                                        $(":submit").attr("disabled", false);
                                                        $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span>   ' + response + ' !</div>');
                                                        $("#btnSubmit").html('<span class="glyphicon glyphicon-log-in"></span>   Submit');
                                                        $("#error").fadeOut(4000, function () {
                                                            $("#error").hide();
                                                        });
                                                    });
                                                }
                                            }
                                        });
                                    }
                                    return false;
                                });
                            });
                        </script>
                        <div id="error"></div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-8">
                                    <button type="submit" id="btnSubmit" class="btn btn-primary btn-block">Register</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-3"></div>
            </div>
        </div>

    </body>
</html>