<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="css/circle.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="bootstrap-4.1.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css"/>
        <!-- jQuery library -->
        <script src="node_modules/jquery/dist/jquery.min.js"></script>
         
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    </head>
    <body>
<!--        <div class="c100 p100 small green">

            <span>100%</span>
            <div class="slice">
                <div class="bar"></div>
                <div class="fill"></div>
            </div>
        </div>
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
                            <a class="dropdown-item" href="index.php">Admin</a>
                            <a class="dropdown-item active" href="facultyLogin.php">Faculty</a>
                        </div>
                    </li>
                </ul>
            </nav>
            </div>
            <div class="row">
                <div class="col"></div>
                <div class="col">
                    <form id="login-form" method="post">
                        <h3 class="text-center">Faculty Login</h3>
                        <div class="form-group" style="margin-top: 30px;">
                          <label for="uname">Username:</label>
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
                                        url: "login-ajax/ajaxfacultylogin.php",
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
                                                    window.location.href="welcomefaculty.php";
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
        
        <div class="modal"></div>-->

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Task
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Check My Subject Allocation</a>
                  </div>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Marks
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Marks Entry</a>
                    <a class="dropdown-item" href="#">Change Marks</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">View Marks</a>
                  </div>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Attendance
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Fill Attendance</a>
                    <a class="dropdown-item" href="#">View Attendance</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Change Attendance</a>
                  </div>
                </li>
            
            </ul>
            <ul class="navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="#">Profile</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Logout</a>
                    </div>
                  </li>
            </ul>
        </div>
      </nav>
</div>
    </body>
</html>
