<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if(!isset($_SESSION['aid'])){
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
        <script src="../../node_modules/jquery/dist/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <?php
                require_once '../../master-layout/admin/master-page-admin.php';
            ?>
            <div class="badge-light" style="margin-top: 1%;">
                <div class="text-center">
                    <h5>Register Student into Detain</h5>
                </div>
            </div>
            
            <script>
                $(document).ready(function(){
                   $("#btnSubmit").click(function(){
                       var enrol = $("#enrolment").val();
                       $.ajax({
                          type: 'POST',
                          url: "ajax-detain-stud.php",
                          data: {enrolment:enrol},
                          beforeSend: function (xhr) {
                              $("#msgerr").hide();
                              $("#msgsuccess").hide();
                          },
                          success: function (data) {
                              if(data==="norecord"){
                                  $("#msgsuccess").hide();
                                  $("#msgerr").show();
                                  $("#msgerr").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign">No Record Found</div>');
                              }else if(data==="already"){
                                  $("#msgsuccess").hide();
                                  $("#msgerr").show();
                                  $("#msgerr").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign">Already Detain</div>');
                              }else if(data==="success"){
                                  $("#msgerr").hide();
                                  $("#msgsuccess").show();
                                  $("#msgsuccess").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-info-sign">Successfully Detain</div>');
                              }else if(data==="failed"){
                                  $("#msgsuccess").show();
                                  $("#msgerr").hide();
                                  $("#msgsuccess").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign">Operation Failed</div>');
                              }
                          }
                       });
                   });
                });
            </script>
            
            <div class="row" style="margin-top: 3%;">
                <div class="col-lg-3">
                    <div class="form-group">
                        <input type="text" class="form-control" id="enrolment" placeholder="Enrolment Number" name="enrolment"/>
                    </div>
                </div>
                <div class="col-lg-2">
                    <input type="submit" id="btnSubmit" value="Detain" class="btn btn-danger"/>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-4">
                    <div id="msgerr"></div>
                    <div id="msgsuccess"></div>
                </div>
            </div>
            
            
            
            <hr/>
            <div class="badge-light" style="margin-top: 1%;">
                <div class="text-center">
                    <h5>Regularized Detain Student</h5>
                </div>
            </div>
            <hr/>
            
            <script>
                $(document).ready(function(){
                   $("#btnSubmitReg").click(function(){
                       var enrol = $("#enrolmentReg").val();
                       var batchyear = $("#batchyear").val();
                       $.ajax({
                          type: 'POST',
                          url: "ajax-regularized-detain-student.php",
                          data: {enrolment:enrol,batchyear:batchyear},
                          beforeSend: function (xhr) {
                              $("#msgerrR").hide();
                              $("#msgsuccessR").hide();
                          },
                          success: function (data) {
                              console.log(data);
                              if(data==="norecord"){
                                  $("#msgsuccessR").hide();
                                  $("#msgerrR").show();
                                  $("#msgerrR").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign">No Record Found</div>');
                              }else if(data==="notvalid"){
                                  $("#msgsuccessR").hide();
                                  $("#msgerrR").show();
                                  $("#msgerrR").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign">Batch Year Not Valid</div>');
                              }else if(data==="success"){
                                  $("#msgerrR").hide();
                                  $("#msgsuccessR").show();
                                  $("#msgsuccessR").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-info-sign">Successfully Regularised</div>');
                              }else if(data==="failed"){
                                  $("#msgsuccessR").show();
                                  $("#msgerrR").hide();
                                  $("#msgsuccessR").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign">Operation Failed</div>');
                              }
                          }
                       });
                   });
                });
            </script>
            
            <div class="row" style="margin-top: 3%;">
                <div class="col-lg-3">
                    <div class="form-group">
                        <input type="text" class="form-control" id="enrolmentReg" placeholder="Enrolment Number" name="enrolment"/>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <input type="text" class="form-control" id="batchyear" placeholder="Batch Year" name="enrolment"/>
                    </div>
                </div>
                <div class="col-lg-2">
                    <input type="submit" id="btnSubmitReg" value="Detain" class="btn btn-danger"/>
                </div>
            </div>
            
            <div id="msgerrR" style="width: 30%;"></div>
            <div id="msgsuccessR" style="width: 30%;"></div>
        </div>
    </body>
</html>