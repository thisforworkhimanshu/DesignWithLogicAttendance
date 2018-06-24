<?php
session_start();
if (!isset($_SESSION['fid'])) {
    header("location:/DesignWithLogicAttendance/facultyLogin.php");
    return;
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>SIM: faculty attendance view</title>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script>
            $(document).ready(function () {
                var lec_type = '';

                //script:button fatch allocated theory division or practical batch
                $("#theory").click(function () {
                    lec_type = 'theory';
                    $("#division").prop("disabled", true);
                    $("#subject").prop("disabled", false);
                    $("#subject").empty();
                    var sendData = {'lec_type': lec_type};
                    callAjax(sendData);
                });
                $("#practical").click(function () {
                    lec_type = 'practical';
                    $("#division").prop("disabled", true);
                    $("#subject").prop("disabled", false);
                    $("#subject").empty();
                    var sendData = {'lec_type': lec_type};
                    callAjax(sendData);
                });

                //script: combobox fatch subject and call ajax after subject selection
                $("#division").change(function () {
                    if (this.selectedIndex !== 0) {
                        var sendData = {'lec_type': lec_type, 'div': $(this).val(), 'sub': $("#subject").val()};
                        callAjaxTable(sendData);
                    }
                });
                $("#subject").change(function () {
                    $("#division").prop("disabled", false);
                    $("#division").empty();
                    var sendData = {'sub': $(this).val(), 'lec_typed': lec_type};
                    callAjax(sendData, 'div');
                });

                function callAjax(sendData, type) {
                    $.ajax({
                        type: 'POST',
                        url: "ajax-faculty-view-subject.php",
                        data: sendData,
                        success: function (data, textStatus, jqXHR) {
                            if (type == 'div') {
                                appendDivision(data);
                            } else {
                                appendSubject(data);
                            }
                        }
                    });
                }

                function callAjaxTable(sendData) {
                    $.ajax({
                        type: 'POST',
                        url: "ajax-faculty-viewtable.php",
                        data: sendData,
                        success: function (data, textStatus, jqXHR) {
                            console.log(data);
                        }
                    });
                }
                
                function appendTable(data){
                   var jsonData = $.parseJSON(data);
                   
                }
                
                function appendDivision(data) {
                  var  jsonData = $.parseJSON(data);
                    $("#division").append($("<option>").text("--Select division--"));
                    $.each(jsonData, function (i, item) {
                        $("#division").append($("<option>").text(item).val(item));
                    });
                }

                function appendSubject(data) {
                   var jsonData = $.parseJSON(data);
                    $("#subject").append($("<option>").text("--Select subject--"));
                    $.each(jsonData, function (i, item) {
                        $("#subject").append($("<option>").text(item.short_name).val(item.subject_code));
                    });
                }

                //script: get table data on subject seletion

            });
        </script>

    </head>
    <body>
        <div>
            <div class="btn-group form-group d-flex justify-content-center" role="group" aria-label="selection" style="float: left;padding: 5px">
                <button type="button" class="btn btn-outline-primary" id="theory" value="theory">Theory</button>
                <button type="button" class="btn btn-outline-primary" id="practical" value="practical">Practical</button>
            </div>
            <select class="form-control-sm border border-primary" id="subject" name="subject" style="margin: 5px" disabled="true">
                <option>--Select subject--</option>
            </select>
            <select class="form-control-sm border border-primary" id="division" name="division" style="margin: 5px" disabled="true">
                <option>--Select division--</option>
            </select>

        </div>
        <br/>
        <div>
            <input type="text" id="search" placeholder="search in table" disabled="true">
            <input type="text" id="dateFrom" disabled="true"> -from to-
            <input type="text" id="dateTo"  disabled="true">
            <button type="button" class="btn btn-success" id="modal">change</button>
        </div>
        <hr/>
        <div id="attendance-view">
            <table id="attendance-table" class="record_table">
                <thead>

                </thead>
                <tbody id="body">

                </tbody>
            </table>
        </div>
    </body>
</html>
