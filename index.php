<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if(isset($_SESSION['aid'])){
    header("Location: welcomeadmin.php");
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="bootstrap-4.1.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css"/>
        <!-- jQuery library -->
        <script src="node_modules/jquery/dist/jquery.min.js"></script>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
         
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        
    </head>
    <body>
        <div class="container">
            <div>
                <nav class="navbar navbar-expand-sm bg-light">
                <a class="navbar-brand" href="index.php">Management</a>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Login
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item active" href="index.php">Admin</a>
                            <a class="dropdown-item" href="facultyLogin.php">Faculty</a>
                        </div>
                    </li>
                </ul>
            </nav>
            </div>
            <div class="row">
                <div class="col"></div>
                <div class="col">
                    <form id="login-form" method="post">
                        <h3 class="text-center">Administrator Login</h3>
                        <div class="form-group" style="margin-top: 30px;">
                          <label for="uname">Username</label>
                          <input type="text" class="form-control" id="uname" name="uname" required="required">
                        </div>
                        <div class="form-group">
                          <label for="pwd">Password:</label>
                          <input type="password" class="form-control" id="pwd" name="password" required="required">
                        </div>
                        <div id="error">
                        </div>
                        <script>
                          $(document).ready(function (){
                            $("#login_button").click(function() {
                                var uname = $("#uname").val();
                                var pass = $("#pwd").val();
                                if(uname==="" || pass === ""){
                                    $("#error").fadeIn(1000,function() {
                                        $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> Please Fill Both Details !</div>');
                                    });
                                }else{
                                    $body = $("body");
                                    var dataString = 'uname1='+uname+'&pass1='+pass;
                                    $.ajax({
                                        type: "POST",
                                        url: "http://localhost/DesignwithLogicAttendance/login-ajax/ajaxadminlogin.php",
                                        data: dataString,
                                        cache: false,
                                        beforeSend: function () {
                                            $body.addClass("loading");
                                            $(":submit").attr("disabled", true);
                                            $("#login_button").html('<span class="glyphicon glyphicon-transfer"></span> Authenticating');
                                        },
                                        success: function (result) {
                                            if(result==="ok"){
                                                $("#login_button").html('<span class="glyphicon glyphicon-transfer"></span> Signing In...');
                                                setTimeout(function() {
                                                    window.location.href="http://localhost/DesignwithLogicAttendance/welcomeadmin.php";
                                                    $body.removeClass("loading");
                                                },4000);
                                                
                                            }else{
                                                $("#error").fadeIn(1000, function(){
                                                    $body.removeClass("loading");
                                                    $(":submit").attr("disabled", false);
                                                    $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span>   '+result+' !</div>');
                                                    $("#login_button").html('<span class="glyphicon glyphicon-log-in"></span>   Sign In');
                                                });
                                            }
                                        }
                                    });
                                } 
                                return false;
                            }); 
                          });
                        </script>
                        <button type="submit" name="login_button" id="login_button" class="btn btn-primary">Sign In</button>
                    </form>
                </div>
                <div class="col"></div>
            </div>
        </div>
        
        <div class="modal"></div>
        
    </body>
</html>
