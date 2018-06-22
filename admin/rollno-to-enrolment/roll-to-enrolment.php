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
                require_once '../../master-layout/admin/master-page-admin.php';
            ?>
            
            <div class="row" style="margin-top: 2%;">
                <div class="col-sm-12 text-center" style="color: red;">
                    <b>*Note</b><i> Upload CSV File Only! These Maps Roll Number to Enrolment, So be Careful while Uploading Data and Check twice or thrice. Once done cannot be undone.</i>
                </div>
            </div>
            <hr/>
            <div style="margin-top: 2%;" class="row">
                <div class="col-lg-12">
                    <b style="color: red;">You can afford only first row for your use*</b>
                    <b style="margin-left: 3%; color: red;">Data Should be in given format only*</b>
                </div>
            </div>
            <div class="table-responsive" style="margin-top: 2%;">
                <table class="table-lg table-striped table-bordered">
                    <tr>
                        <td>Roll No</td>
                        <td>Enrolment</td>
                        <td>Name</td>
                        <td>Semester</td>
                        <td>Department Id</td>
                        <td>Admission Year</td>
                        <td>Batch Year</td>
                        <td>Email Id</td>
                        <td>Mobile Number</td>
                    </tr>
                </table>
            </div>
            
            <div class="form-group" style="margin-top: 2%;">
                <form action="change-to-enrol.php" method="post" name="change_to_enrol" enctype="multipart/form-data">
                    <label style="color: #ff6666;">*Please Choose CSV File Only</label>
                    <div class="row">
                        <div class="col-lg-4">
                            <input type="file" class="form-control-file" id="file" name='file'/>
                        </div>
                        <div class="col-lg-2" style="margin-top: 2%;">
                            <input type="submit" class="form-control btn btn-primary" name="btnSumit" value="Submit" id="btnSubmit"/>
                        </div>
                    </div>
                </form>
            </div>
            
            <?php
                if(isset($_GET['status'])){
                    if($_GET['status']==="success"){
                        ?>
            <div class="text-center alert alert-success" style="margin-top: 2%;">Successfully Changed</div>
                            <?php
                    }else if($_GET['status']==="notvalid"){
                        ?>
            <div class="text-center alert alert-danger" style="margin-top: 2%;">Not Valid Type File</div>
                            <?php
                    }else{
                        ?>
            <div class="text-center alert alert-danger" style="margin-top: 2%;">Operation Failed</div>
                            <?php
                    }
                }
            ?>
        </div>
    </body>
</html>
