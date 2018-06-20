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
            <div class="badge-light" style="margin-top: 0.5%;">
                <div class="text-center">
                    <h5 style="font-size: 1.3vw;">Practical Batch Allocation To Students</h5>
                </div>
            </div>
            
            <script>
                $(document).ready(function(){
                   $("#batchyear").focus();
                   $("#division").hide();
                   
                    $("#batchyear").focusout(function(){
                        if($(this).val()===""){
                            $("#totalcountdiv").show();
                            $("#totalcountdiv").html('No Students');
                            $("#division").hide();
                            $("#suggest-div-alloc").hide();
                            $("#gowithsuggestion").hide();
                            $("#suggest-div-success").hide();
                            $("#suggestion-text").hide();
                            $("#orinput").hide();
                        }
                    });
                   
                   $("#batchyear").keyup(function(){
                       var batchyear = $(this).val();
                       
                       if(parseInt(batchyear)===0){
                           alert('Zero value not accepted')
                       }else{
                           $.ajax({
                                type: 'POST',
                                url: "ajax-total-count-student.php",
                                data: {batchyear: batchyear},
                                success: function (data) {
                                    var res = data.substring(0,2);
                                    if(res==="ok"){
                                        var stdcount = data.substring(2);
                                        if(stdcount==0){
                                            $("#totalcountdiv").show();
                                            $("#totalcountdiv").html('No Students');
                                            $("#division").hide();
                                            $("#suggest-div-alloc").hide();
                                            $("#gowithsuggestion").hide();
                                            $("#suggest-div-success").hide();
                                            $("#suggestion-text").hide();
                                             $("#orinput").hide();
                                        }else{
                                            $("#totalcountdiv").show();
                                            $("#totalcountdiv").html('Total Number of Students : <b>'+stdcount+'</b>');
                                            $.ajax({
                                               type: 'POST',
                                               url: "ajax-batchyear-prac-batch.php",
                                               data: {batchyear: batchyear},
                                               success: function (data) {
                                                   var semester = data;
                                                   if(semester==1 || semester == 2){
                                                       $("#division option[value='B5']").prop("disabled",true);
                                                       $("#division option[value='B6']").prop("disabled",true);
                                                   }
                                               }
                                            });

                                            $("#division").show();
                                            $("#orinput").hide();
                                        }
                                    }
                                }
                           });
                       }
                       
                   });
                   
                   
                   $("#division").change(function(){
                        $("#suggestion-text").hide();
                        $("#suggest-div-alloc").hide();
                        $("#gowithsuggestion").hide();
                        $("#orinput").hide();
                        var divVal = $(this).val();
                        var batchyear = $("#batchyear").val();
                        if(this.selectedIndex===0){
                            $("#suggestion-text").hide();
                            $("#suggest-div-alloc").hide();
                            $("#gowithsuggestion").hide();
                            $("#orinput").hide();
                        }else{
                            $.ajax({
                                type: 'POST',
                                url: "ajax-division-suggest.php",
                                data: {batchyear: batchyear,divVal:divVal},
                                success: function (data) {
                                    console.log(data);
                                    var JSONObject = JSON.parse(data);
                                    var toenrol = JSONObject.toenrol;
                                    var fromenrol = JSONObject.fromenrol;
                                    $("#suggestion-text").fadeIn(1000,function(){
                                        $("#suggestion-text").fadeOut(function() {
                                            $("#fromenrol").val(fromenrol);
                                            $("#toenrol").val(toenrol);
                                            $("#suggest-div-alloc").show();
                                            $("#suggest-div-alloc").html(divVal+' : <b>'+fromenrol+'</b> <i>to</i>  <b>'+toenrol+'</b>');
                                            $("#gowithsuggestion").show();
                                            $("#orinput").show();
                                            $("#toenrolinp").val(toenrol);
                                            $("#fromenrolinp").val(fromenrol);
                                        });
                                    });
                                }
                            });   
                        }
                   });
                   
                   $("#btnSuggest").click(function(){
                        var fromenrol = $("#fromenrol").val();
                        var toenrol = $("#toenrol").val();
                        var divVal = $("#division").val();
                        var batchyear = $("#batchyear").val();
                        $.ajax({
                            type: 'POST',
                            url: "ajax-allocate-division.php",
                            data: {toenrol: toenrol,fromenrol: fromenrol,divVal:divVal,batchyear:batchyear},
                            success: function(data) {
                                console.log(data);
                                if(data==="ok"){
                                    $body = $("body");
                                    $("#gowithsuggestion").hide();
                                    $("#suggest-div-success").show();
                                    $("#suggest-div-success").html('Successfully Allocated');
                                    $("#btnSuggest").prop("disabled",true);
                                    $body.addClass("loading1");
                                    setTimeout(function(){
                                       window.location.href="student-prac-batch-allocation.php"; 
                                       $body.removeClass("loading1");
                                    },5000);
                                }else{
                                    $body = $("body");
                                    $("#gowithsuggestion").hide();
                                    $("#suggest-div-success").show();
                                    $("#suggest-div-success").html('Operation Failed');
                                    $("#btnSuggest").prop("disabled",true);
                                    $body.addClass("loading1");
                                    setTimeout(function(){
                                       window.location.href="student-prac-batch-allocation.php"; 
                                       $body.removeClass("loading1");
                                    },2000);
                                }
                            }
                        });
                        return false;
                    });
                });
            </script>
            
            <div class="division-allocation" style="margin-top: 2%;">
                <div class="row form-group">
                    <div class="col-sm-2">
                        <input type="text" name="batchyear" placeholder="Batch Year" id="batchyear" class="form-control"/>
                    </div>
                    <div id="totalcountdiv" class="col-4 text-center form-control alert-success" style="display: none;"></div>
                </div>
                
                <div class="row form-group">
                    <div class="col-sm-2">
                        <select name="divison" id="division" class="form-control">
                            <option value="">Select Batch</option>
                            <option value="B1">B1</option>
                            <option value="B2">B2</option>
                            <option value="B3">B3</option>
                            <option value="B4">B4</option>
                            <option value="B5">B5</option>
                            <option value="B6">B6</option>
                        </select>
                    </div>
                    <input type="hidden" id="fromenrol" name="fromenrol"/>
                    <input type="hidden" id="toenrol" name="toenrol"/>
                    <div id="suggestion-text" class="col-4 text-center form-control alert-light" style="display: none;">Suggestion for Division</div>
                    <div id="suggest-div-alloc" class="col-4 text-center form-control alert-success" style="display: none;"></div>
                    <div id="gowithsuggestion" class="col-sm-2 form-group" style="display: none;"><button id="btnSuggest" class="form-control btn btn-primary text-center">Go With Suggestion</button></div>
                    <div id="suggest-div-success" class="col-sm-4 text-center form-control alert-success" style="margin-left: 2%; display: none;"></div>
                </div>
            </div>
            <script>
                $(document).ready(function(){
                    $("#orinput").hide();
                    $("#btnSubmit").click(function(){
                        $("#gowithsuggestion").hide();
                        var fromenrol = $("#fromenrolinp").val();
                        var toenrol = $("#toenrolinp").val();
                        var divVal = $("#division").val();
                        var batchyear = $("#batchyear").val();
                        $.ajax({
                            type: 'POST',
                            url: "ajax-allocate-division.php",
                            data: {toenrol: toenrol,fromenrol: fromenrol,divVal:divVal,batchyear:batchyear},
                            success: function(data) {
                                console.log(data);
                                if(data==="ok"){
                                    $body = $("body");
                                    $("#inputdetailmsg").show();
                                    $("#inputdetailmsg").html('<div class="alert alert-success">Successfully Allocated</div>');
                                    $("#btnSubmit").prop("disabled",true);
                                    $("#gowithsuggestion").hide();
                                    $body.addClass("loading1");
                                    setTimeout(function(){
                                       window.location.href="student-prac-batch-allocation.php"; 
                                       $body.removeClass("loading1");
                                    },3000);
                                }else{
                                    $body = $("body");
                                    $("#inputdetailmsg").show();
                                    $("#inputdetailmsg").html('<div class="alert alert-success">Operation Failed</div>');
                                    $("#btnSubmit").prop("disabled",true);
                                    $body.addClass("loading1");
                                    $("#gowithsuggestion").hide();
                                    setTimeout(function(){
                                       window.location.href="student-prac-batch-allocation.php"; 
                                       $body.removeClass("loading1");
                                    },3000);
                                }
                            }
                        });
                        return false;
                    }); 
                });
            </script>
            <div id="orinput">
                <div style="margin-left: 48%;">OR</div>
                <hr/>
                <div><code style="color: red;"><b>*</b>Only Fill Details If you dont want to go with Suggestions and <strong>Above Batch year and Division must be inputed</strong> </code></div>
                <br/>
                <div id="inputdetail" class="form-group">
                    <form id="alloc-div-form">
                        <div class="row">
                                <div class="col-2 text-center">Enrolment From:</div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="fromenrolinp" required/> 
                                </div>

                                <div class="col-2 text-center">Enrolment To:</div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="toenrolinp" required/> 
                                </div>
                        </div>
                        <div style="margin-left: 40%; margin-top: 3%;">
                            <div id="divbtnGo" style="width: 30%;"><button type="submit" id="btnSubmit" class="btn btn-primary form-control">Allocate Division</button></div>
                        </div>
                    </form>
                </div>
                <div id="inputdetailmsg" style="width: 40%; margin-left: 30%;"></div>
            </div>
        </div>
        <div class="modal1"></div>
    </body>
</html>
