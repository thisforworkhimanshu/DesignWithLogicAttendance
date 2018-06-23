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
                        $("#attendance-table > thead tr:nth-child(2)").append($('<th>').text('enrolment'), $('<th>').text('name'));
                        $.each(jsonData[0], function (i, row) {
                            if (i != 'name' && i != 'enrolment') {
                                $("#attendance-table > thead tr:first-child").append($('<th>').attr("colspan", 2).text(i));
                                $("#attendance-table > thead tr:nth-child(2)").append($('<th>').text('attend'), $('<th>').text('total'));
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
                        $("#attendance-table > thead").append($('<tr>'));
                        $("#attendance-table > thead tr:first-child").append($('<th>').text('enrolment'), $('<th>').text('name'));
                        $.each(jsonData[0], function (i, row) {
                            if (i != 'name' && i != 'enrolment') {
                                $("#attendance-table > thead tr:first-child").append($('<th>').text(i));
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
                }

                //script: modal section-----------------------------------------

                //script:button open change attendance modal
                $("#openmodal").click(function () {
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

                // Multiple date picker script starts from here
                var dates = new Array();

                function addDate(date) {
                    console.log(dates);
                    if ($.inArray(date, dates) < 0)
                        dates.push(date);
                }

                function removeDate(index) {
                    dates.splice(index, 1);
                }

                function printArray() {
                    var printArr = new String;
                    dates.forEach(function (val) {
                        printArr += '<h4>' + val + '</h4>';
                    });
                    $('#print-array').html(printArr);
                }
                
                // Adds a date if we don't have it yet, else remove it
                function addOrRemoveDate(date) {
                    var index = $.inArray(date, dates);
                    if (index >= 0)
                        removeDate(index);
                    else
                        addDate(date);
                    printArray();
                }

                $("#bulckDate").datepicker({
                    onSelect: function (dateText, inst) {
                        addOrRemoveDate(dateText);
                    },
                    beforeShowDay: function (date) {
                        var year = date.getFullYear();
                        // months and days are inserted into the array in the form, e.g "01/01/2009", but here the format is "1/1/2009"
                        var month = date.getMonth() + 1;
                        var day = date.getDate();
                        // This depends on the datepicker's date format
                        var dateString = month + "/" + day + "/" + year;

                        var gotDate = $.inArray(dateString, dates);
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
        <div>
            <?php
            include '../Connection.php';
            $conn = new Connection();
            $db = $conn->createConnection();
            $sgetSemester = "Select DISTINCT student_semester from student";
            $rgetSemester = $db->query($sgetSemester);
            if ($rgetSemester->num_rows > 0) {
                ?>
                <select name="semester" id="semester">
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
            <button id="div">A</button>
            <button id="view" value="normal">a|t</button>
        </div>
        <div>
            <input id="search" type="text" placeholder="Search in table..." disabled="true">
            <input type="text" id="dateFrom" disabled="true"> -from to-
            <input type="text" id="dateTo" disabled="true">
            <button id="print">export to excel!</button>
            <button id="openmodal" class="btn btn-dark">open modal</button>
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

        <!--modal html.....................................................-->
        <div id="modal" class="mymodal">

            <div class="mymodal-content animate">

                <div class="" style="text-align: center">
                    <label style="color: gray">Update Attedance</label>
                </div>
                <div style="text-align: center">
                    <button value="bulk" id="mbtnBulk">change in bulk</button>
                    <button value="single" id="mbtnPrt">single subject</button>
                </div>
                <div class=" mymodal-container border border-primary rounded" style="margin: 1%">
                    enrollments will be shown here
                </div>

                <div class="mymodal-container">
                    <!--       Bulk division-->  
                    <div class="mymodal-container" id="mdivBulk">
                        <label>select dates</label>
                        <br>
                        <div id="bulckDate"></div>
                    </div>

                    <!--        particular division-->
                    <div class="mymodal-container" id="mdivPrt">
                        <label>select date</label>
                        <br>
                        <input id="dateSingle" placeholder="Select Date..">
                        <br>
                        <br>
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
