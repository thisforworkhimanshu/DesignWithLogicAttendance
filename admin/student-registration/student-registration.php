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
                require '../../master-layout/admin/master-page-admin.php';
            ?>
            <div class="text-center" style="margin-top: 1%;"><h4 style="text-decoration: underline;">Student Registration</h4></div>
            <script>
                $(document).ready(function(){
                    $("#divregular").hide();
                    $("#divdiplomatodegree").hide();
                    $("#msgsuccess").hide();
                    $("#msgfailed").hide();
                    
                    $("#btnRegular").click(function(){
                        $("#divdiplomatodegree").hide();
                        $("#divregular").toggle();
                    });
                    <?php
                        if(isset($_GET['status'])){
                            if($_GET['status']=="success"){
                            ?>
                               $("#msgfailed").hide();
                               $("#msgsuccess").show();
                            <?php
                            }else if ($_GET['status']=="failed") {
                                ?>
                                $("#msgsuccess").hide();
                                $("#msgfailed").show();
                                <?php
                            }
                        }
                    ?>
                    $("#btnDiploma").click(function(){
                        $("#divregular").hide();
                        $("#divdiplomatodegree").toggle();
                    });
                    
                });
            </script>
            <div style="margin-top: 3%;">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4">
                            <button type="button" id="btnRegular" class="btn btn-info form-control">Regular Student</button>
                        </div>
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <button type="button" id="btnDiploma" class="btn btn-info form-control">Diploma to Degree Student</button>
                        </div>
                    </div>
                    <div id="divregular">
                        <form action="upload-student-registration.php" method="post" name="upload_excel" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label>Term Start Date</label>
                                    <input type="date" name="fromDate" min="<?php echo date("Y-m-d")?>" class="form-control"/>
                                </div>
                                <div class="col-lg-3">
                                    <label>Term End Date</label>
                                    <input type="date" name="toDate" min="<?php echo date("Y-m-d")?>" class="form-control"/>
                                </div>
                            </div>
                            <div class=""><label style="color: red; font-size: 14px;">* CSV File only accepted with prescribe format as below, you can afford only first column for your purpose.</label></div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <td>Enrolment &nbsp;</td>
                                        <td>Name &nbsp;</td>
                                        <td>Semester &nbsp;</td>
                                        <td>Department ID &nbsp;</td>
                                        <td>Admission Year &nbsp;</td>
                                        <td>Batch Year &nbsp;</td>
                                        <td>Email &nbsp;</td>
                                        <td>Mobile Number &nbsp;</td>
                                    </tr>
                                </table>
                            </div>
                            <div style="margin-top: 2%;">                            
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="file" name="file" id="fileupload" class="form-control-file btn btn-light" required/>
                                        </div>
                                        <div class="col-lg-1">
                                            <input type="submit" name="submit_file" id="btnSubmit" class=" btn btn-success" value="Upload"/>
                                        </div>
                                    </div>
                            </div>
                        </form>
                    </div>
                    <div id="msgsuccess" style="margin-top: 3%;">
                            <div class="alert alert-success text-center"><?php
                            if(isset($_GET['status'])){
                                if($_GET['status']=="success"){
                                    ?>
                                Successfully Uploaded
                                        <?php
                                }
                            }
                            ?></div>
                    </div>
                    <div id="msgfailed" style="margin-top: 3%;">
                            <div class="alert alert-success text-center"><?php
                            if(isset($_GET['status'])){
                                if($_GET['status']=="failed"){
                                    ?>
                                Upload Failed! Please Check data or else data already Present
                                        <?php
                                }
                            }
                            ?></div>
                    </div>
                    <div id="divdiplomatodegree">
                        <div><label style="color: red; font-size: 14px;">* CSV File only accepted with prescribe format as below, you can afford only first column for your purpose.</label></div>
                        <div><label style="color: red; font-size: 14px;">* <b>Batch Year should be one less than Admission year, For e.g 2016 Admitted Student's batch year is 2015</b>.</label></div>
                        <div class="table-responsive">
                            <table class="table  table-striped">
                                <tr>
                                    <td>Enrolment </td>
                                    <td>Name </td>
                                    <td>Semester </td>
                                    <td>Department ID </td>
                                    <td>Admission Year </td>
                                    <td>Batch Year </td>
                                    <td>Email </td>
                                    <td>Mobile Number </td>
                                </tr>
                            </table>
                        </div>
                        <div style="margin-top: 2%;">
                            <form action="upload-diploma-student-registration.php" method="post" name="upload_excel" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <input type="file" name="file" id="fileupload" class="form-control-file btn btn-light" required/>
                                    </div>
                                    <div class="col-lg-1">
                                        <input type="submit" name="submit_file" id="btnSubmit" class=" btn btn-success" value="Upload"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>