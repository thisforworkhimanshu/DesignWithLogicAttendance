<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="custom.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="excelexportjs.js"></script> 

        <script type="text/javascript">
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

                //script:button for view, showing attendance in persentage
                $("#view").click(function () {
                    $(this).val(function (i, value) {
                        return value === "normal" ? "percentage" : "normal";
                    });
                    $(this).text(function (i, text) {
                        return text === "a|t" ? "%" : "a|t";
                    });
                    sendData = {semester: $("#semester").val(),
                        dateFrom: $("#dateFrom").val(),
                        dateTo: $("#dateTo").val(),
                        div: $("#div").text()};
                    callAjax(sendData);
                });

                //script:button for division selection
                $("#div").click(function () {
                    $(this).text(function (i, text) {
                        return text === "A" ? "B" : "A";
                    });
                    sendData = {semester: $("#semester").val(),
                        dateFrom: $("#dateFrom").val(),
                        dateTo: $("#dateTo").val(),
                        div: $("#div").text()};
                    callAjax(sendData);

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

                // script:input datepicker input selection
                $("#dateFrom").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    onSelect: function (date, instance) {
                        sendData = {semester: $("#semester").val(),
                            dateFrom: $("#dateFrom").val(),
                            dateTo: $("#dateTo").val(),
                            div: $("#div").text()};
                        callAjax(sendData);
                    }
                });
                $("#dateTo").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    defaultDate: '',
                    dateFormat: 'yy-mm-dd',
                    onSelect: function (date, instance) {
                        sendData = {semester: $("#semester").val(),
                            dateFrom: $("#dateFrom").val(),
                            dateTo: $("#dateTo").val(),
                            div: $("#div").text()};
                        callAjax(sendData);
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

                //script:combobox semester selection combobox
                $("#semester").change(function () {
                    console.log("semester selection: " + this.selectedIndex);
                    if (this.selectedIndex === 0) {
                        $("#search").prop("disabled", true);
                        $("#dateFrom").prop("disabled", true);
                        $("#dateTo").prop("disabled", true);
                        $("#attendance-view").text("nothing to display...");
                    } else {
                        sendData = {semester: $("#semester").val(), div: $("#div").text()};
                        callAjax(sendData);
                        $("#search").prop("disabled", false);
                        $("#dateFrom").prop("disabled", false);
                        $("#dateTo").prop("disabled", false);
                    }


                });

                function callAjax(sendData) {
                    $.ajax({
                        type: 'POST',
                        url: "ajax-admin-att-table.php",
                        data: sendData,
                        datetype: 'json',
                        beforeSend: function (xhr) {
//                            $("#attendance-view").hide();
                        },
                        success: function (data) {
                            showTable(data);
//                            $("#attendance-view").show();
                        }
                    });
                }

                function showTable(data) {
                    jsonData = $.parseJSON(data);
                    //empty table
                    $("#attendance-table > thead").empty();
                    $("#attendance-table > tbody").empty();

                    //create normal view and percentage view
                    if ($("#view").val() === 'normal') {
                        //create table header, normal view
                        $("#attendance-table > thead").append($('<tr>'), $('<tr>'));
                        $("#attendance-table > thead tr:first-child").append($('<th>').attr("colspan", 2));
                        $("#attendance-table > thead tr:nth-child(2)").append($('<th>').text('enrolment').css({"width": "140px"}), $('<th>').css({"width": "430px"}).text('name'));
                        $.each(jsonData[0], function (i, row) {
                            if (i != 'name' && i != 'enrolment') {
                                $("#attendance-table > thead tr:first-child").append($('<th>').attr("colspan", 2).css({"width": "80px"}).text(i));
                                $("#attendance-table > thead tr:nth-child(2)").append($('<th>').css({"width": "44px"}).text('attend'), $('<th>').css({"width": "44px"}).text('total'));
                            }
                        });

                        //create table body, normal view
                        $.each(jsonData, function (i, row) {

                            $("#attendance-table > tbody:last-child").append($('<tr>'));
                            var $tr = $("#attendance-table > tbody tr:last-child");
                            $.each(jsonData[i], function (j, value) {
                                if (j == 'name') {
                                    $($tr).append($('<td>').css({"width": "400px"}).text(value));
                                } else if (j == 'enrolment') {
                                    $($tr).append($('<td>').css({"width": "134px"}).html('<input type="checkbox"/>' + value));
                                } else {
                                    if (parseInt(value.total) == 0) {
                                        percentage = 0;
                                        $($tr).append($('<td>').css({"width": "50px"}).text('-').css("background-color", "#f2f2f2"), $('<td>').css({"width": "50px"}).text('-').css("background-color", "#f2f2f2"));
                                    } else {
                                        percentage = parseInt(value.attend) * 100 / parseInt(value.total);
                                        var setColor = 'transparent';
                                        if (percentage < 75) {
                                            setColor = '#ffcccc';
                                        }
                                        $($tr).append($('<td>').css({"width": "50px"}).text(value.attend).css("background-color", setColor), $('<td>').css({"width": "50px"}).text(value.total));
                                    }

                                }
                            });
                        });
                    } else {
                        //create table header, percentage view

                        $("#attendance-table > thead").append($('<tr>'));
                        $("#attendance-table > thead tr:first-child").append($('<th>').css({"width": "140px"}).text('enrolment'), $('<th>').css({"width": "395px"}).text('name'));
                        $.each(jsonData[0], function (i, row) {
                            if (i != 'name' && i != 'enrolment') {
                                $("#attendance-table > thead tr:first-child").append($('<th>').css({"width": "85px"}).text(i));
                            }
                        });

                        //create table body, percentage view
                        $.each(jsonData, function (i, row) {
                            $("#attendance-table > tbody:last-child").append($('<tr>'));
                            var $tr = $("#attendance-table > tbody tr:last-child");
                            $.each(jsonData[i], function (j, value) {
                                if (j == 'name') {
                                    $($tr).append($('<td>').css({"width": "300px"}).text(value));
                                } else if (j == 'enrolment') {
                                    $($tr).append($('<td>').css({"width": "50px"}).html('<input type="checkbox"/>' + value));
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
                                    $($tr).append($('<td>').css({"width": "65px"}).text(percentage).css("background-color", setColor));
                                }
                            });
                        });
                    }
                }

                //script: modal section-----------------------------------------

                //script:button open update attendance modal
                $("#openmodal").click(function () {
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
        <div style=" margin-left: 5px; margin-top:5px; " >
            <?php
            include '../Connection.php';
            $conn = new Connection();
            $db = $conn->createConnection();
            $sgetSemester = "Select DISTINCT student_semester from student";
            $rgetSemester = $db->query($sgetSemester);
            if ($rgetSemester->num_rows > 0) {
                ?>

                <select style="width:190px; height:27px;" name="semester" id="semester">
                    <option >Select Semester</option>
                    <?php
                    while ($row = $rgetSemester->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $row['student_semester'] ?>"><?php echo $row['student_semester'] ?></option>
                        <?php
                    }
                    ?>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;
                <?php
            }
            ?>
                <button style="width:32px; height:33px" id="div" class="btn btn-primary" >A</button>&nbsp;


        </div>
        <div style=" margin-left: 5px;  margin-top: 3px; margin-bottom:3px; ">
            <input style="width:190px; height:27px; " id="search" type="text" placeholder="Search in table..." disabled="true">
            <input style="width:190px; height:27px; margin-left:20px;" type="text" id="dateFrom" disabled="true" placeholder="for date"> -from to-
            <input style="width:190px; height:27px;" type="text" id="dateTo" disabled="true" placeholder="last date">&nbsp;&nbsp;&nbsp;&nbsp;
            <button  style=" margin-left:250px;"  id="view" value="normal" class="btn btn-primary" style="width:40px; margin-left:5px;">a|t</button>&nbsp;
            <button id="print" class="btn btn-success" ><span class="glyphicon glyphicon-magnet" aria-hidden="true"></span>&nbsp Export</button>&nbsp;
            <button id="openmodal" class="btn btn-primary" >update attendance</button>
        </div>
        <hr/>


        <div id="attendance-view" class="container table-wrapper">

            <table  id="attendance-table" class="record_table table-bordered"  style=" width:98.5%">        
                <thead>
                </thead>
            </table>
            <div class="table-scroll">
                <table  id="attendance-table" class="record_table">  
                    <tbody id="body">
                    </tbody> 
                </table>
            </div>
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
                    <div class="mymodal-container d-flex justify-content-center" id="mdivPrt" style="justify-content: center;">
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
