<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if (isset($_SESSION['fid'])) {
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title></title>
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <link rel="stylesheet" href="bootstrap-4.1.1-dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
            <link rel="stylesheet" href="css/style.css"/>
            <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> <!-- cdn google icons -->
            <!-- jQuery library -->
            <script src="node_modules/jquery/dist/jquery.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

            <!-- Popper JS -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

            <!-- Latest compiled JavaScript -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

            <script>
                $(document).ready(function(){
                    $.ajax({
                         type: 'POST',
                         url: "ajax-dashboard/ajax-getSubjectCode.php" ,
                         success: function (data) {
                             $("#subject_code").html(data);
                         }
                   });
                    $("#quotehere").append('<p>Loading...</p>');
                    $.getJSON("http://quotesondesign.com/wp-json/posts?filter[orderby]=rand&filter[posts_per_page]=1&callback=", function(a) {
                        $("#quotehere").empty();
                        $("#quotehere").append("<p>"+a[0].content + "</p><p>— <i>" + a[0].title + "</i></p>")
                    });

                   $("#totallecture").hide();
                   $("#subject_code") .change(function(){
                      if(this.selectedIndex===0) {
                          $("#totallecture").hide();
                      }else{
                          var subject_code = $(this).val();
                          $.ajax({
                                type: 'POST' ,
                                url: "ajax-dashboard/ajax-return-total-lecture.php",
                                data: {subjectcode:subject_code},
                                success: function (data) {
                                    $("#totallecture").show();
                                    $("#totallecture").html(data);
                                }
                          });
                      }
                   });
                });
            </script>
        </head>
        <body>
            <?php include './master-layout/faculty/master-faculty-layout.php'; ?>
            <div class="container">
                <div class="row" style="margin-top: 3%;">
                    <div class="col text-center"><b>Daily Quote</b></div>                    
                </div>
                <div class="row">
                    <div class="col text-center">
                        <div>
                            <span id="quotehere"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8"></div>
                    <div class="col-lg-4">
                        <div class="text-center">
                            <label><b>Expected Total Lecture</b></label>
                        </div>
                        <div class="form-group">
                            <select id="subject_code" name="subject_code" class="form-control">
                                <option>--Select Subject Code--</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <span id="totallecture" class="alert alert-warning form-control"></span>
                        </div>
                    </div>
                </div>
            </div>
        </body>
    </html>
    <?php
} else {
    header("Location: facultyLogin.php");
}