<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Student Login Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="../bootstrap-4.1.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function(){
               $("#btnSubmit").click(function(){
                   $("#error").hide();
                   var enrolment = $("#enrolment").val();
                   var password = $("#password").val();
                   if(enrolment===""||password===""){
                       $("#error").fadeIn(0,function(){
                          $("#error").html('<div class="alert alert-danger">Please Fill Both Details</div>');
                          if(enrolment===""){
                              $("#enrolment").focus();
                          }else{
                              $("#password").focus();
                          }
                       });
                   }else{
                       $.ajax({
                           type: 'POST',
                           url: "student-login-ajax/ajax-student-login.php",
                           data: {username:enrolment,password:password},
                           beforeSend: function (xhr) {
                               $("#btnSubmit").prop("disabled",false);
                           },
                           success: function (data, textStatus, jqXHR) {
                                if(data==="ok"){
                                    window.location.href='welcomestudent.php';
                                }else if(data==="notok"){
                                    $("#error").fadeIn(0,function(){
                                        $("#error").html('<div class="alert alert-danger">Please Verify Details!</div>');
                                    });
                                }
                           }
                       });
                   }
                   return false;
               });
            });
        </script>
    </head>
    <body>
        <div class="container">
            <div class="bg-light text-center">
                <hr style="border-color: greenyellow; margin-top: 0%;"/>
                <div>
                    <h1>Shantilal Shah Engineering College</h1>
                    <h6>New Sidsar Campus, Bhavnagar - 364001</h6>
                </div>
                <hr style="border-color: greenyellow;"/>
                <div>
                    <h5>Student Portal</h5>
                </div>
                <hr style="border-color: greenyellow;"/>
            </div>
            <div class="row" style="margin-top: 10%;">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <form>
                        <div class="form-group">
                            <input type="text" id="enrolment" name="enrolment" class="form-control" placeholder="Enrolment" autofocus/>
                        </div>
                        <div class="form-group">
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password"/>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-7"></div>
                            <div class="col-sm-auto"><a href="" class="btn-link" style="color: red;">Forgot Password?</a></div>
                        </div>
                        <div id="error"></div>
                        <div class="form-group">
                            <input type="submit" id="btnSubmit" value="Jump In" class="form-control btn-outline-success btn-light"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
