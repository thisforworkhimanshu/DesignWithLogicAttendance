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
                    <h5>Change Marks</h5>
                </div>
            </div>
            <form action="showSubjects.php" method="get">
                <div class="row form-group">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <select class="form-control" name="semester" id="semester" required>
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
                        
                        <script>
                        $(document).ready(function() {
                            $("#subject").prop("disabled",true);
                            $("#examtype").prop("disabled",true);
                            $("#enrolment").prop("disabled",true);
                            $("#marks").prop("disabled",true);
                            $("#btnSubmit").prop("disabled",true);
                            $("#semester").change(function(){
                                if(this.selectedIndex===0){
                                    $("#subject").prop("disabled",true);
                                    $("#examtype").prop("disabled",true);
                                    $("#enrolment").prop("disabled",true);
                                    $("#marks").prop("disabled",true);
                                    $("#btnSubmit").prop("disabled",true);
                                }else{
                                    var sem = $("#semester").val();
                                    $.post('ajax-processSubject.php',{semester:sem},
                                    function(response) {
                                        $("#subject").prop("disabled",false);
                                        $("#subject").html(response);
                                    }).fail(function(){

                                    });
                                }
                            });
                            $("#subject").change(function(){
                                if(this.selectedIndex===0){
                                    $("#examtype").prop("disabled",true);
                                    $("#enrolment").prop("disabled",true);
                                    $("#marks").prop("disabled",true);
                                    $("#btnSubmit").prop("disabled",true);
                                }else{
                                    $("#examtype").prop("disabled",false);
                                }
                            });
                            $("#examtype").change(function(){
                                if(this.selectedIndex===0){
                                    $("#enrolment").prop("disabled",true);
                                    $("#marks").prop("disabled",true);
                                    $("#btnSubmit").prop("disabled",true);
                                }else{
                                    $("#enrolment").prop("disabled",false);
                                }
                            });
                        }); 
                    </script>
                        
                        <div class="form-group">
                            <select id="subject" name="subject" class="form-control">
                                <option>--Select Subject--</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="examtype" id="examtype" required>
                                <option value="">--Select Exam Type--</option>
                                <option value="m">Mid Semester Exam</option>
                                <option value="r">Remedial Exam for Mid</option>
                                <option value="v">Internal Viva</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <input type="text" name="enrolment" id="enrolment" class="form-control" placeholder="Enrolment" required/>
                        </div>
                        
                        <script>
                            $(document).ready(function(){
                               $("#enrolment").focusout(function(){
                                    var enrol = $("#enrolment").val();
                                    var sem = $("#semester").val();
                                    var examtype = $("#examtype").val();
                                    var subject = $("#subject").val();
                                    var enrol = $("#enrolment").val();
                                    if(enrol===""){
                                        alert('Input Enrolment Please');
                                        $("#marks").prop("disabled",true);
                                        $("#btnSubmit").prop("disabled",true);
                                    }else{
                                        $.ajax({
                                            type: 'POST',
                                            url: "ajax-get-Marks.php",
                                            data: {enrolment:enrol,semester:sem,examtype:examtype,subject:subject},
                                            success: function(data){
                                                if(data===""){
                                                    $("#marks").prop("disabled",true);
                                                    $("#btnSubmit").prop("disabled",true);
                                                }else{
                                                    $("#marks").val(data);
                                                    $("#marks").prop("disabled",false);
                                                    $("#btnSubmit").prop("disabled",false);
                                                }
                                                
                                            }
                                        });
                                    }
                               });
                               
                            });
                        </script>
                        
                        <div class="form-group">
                            <input type="text" name="marks" id="marks" class="form-control" placeholder="Your Marks will appear Here"/>
                        </div>
                        
                        <script>
                            $(document).ready(function(){
                               $("#btnSubmit").click(function(){
                                    var enrol = $("#enrolment").val();
                                    var sem = $("#semester").val();
                                    var examtype = $("#examtype").val();
                                    var subject = $("#subject").val();
                                    var mark = $("#marks").val();
                                    
                                    if(mark===""){
                                        alert('Input All Details Please');
                                    }else{
                                        if(examtype==="m"){
                                            if(mark>30){
                                                alert('Mark Should Be Less Than 30');
                                            }else if(mark<0){
                                                alert('Mark Should Be Greater Than 0');
                                            }else{
                                                $.ajax({
                                                    type: 'POST' ,
                                                    url: "ajax-change-mark.php",
                                                    data: {enrolment:enrol,semester:sem,examtype:examtype,subject:subject,mark:mark},
                                                    success: function (data) {
                                                        console.log(data);
                                                        if(data==="ok"){
                                                            alert("Marks Change Success");
                                                            $("#enrolment").val("");
                                                            $("#marks").val("");
                                                        }else{
                                                            alert("Marks Changing Failed...");
                                                        }
                                                    }
                                                });
                                            }
                                        }else if(examtype==="r"){
                                            if(mark>30){
                                                alert('Mark Should Be Less Than 30');
                                            }else if(mark<0){
                                                alert('Mark Should Be Greater Than 0');
                                            }else{
                                                $.ajax({
                                                    type: 'POST' ,
                                                    url: "ajax-change-mark.php",
                                                    data: {enrolment:enrol,semester:sem,examtype:examtype,subject:subject,mark:mark},
                                                    success: function (data) {
                                                        console.log(data);
                                                        if(data==="ok"){
                                                            alert("Marks Change Success");
                                                            $("#enrolment").val("");
                                                            $("#marks").val("");
                                                        }else{
                                                            alert("Marks Changing Failed...");
                                                        }
                                                    }
                                                });
                                            }
                                        }else if(examtype==="v"){
                                            if(mark>20){
                                                alert('Mark Should Be Less Than 20');
                                            }else if(mark<0){
                                                alert('Mark Should Be Greater Than 0');
                                            }else{
                                                $.ajax({
                                                    type: 'POST' ,
                                                    url: "ajax-change-mark.php",
                                                    data: {enrolment:enrol,semester:sem,examtype:examtype,subject:subject,mark:mark},
                                                    success: function (data) {
                                                        console.log(data);
                                                        if(data==="ok"){
                                                            alert("Marks Change Success");
                                                            $("#enrolment").val("");
                                                            $("#marks").val("");
                                                        }else{
                                                            alert("Marks Changing Failed...");
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                    }
                                    return false;
                               });
                            });
                        </script>
                        
                        <div class="form-group">
                            <input type="submit" id="btnSubmit" name="btnSubmit" value="Change" class="form-control btn btn-primary"/>
                        </div>
                        
                    </div>
                </div>
            </form>
            <script>
                $(document).ready(function(){
                   $("#btnSubmit").click(function(){
                      var sem = $("#semester").val();
                      var examtype = $("#examtype").val();
                      var enrol = $("#enrolment").val();
                      if(sem===""||examtype===""||enrol===""){
                          alert('Please Fill All Details');
                          return false;
                      }else{
                          return true;
                      }
                   });
                });
            </script>
        </div>
    </body>
</html>
