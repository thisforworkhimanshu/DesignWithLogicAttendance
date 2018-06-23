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

                //script:button fatch allocated theory division or practical batch
                $("#theory").click(function () {
                    $("#division").prop("disabled", false);
                    $("#subject").prop("disabled", true);
                    $("#division").empty();
                    var sendData = {'type': 'theory'};
                    callAjax(sendData, "div");
                });
                $("#practical").click(function () {
                    $("#division").prop("disabled", false);
                    $("#subject").prop("disabled", true);
                    $("#division").empty();
                    var sendData = {'type': 'practical'};
                    callAjax(sendData, "div");
                });

                //script: combobox fatch subject
                $("#division").change(function () {
                    $("#subject").prop("disabled", false);
                    $("#subject").empty();
                    var sendData = {'division': $(this).val()};
                    callAjax(sendData);
                });

                function callAjax(sendData, type) {
                    $.ajax({
                        type: 'POST',
                        url: "ajax-faculty-subject.php",
                        data: sendData,
                        success: function (data, textStatus, jqXHR) {
                            if (type == 'div') {
                                appendDivision(data);
                            } else {
                                console.log(data);
                                appendSubject(data);
                            }
                        }
                    });
                }

                function appendDivision(data) {
                    jsonData = $.parseJSON(data);
                    $("#division").append($("<option>").text("--Select division--"));
                    $.each(jsonData, function (i, item) {
                        $("#division").append($("<option>").text(item).val(item));
                    });
                }

                function appendSubject(data) {
                    jsonData = $.parseJSON(data);
                    $("#subject").append($("<option>").text("--Select subject--"));
                    $.each(jsonData, function (i, item) {
                        $("#subject").append($("<option>").text(item.short_name).val(item.subject_code));
                    });
                }

            });
        </script>

    </head>
    <body>
        <div>
            <div class="btn-group form-group d-flex justify-content-center" role="group" aria-label="selection" style="float: left;padding: 5px">
                <button type="button" class="btn btn-outline-primary" id="theory" value="theory">Theory</button>
                <button type="button" class="btn btn-outline-primary" id="practical" value="practical">Practical</button>
            </div>
            <select class="form-control-sm border border-primary" id="division" name="division" style="margin: 5px" disabled="true">
                <option>--Select division--</option>
            </select>
            <select class="form-control-sm border border-primary" id="subject" name="subject" style="margin: 5px" disabled="true">
                <option>--Select subject--</option>
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
