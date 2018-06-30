<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>SIM: admin attendance view</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="custom.css">
        <link rel="stylesheet" href="../jquery/jquery-ui-1.12.1.custom/jquery-ui.min.css"> <!-- jquery-ui css -->
        <link rel="stylesheet" href="../bootstrap-4.1.1-dist/css/bootstrap.min.css"> <!-- bootstrap css -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> <!-- cdn google icons -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="../bootstrap-4.1.1-dist/js/bootstrap.min.js"></script> <!-- bootstrap js -->
        <script src="../jquery/jquery-3.3.1.js"></script> <!-- jquery js -->
        <script src="../jquery/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script> <!-- jquery-ui css -->
        <script src="excelexportjs.js"></script>
        <script src="../jquery/tableHeadFixer.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {

                //script:highlight the active link in navigation bar
                $(document).ready(function () {
                    var current = location.pathname;
                    $('#nav li a').each(function () {
                        var $this = $(this);
                        // if the current path is like this link, make it active
                        if ($this.attr('href').indexOf(current) !== -1) {
                            $this.addClass('active');
                            return false;
                        }
                    })
                });
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
                //script:button for view, showing attendance in percentage
                $("#btnview").click(function () {
                    $(this).val(function (i, value) {
                        return value === "normal" ? "percentage" : "normal";
                    });
                    $(this).text(function (i, text) {
                        return text === "a|t" ? "%" : "a|t";
                    });
                    sendData = {semester: $("#cbsemester").val(),
                        dateFrom: $("#dateFrom").val(),
                        dateTo: $("#dateTo").val(),
                        div: $("#btndiv").text()};
                    callAjax(sendData);
                });
                //script:button for division selection
                $("#btndiv").click(function () {
                    $(this).text(function (i, text) {
                        return text === "A" ? "B" : "A";
                    });
                    sendData = {semester: $("#cbsemester").val(),
                        dateFrom: $("#dateFrom").val(),
                        dateTo: $("#dateTo").val(),
                        div: $("#btndiv").text()};
                    callAjax(sendData);
                });
                //script:button for type selection
                $("#btntype").click(function () {
                    $(this).text(function (i, text) {
                        return text === "Theory" ? "Practical" : "Theory";
                    });
                });
                //script:button print export table to excel
                $("#btnprint").click(function () {
                    $("#attendance-table [type=checkbox]").remove();
                    $("#attendance-table").excelexportjs({
                        containerid: "attendance-table",
                        datatype: 'table'
                    });
                    $("#attendance-table > tbody tr td:first-child").prepend('<input type="checkbox">');
                });
                // script:input datepicker input selection
                $("#dateFrom").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    onSelect: function (date, instance) {
                        sendData = {semester: $("#cbsemester").val(),
                            dateFrom: $("#dateFrom").val(),
                            dateTo: $("#dateTo").val(),
                            div: $("#btndiv").text()};
                        callAjax(sendData);
                    }
                });
                $("#dateTo").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    defaultDate: '',
                    dateFormat: 'yy-mm-dd',
                    onSelect: function (date, instance) {
                        sendData = {semester: $("#cbsemester").val(),
                            dateFrom: $("#dateFrom").val(),
                            dateTo: $("#dateTo").val(),
                            div: $("#btndiv").text()};
                        callAjax(sendData);
                    }

                });
                //script:input search in table
                $('#search').click(function () {
                    $(this).val(null);
                });
                $("#search").on("keyup", function () {
                    var value = $(this).val().toLowerCase();
                    var i = 0;
                    $("#body tr").filter(function () {
                        i++;
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    });
                });
                //script:combobox semester selection combobox
                $("#cbsemester").change(function () {
                    console.log("semester selection: " + this.selectedIndex);
                    if (this.selectedIndex === 0) {
                        //disable controls on none selection
                        $("#search").prop("disabled", true);
                        $("#dateFrom").prop("disabled", true);
                        $("#dateTo").prop("disabled", true);
                        $('#btnopenmodal').prop('disabled', true);
                        $('#btnprint').prop('disabled', true);
                        $('#attendance-table').hide();
                        $('#attendance-info').show();
                    } else {
                        $('#attendance-info').hide();
                        $('#attendance-table').show();
                        sendData = {semester: $("#cbsemester").val(), div: $("#btndiv").text()};
                        callAjax(sendData);
                        $("#search").prop("disabled", false);
                        $("#dateFrom").prop("disabled", false);
                        $("#dateTo").prop("disabled", false);
                        $('#btnopenmodal').prop('disabled', false);
                        $('#btnprint').prop('disabled', false);
                    }


                });
                function callAjax(sendData) {
                    $.ajax({
                        type: 'POST',
                        url: "ajax-admin-att-table.php",
                        data: sendData,
                        datetype: 'json',
                        success: function (data) {
                            showTable(data);
                        }
                    });
                }

                function showTable(data) {
                    jsonData = $.parseJSON(data);
                    //empty table
                    $("#attendance-table > thead").empty();
                    $("#attendance-table > tbody").empty();
                    //create normal view and percentage view
                    if ($("#btnview").val() === 'normal') {
                        //create table header, normal view
                        $("#attendance-table > thead").append($('<tr>'), $('<tr>'));
                        $("#attendance-table > thead tr:first-child").append($('<th>').attr("colspan", 2));
                        $("#attendance-table > thead tr:nth-child(2)").append($('<th>').text('enrolment'), $('<th>').text('name'));
                        $.each(jsonData[0], function (i, row) {
                            if (i != 'name' && i != 'enrolment') {
                                $("#attendance-table > thead tr:first-child").append($('<th>').attr("colspan", 2).text(i).css('text-align', 'center'));
                                $("#attendance-table > thead tr:nth-child(2)").append($('<th>').text('attend').css('text-align', 'center'), $('<th>').text('total').css('text-align', 'center'));
                            }
                        });
                        //create table body, normal view
                        $.each(jsonData, function (i, row) {

                            $("#attendance-table > tbody:last-child").append($('<tr>'));
                            var $tr = $("#attendance-table > tbody tr:last-child");
                            $.each(jsonData[i], function (j, value) {
                                if (j == 'name') {
                                    $($tr).append($('<td>').text(value));
                                } else if (j == 'enrolment') {
                                    $($tr).append($('<td>').html('<input type="checkbox"/>' + value));
                                } else {
                                    if (parseInt(value.total) == 0) {
                                        percentage = 0;
                                        $($tr).append($('<td>').text('-').css("background-color", "#f2f2f2"), $('<td>').text('-').css("background-color", "#f2f2f2"));
                                    } else {
                                        percentage = parseInt(value.attend) * 100 / parseInt(value.total);
                                        var setColor = 'transparent';
                                        if (percentage < 75) {
                                            setColor = '#ffcccc';
                                        }
                                        $($tr).append($('<td>').text(value.attend).css("background-color", setColor), $('<td>').text(value.total));
                                    }

                                }
                            });
                        });
                    } else {
                        //create table header, percentage view

                        $("#attendance-table > thead").append($('<tr>'), $('<tr>'));
                        $("#attendance-table > thead tr:nth-child(2)").append($('<th>').text('enrolment'), $('<th>').text('name'));
                        $.each(jsonData[0], function (i, row) {
                            if (i != 'name' && i != 'enrolment') {
                                $("#attendance-table > thead tr:nth-child(2)").append($('<th>').text(i));
                            }
                        });
                        //create table body, percentage view
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
                                    if (parseInt(value.total) == 0) {
                                        percentage = '-';
                                        setColor = '#f2f2f2';
                                    } else {
                                        percentage = Math.round(parseInt(value.attend) * 100 / parseInt(value.total));
                                        if (percentage < 75) {
                                            setColor = '#ffcccc';
                                        }
                                    }
                                    $($tr).append($('<td>').text(percentage).css("background-color", setColor));
                                }
                            });
                        });
                    }

                    $("#attendance-table").tableHeadFixer({
                        head: true
                    });
                }

                //script: modal section-----------------------------------------

                //script:button open update attendance modal
                $("#btnopenmodal").click(function () {
                    $("#mdivShowEnroll").text(sel);
                    $("#modal").css("display", "block");
                    $("#mdivBulk").hide();
                    $("#mdivPrt").show();
                });
                //script:button modal buttons
                $("#mbtnBulk").click(function () {
                    $("#mdivPrt").hide();
                    $("#mdivBulk").show();
                });
                $("#mbtnPrt").click(function () {
                    $("#mdivBulk").hide();
                    $("#mdivPrt").show();
                });
                $("#mbtnCancel").click(function () {
                    $("#modal").css("display", "none");
                });
            });
        </script>
    </head>
    <body>
        <?php require_once '../master-layout/admin/master-page-admin.php'; ?>
        <div class="p-2 mt-1">
            <?php
            include '../Connection.php';
            $conn = new Connection();
            $db = $conn->createConnection();
            $sgetSemester = "Select DISTINCT student_semester from student";
            $rgetSemester = $db->query($sgetSemester);
            if ($rgetSemester->num_rows > 0) {
                ?>
                <div class="form-row form-group">
                    <div class="col-md-2">
                        <select name="semester" id="cbsemester" class="form-control">
                            <option >Select Semester</option>
                            <?php
                            while ($row = $rgetSemester->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $row['student_semester'] ?>"><?php echo $row['student_semester'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <?php
                    }
                    ?>
                </div>
                <div style="width: 3%">
                    <button id="btndiv" class="btn btn-block btn-outline-primary" >A</button>
                </div>
                <div class="col-md-1">
                    <button id="btntype" class="btn btn-block btn-outline-primary">Theory</button>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3">
                    <input id="search" type="text" placeholder="Search in table..." disabled="true" class="form-control">
                </div>
                <div class="col-md-5 form-inline">
                    <input type="text" id="dateFrom" disabled="true" placeholder="for date" class="form-control"> -from to-
                    <input type="text" id="dateTo" disabled="true" placeholder="last date" class="form-control">
                </div>
                <div class="form-inline ml-md-auto ml-sm-5">
                    <button id="btnopenmodal" class="btn btn-primary mr-1" disabled="true" >update attendance</button>
                    <button id="btnprint" class="btn btn-success mr-1" disabled="true"><i class="material-icons" style="vertical-align: bottom; padding-right: 2px">insert_drive_file</i>Export</button>
                    <div class="dropdown show">
                        <i class="material-icons crossRotate" href="#" style="cursor: pointer" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">settings</i>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <li class="ml-1">
                                <label for="criteria" class="col-form-label col-form-label-sm float-left mr-1">1. adjust criteria:</label>
                                <input id="criteria" type="text" class="form-control form-control-sm col-3 m-1">%
                            </li>
                            <li class="ml-1">
                                <label for="btnview" class="col-form-label col-form-label-sm float-left mr-1">2. change view:</label>
                                <button id="btnview" value="normal" class="btn btn-sm col-3 btn-outline-primary m-2">a|t</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>     
        </div>
        <hr/>
        <div id="attendance-view" class="container" style="height: 510px">
            <div id="attendance-info" class="alert alert-info">
                <i class="material-icons" style="vertical-align: bottom">error_outline</i>&nbspNothing to dispaly here :(
            </div>
            <table  id="attendance-table" class="record_table">        
                <thead class="bg-light">
                </thead> 
                <tbody id="body">
                </tbody> 
            </table>
        </div>

        <!--modal html.....................................................-->
        <div id="modal" class="mymodal">

            <div class="mymodal-content animate">

                <div class="" style="text-align: center">
                    <label style="color: gray; font-family: inherit; font-size: 25px;">Update Attedance</label>
                </div>
                <div style="text-align: center" class="my-tab">
                    <button value="single" id="mbtnPrt">single subject</button>
                    <button value="bulk" id="mbtnBulk">change in bulk</button>                    
                </div>
                <div id="mdivShowEnroll" class=" mymodal-container border border-primary rounded" style="margin: 1%;overflow: auto">
                    enrollments will be shown here
                </div>

                <div class="mymodal-container">
                    <!--       Bulk division-->  
                    <div class="mymodal-container" id="mdivBulk" style="justify-content: center;">
                        <label style="color: gray; font-family: inherit; font-size: 17px;">Select Dates</label>
                        <br>
                        <div id="bulckDate"></div>
                        <div id="print-array"></div>
                    </div>

                    <!--        particular division-->
                    <div class="mymodal-container" id="mdivPrt" style="justify-content: center;">
                        <label style="color: gray; font-family: inherit;">Select Date:</label>
                        <input id="dateSingle" placeholder="Select Date..">
                        <br>
                        <br>
                        <label style="color: gray; font-family: inherit;">Select Faculty:</label>
                        <input list="faculty" placeholder="Select Faculty..">
                        <datalist id="faculty">
                            <option value="Internet Explorer">
                            <option value="Firefox">
                            <option value="Chrome">
                            <option value="Opera">
                            <option value="Safari">
                        </datalist>
                        <br>
                        <br>
                        <label style="color: gray; font-family: inherit;">Select Subject:</label>
                        <input list="subject" placeholder="Select Subject">
                        <datalist id="subject">
                            <option value="Internet Explorer">
                            <option value="Firefox">
                            <option value="Chrome">
                            <option value="Opera">
                            <option value="Safari">
                        </datalist>
                        <br>
                    </div>
                    <div class="mymodal-container">
                        <input type="radio" value="Present" name="A/P"><label>Present</label>
                        <input type="radio" value="Absent" name="A/P"><label>Absent</label>
                    </div>

                </div>
                <div class="mymodal-container" style="border-top: lightgray solid 0.5pt">
                    <button id="mbtnUpdate" class="btn btn-outline-success">Update</button>
                    <button id="mbtnCancel" class="btn btn-outline-danger" style="float: right">Cancel</button>
                </div>
            </div>
        </div>
    </body>
</html>
