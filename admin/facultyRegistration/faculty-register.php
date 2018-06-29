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
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <form>
                        <h4 class="text-center">Faculty Registration</h4>
                        <div class="form-group">
                            <label for="firstName" class="control-label">Full Name</label>
                            <div>
                                <input type="text" id="firstName" placeholder="Full Name" class="form-control" autofocus required="required">
                            </div>
                        </div>

                        <script>
                            $(document).ready(function () {
                                $("#email").blur(function () {
                                    var valuname = $(this).val();
                                    $.ajax({
                                        type: 'POST',
                                        url: "ajax-check-email.php",
                                        data: {email: valuname},
                                        success: function (data) {
                                            if (data === "ok") {
                                                $("#emailerror").show();
                                                $("#emailerror").fadeIn(1000, function () {
                                                    $("#emailerror").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> Email Already Exists</div>');
                                                    $("#btnSubmit").prop("disabled", true);
                                                    $("#emailerror").fadeOut(4000, function () {
                                                        $("#emailerror").hide();
                                                    });
                                                });
                                            } else if (data === "notok") {
                                                $("#btnSubmit").prop("disabled", false);
                                                $("#emailerror").hide();
                                            }
                                        }
                                    });
                                });
                            });
                        </script>

                        <div class="form-group">
                            <label for="email" class="control-label">Email</label>
                            <div>
                                <input type="email" id="email" placeholder="Email" class="form-control" required="required">
                            </div>
                            <div id="emailerror"></div>
                        </div>
                        <div class="form-group">
                            <label for="cellno" class="control-label">Mobile Number</label>
                            <div>
                                <input type="text" id="cellno" placeholder="Mobile Number" class="form-control" required="required">
                            </div>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $("#uname").blur(function () {
                                    var valuname = $(this).val();
                                    $.ajax({
                                        type: 'POST',
                                        url: "ajax-check-uname.php",
                                        data: {uname: valuname},
                                        success: function (data) {
                                            var response = data;
                                            if (data === "ok") {
                                                $("#uerror").show();
                                                $("#uerror").fadeIn(1000, function () {
                                                    $("#uerror").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> Username Already Exists</div>');
                                                    $("#btnSubmit").prop("disabled", true);
                                                    $("#uerror").fadeOut(4000, function () {
                                                        $("#uerror").hide();
                                                    });
                                                });
                                            } else if (data === "notok") {
                                                $("#btnSubmit").prop("disabled", false);
                                                $("#uerror").hide();
                                            }
                                        }
                                    });
                                });
                            });
                        </script>
                        <div class="form-group">
                            <label for="uname" class="control-label">Username</label>
                            <div>
                                <input type="text" id="uname" placeholder="Username" class="form-control" required="required" onblur="">
                                <div id="uerror"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Password</label>
                            <div>
                                <input type="password" id="password" placeholder="Password" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="designation" class="control-label">Designation</label>
                            <div>
                                <input type="text" id="designation" placeholder="Designation" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Gender</label>
                            <div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" id="femaleRadio" value="Female" required="required">Female
                                        </label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" id="maleRadio" value="Male" required="required">Male
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- /.form-group -->
                        <script>
                            $(document).ready(function () {
                                $("#btnSubmit").click(function () {
                                    var firstName = $("#firstName").val();
                                    var email = $("#email").val();
                                    var cellno = $("#cellno").val();
                                    var username = $("#uname").val();
                                    var password = $("#password").val();
                                    var gender = $("input:radio[name='gender']:checked").val();
                                    var designation = $("#designation").val();
                                    if (firstName === "" || email === "" || cellno === "" || username === "" || password === "" || gender === "" || designation === "") {
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
                                        var dataString = 'firstName=' + firstName + '&email=' + email + '&cellno=' + cellno + '&username=' + username + '&password=' + password + '&gender=' + gender + '&designation=' + designation;
                                        $.ajax({
                                            type: 'POST',
                                            url: "ajax-faculty-register.php",
                                            data: dataString,
                                            cache: false,
                                            beforeSend: function () {
                                                $(":submit").attr("disabled", true);
                                                $("#btnSubmit").html('<span class="glyphicon glyphicon-transfer"></span> In Progress...');
                                            },
                                            success: function (result) {
                                                var res = result.substring(2);

                                                var response = result.substring(0, 2);
                                                if (response === "ok") {
                                                    $("#btnSubmit").html('<span class="glyphicon glyphicon-transfer"></span> Successfully Registered with ID: ' + res);
                                                    setTimeout(function () {
                                                        $("#btnSubmit").html('<span class="glyphicon glyphicon-transfer"></span> Submit');
                                                    }, 10000);

                                                } else {
                                                    $("#error").fadeIn(1000, function () {

                                                var response = result.substring(0,2);
                                                if(response==="ok"){
                                                    $("#btnSubmit").html('<span class="glyphicon glyphicon-transfer"></span> Successfully Registered with ID: '+res);
                                                }else{
                                                    $("#error").fadeIn(1000, function(){

                                                        $(":submit").attr("disabled", false);
                                                        $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span>   ' + result + ' !</div>');
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