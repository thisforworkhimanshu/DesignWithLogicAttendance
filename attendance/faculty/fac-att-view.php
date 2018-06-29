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
        <link rel="stylesheet" href='../custom.css'>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> <!-- cdn google icons -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="../excelexportjs.js"></script>

        <script>
            $(document).ready(function () {

                var sel = []; //store selected student from table 

                //script:event table click event and selection
                $(document).on("click", ".record_table tr", function (event) {
                    if (event.target.type !== 'checkbox') {
                        $(':checkbox', this).trigger('click');
                        var temp = $("td:first", this).text();
                        if ($(':checkbox', this).is(":checked")) {
                            if (!sel.includes(temp)) {
                                sel.push(temp);
                            }

                        } else {
                            var index = sel.indexOf(temp);
                            if (index > -1) {
                                sel.splice(index, 1);
                            }
                        }

                    }
                });
                $(document).on("change", "input[type='checkbox']", function (event) {
                    if ($(this).is(":checked")) {
                        $(this).closest('tr').addClass("highlight_row");
                    } else {
                        $(this).closest('tr').removeClass("highlight_row");
                    }
                });

                //script:input search in table
                $("#search").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    var i = 0;
                    $("#body tr").filter(function () {
                        i++;
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    });
                });

                var lec_type = ''; //send lecture_type for ajax call

                //script:button fatch allocated theory division or practical batch
                $("#theory").click(function () {
                    lec_type = 'theory';

                    //disable and enable componants
                    $("#search").prop("disabled", true);
                    $("#dateFrom").prop("disabled", true);
                    $("#dateTo").prop("disabled", true);
                    $("#division").prop("disabled", true);
                    $("#subject").prop("disabled", false);

                    //empty componants
                    $("#attendance-table > thead").empty();
                    $("#attendance-table > tbody").empty();
                    $("#subject").empty();

                    var sendData = {'lec_type': lec_type};
                    callAjax(sendData);
                });
                $("#practical").click(function () {
                    lec_type = 'practical';

                    //disable and enable componants
                    $("#search").prop("disabled", true);
                    $("#dateFrom").prop("disabled", true);
                    $("#dateTo").prop("disabled", true);
                    $("#division").prop("disabled", true);
                    $("#subject").prop("disabled", false);

                    //empty componants
                    $("#attendance-table > thead").empty();
                    $("#attendance-table > tbody").empty();
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

                // script:input datepicker input selection
                $("#dateFrom").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    onSelect: function (date, instance) {
                        var sendData = {'lec_type': lec_type,
                            'div': $('#division').val(),
                            'sub': $("#subject").val(),
                            dateFrom: $("#dateFrom").val(),
                            dateTo: $("#dateTo").val()};
                        callAjaxTable(sendData);
                    }
                });
                $("#dateTo").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    defaultDate: '',
                    dateFormat: 'yy-mm-dd',
                    onSelect: function (date, instance) {
                        var sendData = {'lec_type': lec_type,
                            'div': $('#division').val(),
                            'sub': $("#subject").val(),
                            dateFrom: $("#dateFrom").val(),
                            dateTo: $("#dateTo").val()};
                        callAjaxTable(sendData);
                    }

                });

                //script:button print export table to excel
                $("#print").click(function () {
                    $("#attendance-table [type=checkbox]").remove();
                    $("#attendance-table").excelexportjs({
                        containerid: "attendance-table",
                        datatype: 'table'
                    });
                    $("#attendance-table > tbody tr td:first-child").prepend('<input type="checkbox">');
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
                            appendTable(data);
                        }
                    });
                }

                //script: apppend table data on subject seletion
                function appendTable(data) {
                    var jsonData = $.parseJSON(data);

                    //empty table
                    $("#attendance-table > thead").empty();
                    $("#attendance-table > tbody").empty();

                    //create table header, attendace view by dates
                    $("#attendance-table > thead").append($('<tr>'));
                    $("#attendance-table > thead tr:first-child").append($('<th>').text('enrolment'), $('<th>').text('name'));
                    $.each(jsonData[0], function (i, row) {
                        if (i != 'name' && i != 'enrolment') {
                            $("#attendance-table > thead tr:first-child").append($('<th>').text(i));
                        }
                    });

                    //create table body, attendace view by dates
                    $.each(jsonData, function (i, row) {
                        $("#attendance-table > tbody:last-child").append($('<tr>'));
                        var $tr = $("#attendance-table > tbody tr:last-child");
                        $.each(jsonData[i], function (j, value) {
                            if (j == 'name') {
                                $($tr).append($('<td>').text(value));
                            } else if (j == 'enrolment') {
                                $($tr).append($('<td>').html('<input type="checkbox"/>' + value));
                            } else {
                                var setColor = 'transparent';
                                if (value == 0) {
                                    value = 'absent';
                                    setColor = '#ffcccc';
                                } else if (value == 1) {
                                    value = 'present';
                                }
                                $($tr).append($('<td>').text(value).css("background-color", setColor));
                            }
                        });
                    });

                    //after table successfully append enable search and date filter fields
                    $("#search").prop("disabled", false);
                    $("#dateFrom").prop("disabled", false);
                    $("#dateTo").prop("disabled", false);
                }

                function appendDivision(data) {
                    var jsonData = $.parseJSON(data);
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



            });
        </script>

    </head>
    <body>
        <?php include '../../master-layout/faculty/master-faculty-layout.php'; ?>
        <div class="form-inline">
            <div class="btn-group form-group d-flex justify-content-center form-group mb-2" role="group" aria-label="selection" style="float: left;padding: 5px">
                <button type="button" class="btn btn-outline-primary" id="theory" value="theory">Theory</button>
                <button type="button" class="btn btn-outline-primary" id="practical" value="practical">Practical</button>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <select class="form-control-sm border border-primary" id="subject" name="subject" style="margin: 5px" disabled="true">
                    <option>--Select subject--</option>
                </select>
                <select class="form-control-sm border border-primary" id="division" name="division" style="margin: 5px" disabled="true">
                    <option>--Select division--</option>
                </select>
            </div>

        </div>
        <br/>
        <div>
            <input type="text" id="search" placeholder="search in table" disabled="true">
            <input type="text" id="dateFrom" disabled="true"> -from to-
            <input type="text" id="dateTo"  disabled="true">
            <button type="button" class="btn btn-success" id="modal">change</button>
            <button id="print" class="btn btn-info">export to excel!</button>
        </div>
        <hr/>
        <div id="attendance-view" class="container">
            <table id="attendance-table" class="record_table">
                <thead>

                </thead>
                <tbody id="body">

                </tbody>
            </table>
        </div>
    </body>
</html>
