<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if(!isset($_SESSION['fid'])){
    header("Location: ../../facultyLogin.php");
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
        <!-- jQuery library -->
        <script src="../../node_modules/jquery/dist/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
         
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <?php
                require_once '../../master-layout/faculty/master-faculty-layout.php';
            ?>
            <div style="margin-top: 2%;">
                <form class="form" method="get" action="faculty-view-marks.php">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <select name="semester" id="semester" class="form-control" required>
                                <option>--Select Semester</option>
                        <?php
                            require_once '../../Connection.php';
                            $connection = new Connection();
                            $conn = $connection->createConnection("college");
                            if(!$conn){
                                die('Connection To Database Failed');
                            }else{
                                $fid = $_SESSION['fid'];
                                $dept_id = $_SESSION['f_dept_id'];
                                $sqldistinct = "SELECT DISTINCT(semester) as sem FROM subject_faculty_allocation WHERE faculty_id = $fid ORDER BY semester ASC";
                                $resultdistinct = mysqli_query($conn, $sqldistinct);
                                while($row = mysqli_fetch_object($resultdistinct)){
                                    ?>
                    <option value="<?php echo $row->sem?>"><?php echo $row->sem;?></option>
                                    <?php
                                }
                            }
                        ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <select id="subject" name="subject" class="form-control">
                                <option>--Select Subject--</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <select id="lectype" name="lectype" class="form-control">
                                <option>--Select Lecture/Practical--</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-3">
                        <div>
                            <select id="divtype" name="divtype" class="form-control">
                                <option>--Select Type</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div>
                            <input type="submit" id="btnSubmit" class="btn btn-primary"/>
                        </div>
                    </div>
                </div>

                    <script>
                        $(document).ready(function(){
                            $("#semester").change(function(){
                                var semester = $(this).val();
                                if(this.selectedIndex===0){

                                }else{
                                    $.ajax({
                                      type: 'POST',
                                      url: "process-subject-ajax.php",
                                      data: {semester:semester},
                                      success: function(response){
                                          $("#subject").prop("disabled",false);
                                          $("#subject").html(response);
                                      }
                                   });
                                }
                            });

                            $("#subject").change(function(){

                                var subject = $(this).val();

                                if(this.selectedIndex===0){

                                }else{
                                    $.ajax({
                                      type: 'POST',
                                      url: "process-lectype-ajax.php",
                                      data: {subject:subject},
                                      success: function(response){
                                          $("#lectype").html(response);
                                      }
                                   });
                                }
                            });

                            $("#lectype").change(function(){
                                var subject = $("#subject").val();
                                var lectype = $("#lectype").val();
                                if(this.selectedIndex===0){

                                }else{
                                    $.ajax({
                                      type: 'POST',
                                      url: "process-type-ajax.php",
                                      data: {subject:subject,lectype:lectype},
                                      success: function(response){
                                          $("#divtype").html(response);
                                      }
                                   });
                                }
                            });

                        });
                    </script>
                </form>
            </div>
            <?php
                if(isset($_GET['semester'])&&isset($_GET['subject'])&&isset($_GET['lectype'])&&isset($_GET['divtype'])){
                    $semester = $_GET['semester'];
                    $sub_code = $_GET['subject'];
                    $lectype = $_GET['lectype'];
                    $divtype = $_GET['divtype'];
                    
                    ?>
            <div class="markShow">
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <div class="table-responsive-lg" style="margin-top: 2%;">
                            <table class="table-lg table-bordered table-hover text-center">
                                <tr>
                                    <td colspan="4" class="text-center"><h4>Shantilal Shah Engineering College</h4></td>
                                </tr>
                                <tr>

                                    <?php
                                        $sqlsubject = "SELECT short_name from subject where subject_code =$sub_code";
                                        $result = mysqli_query($conn, $sqlsubject);
                                        $rowsub = mysqli_fetch_assoc($result);
                                        $name = $rowsub['short_name'];
                                    ?>
                                    <td><b>Subject Name </b>: <?php echo $name ?></td>
                                    <td><b>Subject Code</b> : <?php echo $sub_code?></td>
                                    <td><b>Semester</b> : <?php echo $semester ?></td>
                                    <td><b>Division </b>: <?php echo $divtype?></td>    
                                </tr>

                                <?php
                                if($lectype==="theory"){
                                    ?>
                                <tr>
                                    <th>Enrolment</th>
                                    <th>Name</th>
                                    <th>Mid Marks</th>
                                    <th>Remedial Mid Marks</th>
                                </tr>   
                                        <?php
                                    $sqlgetStud = "SELECT student_enrolment,student_name FROM student WHERE student_division = '".$divtype."' ";
                                    $resultStud = mysqli_query($conn, $sqlgetStud);
                                    if(mysqli_num_rows($resultStud)>0){
                                        comehere:
                                        while($row= mysqli_fetch_assoc($resultStud)){

                                            $enrol = $row['student_enrolment'];
                                            $name = $row['student_name'];

                                            $sqlcheckdet = "SELECT enrolment from detain_stud where enrolment = $enrol";
                                            $resultdet = mysqli_query($conn, $sqlcheckdet);
                                            if(mysqli_num_rows($resultdet)>0){
                                                goto comehere;
                                            }else{
                                            $sqlmark = "SELECT ".$sub_code."_m as mid FROM sem".$semester."_".$dept_id." WHERE enrolment = $enrol";
                                            $resultmark = mysqli_query($conn, $sqlmark);
                                            $rowmark = mysqli_fetch_assoc($resultmark);
                                            ?>
                                        <tr>
                                            <td><?php echo $enrol;?></td>
                                            <td><?php echo $name?></td>
                                            <?php

                                                $markmid = $rowmark['mid'];
                                                if($markmid>=12){

                                                ?>
                                            <td><?php echo $markmid ?></td>
                                            <td>-N.A.-</td>
                                                <?php
                                                }else{
                                                    $sqlmark = "SELECT ".$sub_code."_r as mid FROM sem".$semester."_".$dept_id."_r WHERE enrolment = $enrol";
                                                    $resultmark = mysqli_query($conn, $sqlmark);
                                                    $rowmark = mysqli_fetch_assoc($resultmark);
                                                    $markre = $rowmark['mid'];
                                                    ?>
                                                    <td><?php echo $markmid?></td>
                                                    <td><?php echo $markre?></td>
                                                    <?php
                                                }
                                           ?>
                                        </tr>
                                        <?php
                                            }
                                        }
                                    }
                                }else if($lectype==="practical"){
                                        ?>
                                <tr>
                                    <th>Enrolment</th>
                                    <th colspan="2">Name</th>
                                    <th>Internal Viva</th>
                                </tr>   
                                    <?php
                                    $sqlgetStud = "SELECT student_enrolment,student_name FROM student WHERE student_division = '".$divtype."' ";
                                    $resultStud = mysqli_query($conn, $sqlgetStud);
                                    if(mysqli_num_rows($resultStud)>0){
                                        while($row= mysqli_fetch_assoc($resultStud)){

                                            $enrol = $row['student_enrolment'];
                                            $name = $row['student_name'];

                                            $sqlmark = "SELECT ".$sub_code."_v as iv FROM sem".$semester."_".$dept_id." WHERE enrolment = $enrol";
                                            $resultmark = mysqli_query($conn, $sqlmark);
                                            $rowmark = mysqli_fetch_assoc($resultmark);
                                            ?>
                                <tr>
                                    <td><?php echo $enrol;?></td>
                                    <td colspan="2"><?php echo $name?></td>
                                    <?php
                                        $internal = $rowmark['iv'];
                                    ?>
                                    <td><?php echo $internal ?></td>
                                </tr>
                                    <?php
                                        }
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>                
            </div>                        
                        <?php
                }
            ?>
        </div>
    </body>
</html>
