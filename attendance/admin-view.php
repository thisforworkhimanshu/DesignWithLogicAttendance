<?php
session_start();
if (!isset($_SESSION['aid'])) {
    header('location:/DesignWithLogicAttendance/index.php');
    return;
}
include '../Connection.php';
$conn = new Connection();
$db = $conn->createConnection();
//get criteria adjust store in setting
$sGetCriteria = "SELECT * FROM basic_settings WHERE setting_key = 'criteria' LIMIT 1";
$rGetCriteria = $db->query($sGetCriteria);
$obj = mysqli_fetch_object($rGetCriteria);
$criteria = $obj->setting_value;
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
                var current = location.pathname;
                $('#nav li a').each(function () {
                    var $this = $(this);
                    // if the current path is like this link, make it active
                    if ($this.attr('href').indexOf(current) !== -1) {
                        $this.addClass('active');
                        return false;
                    }
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
                //script: criteria adjust setting
                $('#criteria').change(function () {
                    $.ajax({
                        type: 'POST',
                        url: "ajax-admin-att-table.php",
                        data: {criteria: $(this).val()},
                        datetype: 'json',
                        success: function (data) {
                            $('#dialog-span').text(data);
                            $("#dialog-message").dialog({
                                modal: true,
                                buttons: {
                                    Ok: function () {
                                        $(this).dialog("close");
                                        location.reload();
                                    }
                                }
                            });
                        }
                    });
                });
                //script:button for view, showing attendance in percentage
                $("#btnview").click(function () {
                    $(this).val(function (i, value) {
                        return value === "normal" ? "percentage" : "normal";
                    });
                    $(this).text(function (i, text) {
                        return text === "a|t" ? "%" : "a|t";
                    });
                    var sendData = {semester: $("#cbsemester").val(),
                        dateFrom: $("#dateFrom").val(),
                        dateTo: $("#dateTo").val(),
                        lec_type: $("#btnType").text(),
                        div: $("#btndiv").text()};
                    callAjax(sendData);
                });
                //script:button for division selection
                $(document).on('click', 'a.dropdown-item', function (event) {
                    $('#btndiv').text($(this).text());
                    var sendData = {semester: $("#cbsemester").val(),
                        dateFrom: $("#dateFrom").val(),
                        dateTo: $("#dateTo").val(),
                        lec_type: $("#btnType").text(),
                        div: $("#btndiv").text()};
                    callAjax(sendData);
                });
                //script:button for type selection
                $("#btnType").click(function () {
                    $(this).text(function (i, text) {
                        if (text == 'theory') {
                            $('#dropDiv').empty().append(
                                    $('<a>').text('B1').addClass('dropdown-item'),
                                    $('<a>').text('B2').addClass('dropdown-item'),
                                    $('<a>').text('B3').addClass('dropdown-item'),
                                    $('<a>').text('B4').addClass('dropdown-item'),
                                    $('<a>').text('B5').addClass('dropdown-item'),
                                    $('<a>').text('B6').addClass('dropdown-item'));
                            $('#btndiv').text('B1');
                        } else {
                            $('#dropDiv').empty().append(
                                    $('<a>').text('A').addClass('dropdown-item'),
                                    $('<a>').text('B').addClass('dropdown-item'));
                            $('#btndiv').text('A');
                        }
                        return text === "theory" ? "practical" : "theory";
                    });
                    var sendData = {semester: $("#cbsemester").val(),
                        dateFrom: $("#dateFrom").val(),
                        dateTo: $("#dateTo").val(),
                        lec_type: $("#btnType").text(),
                        div: $("#btndiv").text()};
                    callAjax(sendData);
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
                        var sendData = {semester: $("#cbsemester").val(),
                            dateFrom: $("#dateFrom").val(),
                            dateTo: $("#dateTo").val(),
                            lec_type: $("#btnType").text(),
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
                        var sendData = {semester: $("#cbsemester").val(),
                            dateFrom: $("#dateFrom").val(),
                            dateTo: $("#dateTo").val(),
                            lec_type: $("#btnType").text(),
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
                        var sendData = {semester: $("#cbsemester").val(), lec_type: $("#btnType").text(), div: $("#btndiv").text()};
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
                    var criteria = parseInt($('#criteria').val());
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
                                        percentage = Math.round(parseInt(value.attend) * 100 / parseInt(value.total));
                                        var setColor = 'transparent';
                                        if (percentage <= criteria) {
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
                                        if (percentage <= criteria) {
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
                    $("body").addClass("modal-open");
                    $('#mListShowEnroll').empty();
                    sel.sort();
                    for (var i = 0; i < sel.length; i++) {
                        $('#mListShowEnroll').append($('<li>').text(sel[i]).addClass('list-group-item'));
                    }
                    $("#modal").css("display", "block");
                });
                //script:button modal buttons
                $("#mbtnCancel").click(function () {
                    $("#modal").css("display", "none");
                    $("body").removeClass("modal-open");
                });
                //script: modal single date selection 
                $("#mSingleDate").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    defaultDate: '',
                    dateFormat: 'yy-mm-dd',
                    yearRange: '2018:2028',
                    maxDate: 0,
                    onSelect: function (date, instance) {
                        $.ajax({
                            type: 'POST',
                            url: "ajax-admin-update-single.php",
                            data: {singleDate: date, lec_type: $("#btnType").text(), div: $("#btndiv").text()},
                            datetype: 'json',
                            success: function (data) {
                                console.log(data);
                                jsonData = JSON.parse(data);
                                $('#mSub').empty();
                                $('#mSub').append($('<option>').text("sel"));
                                $('#mFac').empty();
                                $.each(jsonData, function (i, item) {
                                    $('#mSub').append($('<option>').text(item.sub_name).val(item.sub_code));
                                });
                            }
                        });
                    }
                });
                //scrpit: dropdown select subject msub
                $('#mSub').change(function () {
                    sub = $(this).val();
                    $('#mFac').empty();
                    $('#mFac').append($('<option>').text("sel"));
                    $.each(jsonData, function (i, item) {
                        if (sub == item.sub_code) {
                            $('#mFac').append($('<option>').text(item.fac_name).val(item.fac_id));
                        }
                    });
                });
                //script: anchor tag
                var selection = '#single';
                $('a.nav-link').click(function () {
                    selection = $(this).attr('href');
                });
                //script:button update button modal
                $('#mbtnUpdate').click(function () {
                    if (selection == '#single') {
                        var sendData = {singleDate: $('#mSingleDate').val(), sub_code: sub, fac_id: $('#mFac').val(), lec_type: $("#btnType").text(), div: $("#btndiv").text(), action: $('input[name=selAction]:checked').val(), sel: sel};
                        $.ajax({
                            type: 'POST',
                            url: "ajax-admin-update-single.php",
                            data: {sendData: JSON.stringify(sendData)},
                            datetype: 'json',
                            success: function (data) {
                                var sendData = {semester: $("#cbsemester").val(),
                                    dateFrom: $("#dateFrom").val(),
                                    dateTo: $("#dateTo").val(),
                                    lec_type: $("#btnType").text(),
                                    div: $("#btndiv").text()};
                                callAjax(sendData);
                                $("#modal").css("display", "none");
                                $("body").removeClass("modal-open");
                                sel = [];
                            }
                        });
                    } else {
                        var sendDataBulk = {dates: dates, sel: sel, action: $('input[name=selAction]:checked').val()};
                        $.ajax({
                            type: 'POST',
                            url: "ajax-admin-update-single.php",
                            data: {sendDataBulk: JSON.stringify(sendDataBulk)},
                            datetype: 'json',
                            success: function (data) {
                                var sendData = {semester: $("#cbsemester").val(),
                                    dateFrom: $("#dateFrom").val(),
                                    dateTo: $("#dateTo").val(),
                                    lec_type: $("#btnType").text(),
                                    div: $("#btndiv").text()};
                                callAjax(sendData);
                                $("#modal").css("display", "none");
                                $("body").removeClass("modal-open");
                                sel = [];
                            }
                        });
                    }
                });
                //script: multiple date selection
                var dates = [];
                function addDate(date) {
                    if (jQuery.inArray(date, dates) < 0)
                        dates.push(date);
                }
                function removeDate(index) {
                    dates.splice(index, 1);
                }
                function addOrRemoveDate(date) {
                    var index = jQuery.inArray(date, dates);
                    if (index >= 0)
                        removeDate(index);
                    else
                        addDate(date);
                }
                // Takes a 1-digit number and inserts a zero before it
                function padNumber(number) {
                    var ret = new String(number);
                    if (ret.length == 1)
                        ret = "0" + ret;
                    return ret;
                }
                $('#mMultiDate').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    defaultDate: '',
                    dateFormat: 'yy-mm-dd',
                    yearRange: '2018:2028',
                    maxDate: 0,
                    onSelect: function (date, instance) {
                        addOrRemoveDate(date);
                    },
                    beforeShowDay: function (date) {
                        var year = date.getFullYear();
                        // months and days are inserted into the array in the form, e.g "01/01/2009", but here the format is "1/1/2009"
                        var month = padNumber(date.getMonth() + 1);
                        var day = padNumber(date.getDate());
                        // This depends on the datepicker's date format
                        var dateString = year + "-" + month + "-" + day;
                        var gotDate = jQuery.inArray(dateString, dates);
                        if (gotDate >= 0) {
                            // Enable date so it can be deselected. Set style to be highlighted
                            return [true, "ui-state-highlight"];
                        }
                        // Dates not in the array are left enabled, but with no extra style
                        return [true, ""];
                    }
                });
            });
        </script>
    </head>
    <body>
        <?php require_once '../master-layout/admin/master-page-admin.php'; ?>
        <div class="p-2 mt-1">
            <?php
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
                <div class="ml-2 col-2">
                    <div class="btn-group" role="group">
                        <button id="btnType" class="btn btn-outline-primary">theory</button>

                        <div class="btn-group" role="group">
                            <button id="btndiv" type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">A</button>
                            <div id="dropDiv" class="dropdown-menu" aria-labelledby="btnDiv">
                                <a class="dropdown-item" href="#">A</a>
                                <a class="dropdown-item" href="#">B</a>
                            </div>
                        </div>
                    </div>
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
                    <button id="btnopenmodal" class="btn btn-success mr-1">update attendance</button>
                    <button id="btnprint" class="btn btn-info mr-1" disabled="true"><i class="material-icons" style="vertical-align: bottom; padding-right: 2px">insert_drive_file</i>Export</button>
                    <div class="dropdown show">
                        <i class="material-icons crossRotate" href="#" style="cursor: pointer" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">settings</i>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <li class="ml-1">
                                <label for="criteria" class="col-form-label col-form-label-sm float-left mr-1">1. adjust criteria:</label>
                                <input id="criteria" type="text" class="form-control form-control-sm col-3 m-1" value="<?= $criteria ?>">%
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
        <div id="attendance-view" class="container" style="height: 86vh">
            <div id="attendance-info" class="alert alert-info">
                <i class="material-icons" style="vertical-align: bottom">error_outline</i>&nbsp Please select semester from dropdown.
            </div>
            <table  id="attendance-table" class="record_table">        
                <thead class="bg-light">
                </thead> 
                <tbody id="body">
                </tbody> 
            </table>
        </div>

        <!--jquery dialog.........................................................-->
        <div id="dialog-message" title="Setting Change" style="display: none">
            <p>
                <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
                Your criteria setting is successfully changed to <span id="dialog-span"></span>.
            </p>
            <p style="color: red">
                page is going to reload.
            </p>
        </div>

        <!--modal html.....................................................-->
        <div id="modal" class="mymodal" style="display: none">

            <div class="mymodal-content animate">

                <div style="text-align: center">
                    <label style="color: #007bff; font-size: 12pt;" class="mr-3">Update Attendance</label>
                </div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs m-1">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#single">Single Subject</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#bulk">Change in Bulk</a>
                    </li>
                </ul>
                <div class="row p-3" style="height: 50vh">
                    <div class="col-md-6 ml-2" style="height: 50vh">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane container active" id="single">
                                <div class="form-group">
                                    <label class="col-form-label-sm" for="mDateSingle">Select Date:</label>
                                    <input type="input" class="form-control" id="mSingleDate">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label-sm" for="mSub">Select Subject:</label>
                                    <select class="form-control" style="height: 80px" id="mSub">

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label-sm" for="mFac">Select Lecturer:</label>
                                    <select class="form-control" style="height: 80px" id="mFac">

                                    </select>
                                </div>
                            </div>
                            <div class="tab-pane container fade" id="bulk">
                                <div class="form-group">
                                    <label class="col-form-label-sm" for="mMultiDate">Select Date:</label>
                                    <div id="mMultiDate"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="border border-primary rounded col-md-3" style="height: 50vh; overflow-y: auto">
                        <ul id="mListShowEnroll" class="list-group list-group-flush small"></ul>
                    </div>
                </div>
                <div class="row mt-5 ml-4 pl-3 pb-2">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="mPresent" name="selAction" class="custom-control-input" value="1">
                        <label class="custom-control-label" for="mPresent">Present</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="mAbsent" name="selAction" class="custom-control-input" value="0">
                        <label class="custom-control-label" for="mAbsent">Absent</label>
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
