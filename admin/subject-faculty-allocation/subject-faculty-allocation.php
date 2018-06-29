<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if (!isset($_SESSION['aid'])) {
    header("Location: ../../index.php");
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../../bootstrap-4.1.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/style.css"/>

        <script src="../../jquery/jquery-3.3.1.js"></script> <!-- jquery js -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

        <script>
            $(document).ready(function () {
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
            });
        </script>
    </head>
    <body>
        <div class="container">
            <?php
            require_once '../../master-layout/admin/master-page-admin.php';
            ?>
            <div class="badge-light" style="margin-top: 2%;">
                <div class="text-center">
                    <h5>Subject Allocation To Faculty</h5>
                </div>
            </div>

            <script>
                $(document).ready(function () {
                    $("#lecture_hours").prop("disabled", true);
                    $("#lecture_total").prop("disabled", true);
                    $("#semester").change(function () {
                        if (this.selectedIndex === 0) {
                            $("#subject").prop("disabled", true);
                            $("#faculty").prop("disabled", true);
                            $("#chooselecture").prop("disabled", true);
                            $("#choosediv").prop("disabled", true);
                            $("#choosebatch").prop("disabled", true);
                            $("#btnSubmit").prop("disabled", true);
                            $("#lecture_hours").prop("disabled", true);
                            $("#lecture_total").prop("disabled", true);
                        } else {
                            var sem = $("#semester").val();
                            $.post('ajax-processSubject.php', {semester: sem},
                                    function (response) {
                                        $("#subject").prop("disabled", false);
                                        $("#subject").html(response);
                                    }).fail(function () {

                            });
                        }
                    });
                });
            </script>
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">      
                    <div style="margin-top: 3%;">
                        <div>
                            <form id="sub-alloc-form">
                                <div class="form-group">
                                    <select name="semester" id="semester" autofocus class="form-control">
                                        <option selected>--Select Semester--</option>
                                        <?php
                                        require_once '../../Connection.php';
                                        $connection = new Connection();
                                        $conn = $connection->createConnection("college");
                                        if (!$conn) {
                                            die('Connection to Database Failed');
                                        } else {
                                            $sqldistinct = "SELECT DISTINCT(student_semester) as sem FROM student ORDER BY student_semester ASC";
                                            $resultdistinct = mysqli_query($conn, $sqldistinct);
                                            while ($row = mysqli_fetch_object($resultdistinct)) {
                                                ?>
                                                <option value="<?php echo $row->sem ?>"><?php echo $row->sem; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <script>
                                    $(document).ready(function () {
                                        $("#subject").change(function () {
                                            if (this.selectedIndex === 0) {
                                                $("#faculty").prop("disabled", true);
                                                $("#chooselecture").prop("disabled", true);
                                                $("#choosediv").prop("disabled", true);
                                                $("#choosebatch").prop("disabled", true);
                                                $("#btnSubmit").prop("disabled", true);
                                                $("#lecture_hours").prop("disabled", true);
                                                $("#lecture_total").prop("disabled", true);
                                            } else {
                                                var subName = $("#subject").val();
                                                $.post('ajax-processFaculty.php', {subject: subName},
                                                        function (response) {
                                                            $("#faculty").prop("disabled", false);
                                                            $("#faculty").html(response);
                                                        }).fail(function () {

                                                });
                                            }
                                        });
                                    });
                                </script>
                                <div class="form-group">
                                    <div id="choosesubject">
                                        <select name="subject" id="subject" disabled="disabled" class="form-control">
                                            <option>--Select Subject--</option>
                                        </select>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function () {
                                        $("#faculty").change(function () {
                                            if (this.selectedIndex === 0) {
                                                $("#chooselecture").prop("disabled", true);
                                                $("#choosediv").prop("disabled", true);
                                                $("#choosebatch").prop("disabled", true);
                                                $("#btnSubmit").prop("disabled", true);
                                                $("#lecture_hours").prop("disabled", true);
                                                $("#lecture_total").prop("disabled", true);
                                            } else {
                                                $("#chooselecture").prop("disabled", false);
                                            }
                                        });
                                    });
                                </script>
                                <div class="form-group">
                                    <div id="choosefaculty">
                                        <select id="faculty" name="faculty" disabled="disabled" class="form-control">
                                            <option>--Select Faculty--</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div id="chooselecturetype">
                                        <select id="chooselecture" name="lecturetype" disabled="disabled" class="form-control">
                                            <option>--Select Theory/Practical--</option>
                                            <option value="theory">Theory</option>
                                            <option value="practical">Practical</option>
                                        </select>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function () {
                                        $("#chooselecture").change(function () {
                                            if (this.selectedIndex === 0) {
                                                $("#choosediv").prop("disabled", true);
                                                $("#choosebatch").prop("disabled", true);
                                                $("#choosediv option:selected").prop("selected", false);
                                                $("#choosebatch option:selected").prop("selected", false);
                                                $("#btnSubmit").prop("disabled", true);
                                                $("#lecture_hours").prop("disabled", true);
                                                $("#lecture_total").prop("disabled", true);
                                            } else {
                                                var lectype = $("#chooselecture").val();
                                                if (lectype === "theory") {
                                                    $("#choosediv").prop("disabled", false);
                                                    var semester = $("#semester").val();
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: "ajax-processDivision.php",
                                                        data: {semester: semester},
                                                        success: function (data) {
                                                            console.log(data);
                                                            $("#choosediv").html(data);
                                                        }
                                                    });
                                                    $("#choosebatch").prop("disabled", true);
                                                    $("#choosebatch option:selected").prop("selected", false);
                                                } else {
                                                    $("#choosediv option:selected").prop("selected", false);
                                                    if ($("#semester").val() == 1 || $("#semester").val() == 2) {
                                                        var semester = $("#semester").val();
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: "ajax-processBatch.php",
                                                            data: {semester: semester},
                                                            success: function (data) {
                                                                console.log(data);
                                                                $("#choosebatch").html(data);
                                                            }
                                                        });
                                                        //                                                $("#choosebatch option[value='B5']").prop("disabled",true);
                                                        //                                                $("#choosebatch option[value='B6']").prop("disabled",true);
                                                        $("#choosebatch").prop("disabled", false);
                                                        $("#choosediv").prop("disabled", true);
                                                    } else {
                                                        var semester = $("#semester").val();
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: "ajax-processBatch.php",
                                                            data: {semester: semester},
                                                            success: function (data) {
                                                                console.log(data);
                                                                $("#choosebatch").html(data);
                                                            }
                                                        });
                                                        $("#choosebatch option[value='B5']").prop("disabled", false);
                                                        $("#choosebatch option[value='B6']").prop("disabled", false);
                                                        $("#choosebatch").prop("disabled", false);
                                                        $("#choosediv").prop("disabled", true);
                                                    }
                                                }
                                            }
                                        });

                                    });
                                </script>

                                <div class="form-group">
                                    <div id="choosedivtype">
                                        <select id="choosediv" name="divtype" disabled="disabled" class="form-control">
                                            <option value="">--Select Division--</option>
                                        </select>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function () {
                                        $("#lecture_hours").blur(function () {
                                            var lecture_hour = $(this).val();
                                            var subcode = $("#subject").val();
                                            var lectype = $("#chooselecture").val();
                                            if (lectype === "theory") {
                                                var division = $("#choosediv").val();
                                                $.ajax({
                                                    type: 'POST',
                                                    url: "ajax-check-lecture-hours.php",
                                                    data: {"lecture_hour": lecture_hour, "subcode": subcode, "type": division},
                                                    success: function (data) {
                                                        if (data === "noteligible") {
                                                            //alert("You cannot allocated lecture as limit exceeds ");
                                                            $("#error").show();
                                                            $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign">You cannot allocate lecture as limit reached or exceeds</div>');
                                                            $("#btnSubmit").prop("disabled", true);
                                                        } else {
                                                            $("#error").hide();
                                                            $("#btnSubmit").prop("disabled", false);
                                                        }
                                                    }
                                                });
                                            } else if (lectype === "practical") {
                                                var batch = $("#choosebatch").val();
                                                $.ajax({
                                                    type: 'POST',
                                                    url: "ajax-check-practical-hours.php",
                                                    data: {"lecture_hour": lecture_hour, "subcode": subcode, "type": batch},
                                                    success: function (data) {
                                                        if (data === "noteligible") {
                                                            //alert("You cannot allocated batch as limit exceeds ");
                                                            $("#error").show();
                                                            $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign">You cannot allocate batch as limit reached or exceeds</div>');
                                                            $("#btnSubmit").prop("disabled", true);
                                                        } else {
                                                            $("#error").hide();
                                                            $("#btnSubmit").prop("disabled", false);
                                                        }
                                                    }
                                                });
                                            }
                                        });
                                    });
                                </script>

                                <script>
                                    $(document).ready(function () {
                                        $("#choosediv").change(function () {
                                            if (this.selectedIndex === 0) {
                                                $("#btnSubmit").prop("disabled", true);
                                                $("#lecture_hours").prop("disabled", true);
                                                $("#lecture_total").prop("disabled", true);
                                            } else {
                                                $("#lecture_hours").prop("disabled", false);
                                                $("#lecture_total").prop("disabled", false);
                                                //$("#btnSubmit").prop("disabled",false);
                                            }
                                        });
                                    });

                                    $(document).ready(function () {
                                        $("#choosebatch").change(function () {
                                            if (this.selectedIndex === 0) {
                                                $("#btnSubmit").prop("disabled", true);
                                                $("#lecture_hours").prop("disabled", true);
                                                $("#lecture_total").prop("disabled", true);
                                            } else {
                                                $("#lecture_hours").prop("disabled", false);
                                                $("#lecture_total").prop("disabled", false);
                                                //$("#btnSubmit").prop("disabled",false);
                                            }
                                        });
                                    });
                                </script>

                                <div class="form-group">
                                    <div id="choosebatchtype">
                                        <select id="choosebatch" name="batchtype" disabled="disabled" class="form-control">
                                            <option value="">--Select Batch--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div id="inputlecturehours">
                                        <input type="text" class="form-control" placeholder="No of Hours" name="lecture_hours" id="lecture_hours" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div id="inputlecturetotal">
                                        <input type="text" class="form-control" placeholder="Expected Total No. of Lecture In Term" name="lecture_total" id="lecture_total" />
                                    </div>
                                </div>
                                <div id="error"></div>
                                <script>
                                    $(document).ready(function () {
                                        $("#btnSubmit").prop("disabled", true);
                                        $("#btnSubmit").click(function () {
                                            var formData = JSON.stringify($("#sub-alloc-form").serializeArray());
                                            var sem = $("#semester").val();
                                            var sub = $("#subject").val();
                                            var fac = $("#faculty").val();
                                            var lectype = $("#chooselecture").val();
                                            var lechour = $("#lecture_hours").val();
                                            var lecturetotal = $("#lecture_total").val();
                                            var stat = "";
                                            var div = $("#choosediv").val();
                                            if (div == "") {
                                                stat = $("#choosebatch").val();
                                            } else {
                                                stat = div;
                                            }
                                            var makeData = {"semester": sem, "subject": sub, "faculty": fac, "lecturetype": lectype, "type": stat, "lecture_hour": lechour, "lecture_total": lecturetotal};
                                            var json = JSON.stringify(makeData);
                                            console.log(formData);
                                            console.log(json);

                                            $.ajax({
                                                type: 'POST',
                                                url: "ajax-subject-faculty-allocation.php",
                                                data: {myData: json},
                                                success: function (data) {
                                                    $("#error").show();
                                                    $("#error").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-info-sign">' + data + '</div>');
                                                    $("#btnSubmit").prop("disabled", true);
                                                }
                                            });

                                            return false;
                                        });
                                        return false;
                                    });
                                </script>

                                <div class="form-group">
                                    <div style="margin-left: 36%;">
                                        <button type="submit" id="btnSubmit" class="btn btn-light btn-outline-primary">Allocate</button>
                                    </div>                               
                                </div>
                            </form> <!-- END OF FORM TAG -->
                        </div>            
                    </div>

                </div>

            </div>
        </div>       
    </body>
</html>
