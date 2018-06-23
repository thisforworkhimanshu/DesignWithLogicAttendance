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
            <div class="row" style="margin-top: 2%;">
                <div class="col-lg-3 form-group">
                    <input type="text" class="form-control" id="batchyear" placeholder="Batch Year"/>
                </div>
                <div class="col-lg-2 form-group">
                    <input type="submit" id="btnGo" class="form-control btn btn-primary" value="Go"/>
                </div>
                <div class="col-lg-5 form-group">
                    <div id="error" class="alert-danger form-control text-center"></div>
                    <div id="success" class="alert alert-success form-control text-center"></div>
                </div>
            </div>
            
            <script>
                $(document).ready(function(){
                   $("#error").hide();
                   $("#success").hide();
                   $("#showfordate").hide();
                   $("#batchyear").focus();
                   $("#btnGo").click(function(){
                   var batchyear = $("#batchyear").val();
                       $.ajax({
                           type: 'POST',
                           url: "ajax-check-batch-year.php",
                           data: {batchyear:batchyear},
                           success: function (data) {
                               console.log(data);
                               if(data==="notpresent"){
                                   $("#success").hide();
                                   $("#error").show();
                                   $("#error").html("Not Such Batch Year");
                               }else if(data==="notnow"){
                                   $("#success").hide();
                                   $("#error").show();
                                   $("#error").html("This Batch's Term Is Not Completed Yet");
                               }
                               var jsonObj = JSON.parse(data);
                               var msg = jsonObj.status;
                               if(msg==="present"){
                                   var sem = jsonObj.sem;
                                   var semn = parseInt(sem);
                                   if(semn===8){
                                        $("#givedate").html("Move Batch of Batch Year "+batchyear+" To Passout");
                                        $("#success").show();
                                        $("#error").hide();
                                        $("#batchyear").prop("disabled",true);
                                        $("#btnGo").prop("disabled",true);
                                        $("#success").html("Present Go Ahead");
                                        $("#showfordate").show();
                                   }else{
                                       $("#error").show();
                                       $("#error").html("Batch Should Be in Final Year and In Last Semester");
                                   }
                               }
                           }
                       });
                   });
                });
            </script>
            
            <div id="showfordate">
                <hr/>
                <form class="form form-group">
                    <div class="badge-light">
                            <div class="text-center">
                                <h5 id="givedate"></h5>
                            </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4"><input type="submit" name="movepass" id="movepass" value="Passout" class="form-control btn btn-success"/></div>
                    </div>
                </form>
                
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4">
                        <div class="alert alert-success text-center" id="msgSuccess" style="margin-top: 2%;">H</div>
                        <div class="alert alert-danger text-center" id="msgFailed" style="margin-top: 2%;">H</div>
                    </div>
                    <div class="col-lg-4"></div>
                    
                </div>
                
                
            </div>
            
            <script>
                $(document).ready(function(){
                   $("#msgSuccess").hide();
                   $("#msgFailed").hide();
                   $("#btnSubmit").click(function(){
                       var fromDate = $("#fromDate").val();
                       var toDate = $("#toDate").val();
                       var batchyear = $("#batchyear").val();
                       $.ajax({
                           type: 'POST',
                           url: "ajax-do-operation.php",
                           data: {batchyear:batchyear,fromDate:fromDate,toDate:toDate},
                           beforeSend: function (xhr) {
                               $("#btnSubmit").prop("disabled",true);
                           },
                           success: function (data) {
                               console.log(data);
                                if(data==="success"){
                                    $("#msgSuccess").show();
                                    $("#msgFailed").hide();
                                    $("#msgSuccess").html("Batch is Successfully Moved to Next Semester");
                                }else if(data==="failed"){
                                    $("#msgFailed").show();
                                    $("#msgSuccess").hide();
                                    $("#msgFailed").html("Operation Failed");
                                }
                           }
                       });
                   });
                });
            </script>
        </div>
    </body>
</html>
