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
            <div class="badge-light" style="margin-top: 0.5%;">
                <div class="text-center">
                    <h5>Marks Entry</h5>
                </div>
            </div>
            <div class="row" style="margin-top: 3%;">
                <div class="col-4"></div>
                <div id="formDetails" class="col-4">
                    <form action="upload-to-database.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <select name="semester" id="semester" class="form-control" required>
                                <option>--Select Semester</option>
                                <?php
                                        require_once '../../Connection.php';
                                        $connection = new Connection();
                                        $conn = $connection->createConnection("college");
                                        if(!$conn){
                                            die('Connection to Database Failed');
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
                        <script>
                            $(document).ready(function(){
                                
                                $("#subject").prop("disabled",true);
                                $("#division").prop("disabled",true);
                                $("#examtype").prop("disabled",true);
                                $("#excel-file").prop("disabled",true);
                                $("#btnSubmit").prop("disabled",true);
                                
                                $("#semester").change(function(){
                                  var semester = $(this).val();
                                  if(this.selectedIndex===0){
                                      $("#subject").prop("disabled",true);
                                      $("#division").prop("disabled",true);
                                      $("#examtype").prop("disabled",true);
                                      $("#excel-file").prop("disabled",true);
                                      $("#btnSubmit").prop("disabled",true);
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
                                      $("#division").prop("disabled",true);
                                      $("#examtype").prop("disabled",true);
                                      $("#excel-file").prop("disabled",true);
                                      $("#btnSubmit").prop("disabled",true);
                                  }else{
                                        $.ajax({
                                       type: 'POST' ,
                                       url: "process-div-ajax.php",
                                       data: {subject:subject},
                                       success: function(response){
                                          $("#division").prop("disabled",false);
                                          $("#division").html(response);
                                       }
                                    });
                                  }
                               });
                               
                               $("#division").change(function(){
                                  if(this.selectedIndex===0) {
                                      $("#examtype").prop("disabled",true);
                                      $("#excel-file").prop("disabled",true);
                                      $("#btnSubmit").prop("disabled",true);
                                  }else{
                                      $("#examtype").prop("disabled",false);
                                  }
                               });
                               
                               $("#examtype").change(function(){
                                  if(this.selectedIndex===0) {
                                      $("#excel-file").prop("disabled",true);
                                      $("#btnSubmit").prop("disabled",true);
                                  }else{
                                      $("#excel-file").prop("disabled",false);
                                      $("#btnSubmit").prop("disabled",false);
                                  }
                               });
                               
                            });
                        </script>
                        <div id="subjectselect" class="form-group">
                            <select id="subject" name="subject" class="form-control" required>
                                <option>--Select Subject--</option>
                            </select>
                        </div>

                        <div id="selectdivision" class="form-group">
                            <select id="division" name="division" class="form-control" required>
                                <option>--Select Division--</option>
                            </select>
                        </div>

                        <div id="selectexamtype" class="form-group">
                            <select name="examtype" id="examtype" class="form-control" required>
                                <option value="">--Select Exam Type</option>
                                <option value="m">Mid Semester Exam</option>
                                <option value="r">Remedial Exam for Mid</option>
                                <option value="v">Internal Viva</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="file" id="excel-file" name="file" class="form-control-file" required/>
                        </div>
                        <div class="row">
                            <div class="col"></div>
                            <div class="col">
                                <input type="submit" name="submit_file" id="btnSubmit" value="submit" class="btn btn-primary"/>
                            </div>
                            <div class="col"></div>
                        </div>
                    </form>
                </div>
            </div>
            
            <script>
                $(document).ready(function(){
                    $("#btnSubmit").prop("disabled",true);
                   <?php
                        if(isset($_GET['status'])){
                            ?>
                            setTimeout(function(){
                                window.location.href="faculty-marks-entry.php";
                            },3000);
                                <?php
                        }
                   ?> 
                });
            </script>
            
            <div class="row" style="margin-top: 3%;">
                <div class="col-4"></div>
                <div class="col-4">
                    <div id="msghere">
                        <?php
                            if(isset($_GET['status'])){
                                if($_GET['status']==="notvalid"){
                                    ?><div class="alert alert-danger">Uploaded File is not of valid type.<div/><?php
                                }else if($_GET['status']==="failed"){
                                    ?><div class="alert alert-danger">Marks Entry Failed<div/><?php
                                }else if($_GET['status']==="success"){
                                    ?><div class="alert alert-danger">Marks Entry Success<div/><?php
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="col-4"></div>
            </div>                        
        </div>
    </body>
</html>
