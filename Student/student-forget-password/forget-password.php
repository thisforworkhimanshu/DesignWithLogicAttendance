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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="../../bootstrap-4.1.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="bg-light text-center">
                <h3>Recover Password</h3>
            </div>
            
            <script>
                $(document).ready(function(){
                   $("#btnSubmit").click(function(){
                      var enrol = $("#enrolment").val();
                      var email = $("#email").val();
                      var cellno = $("#cellno").val();
                      if(enrol===""||email===""||cellno===""){
                          alert('Fill Valid Details Please');
                          return false;
                      }else{
                          $.ajax({
                            type: 'POST' ,
                            url: "return-password.php",
                            data: {enrol:enrol,email:email,cellno:cellno},
                            success: function (data, textStatus, jqXHR) {
                                $("#showHere").html('<div class="alert alert-success text-center"><b>'+data+'</b></div>');
                            }
                          });
                          return false;
                      }
                   });
                });
            </script>
            
            <div style="margin-top: 3%;">
                <form method="post">
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-4">
                            <div class="form-group">
                                <input type="text" name="enrolment" id="enrolment" class="form-control" placeholder="Enter Enrolment"/>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email"/>
                            </div>
                            <div class="form-group">
                                <input type="tel" name="cellno" id="cellno" class="form-control" placeholder="Enter Mobile Number"/>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="btnSubmit" id="btnSubmit" class="form-control btn btn-danger" value="Recover"/>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="showHere"></div>
            </div>
        </div>
    </body>
</html>
