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
        <title>Update Faculty Details</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../../bootstrap-4.1.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/style.css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> <!-- cdn google icons -->
        <script src="../../jquery/jquery-3.3.1.js"></script> <!-- jquery js -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
         <script>
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
            });
        </script>
    </head>
    <body>
        <div class="container">
            <?php
                require_once '../../master-layout/admin/master-page-admin.php';
                require_once '../../Connection.php';
                $connection = new Connection();
                $conn = $connection->Connect("college");
                $dept_id = $_SESSION['a_dept_id'];
            ?>
            <div class="badge-light" style="margin-top: 0.5%;">
                <div class="text-center">
                    <h5>Faculty Detail Updation</h5>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <div class="faculty-sem" style="margin-top: 1.5%;">
                    <form id="fac-sem">
                        <div class="form-group">
                                    <select name="faculty" id="faculty" autofocus class="form-control">
                                        <option selected value="">--Select Faculty--</option>
                                        <?php
                                            $faculty = $conn->get("faculty");
                                            if($conn->count>0){
                                                foreach ($faculty as $fac) {
                                                    ?>
                                        <option value="<?php echo $fac['faculty_id'] ?>"><?php echo $fac['faculty_fname'];?></option>
                                                        <?php
                                                }
                                            }
                                        ?>
                                    </select>
                        </div>
                    </form>
                </div>

                <div style="margin-top: 1.5%;">
                    <div>
                        <form id="fac-update">
                            <script>
                                $(document).ready(function() {
                                    $(window).scrollTop(63);
                                    $("#faculty").change(function(){
                                        var id = $(this).val();
                                        $.ajax({
                                           type: 'POST' ,
                                           url: "ajax-return-faculty-data.php",
                                           data: {facultyid : id},
                                           success: function (data) {
    //                                           console.log(data);
                                               var JSONObject = jQuery.parseJSON(data);
                                               for(var i=0;i<JSONObject.length;i++){
                                                   var json = JSONObject[i];
                                               }
                                               var faculty_fname = json.faculty_fname;
                                               var faculty_uname  = json.faculty_uname;
                                               var faculty_pass = json.faculty_pass;
    //                                           var dept_id = json.dept_id;
                                               var faculty_email = json.faculty_email;
                                               var faculty_cellno = json.faculty_cellno;
                                               var faculty_gender = json.faculty_gender;

                                               $("#faculty_fname").val(faculty_fname);
                                               $("#faculty_uname").val(faculty_uname);
                                               $("#faculty_pass").val(faculty_pass);
                                               $("#faculty_email").val(faculty_email);
                                               $("#faculty_cellno").val(faculty_cellno);
                                               if(faculty_gender==="Male"){
                                                   $("#maleradio").prop("checked",true);
                                               }else{
                                                   $("#femaleradio").prop("checked",true);
                                               }
                                               $("#btnSubmit").removeAttr("disabled");
                                           }
                                        });
                                    });

                                    $("#btnSubmit").click(function(){
                                       $("#btnSubmit").hide();
                                       $("#btnSave").show();
                                       $("#btnCancle").show();
                                       $("#faculty").prop("disabled",true);
                                       $("#faculty_fname").prop("disabled",false);
                                       $("#faculty_uname").prop("disabled",false);
                                       $("#faculty_pass").prop("disabled",false);
                                       $("#faculty_email").prop("disabled",false);
                                       $("#faculty_cellno").prop("disabled",false);
                                       $("#maleradio").prop("disabled",false);
                                       $("#femaleradio").prop("disabled",false);
                                       return false;
                                    });

                                    $("#btnSave").click(function(){
                                        var fname = $("#faculty_fname").val();
                                        var uname = $("#faculty_uname").val();
                                        var pass = $("#faculty_pass").val();
                                        var email = $("#faculty_email").val();
                                        var cellno = $("#faculty_cellno").val();
                                        var gender = $("input:radio[name='gender']:checked").val();
                                        if(fname==""||uname==""||pass==""||email==""||cellno==""){
                                            $("#error").fadeIn(1000,function() {
                                                $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> Please Fill All Details !</div>');
                                            });
                                        }else if(cellno.length>10||cellno.length<10){
                                            $("#error").fadeIn(1000,function() {
                                                $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> Mobile Number Consist of 10 Digit Only</div>');
                                            });
                                            $("#error").fadeOut(3000);
                                        }else{

                                            var fid = $("#faculty").val();
                                            $.ajax({
                                               type: 'POST' ,
                                               url: "ajax-faculty-update.php",
                                               data: {fid:fid,fname:fname,uname:uname,pass:pass,email:email,cellno:cellno,gender:gender},
                                               beforeSend: function (xhr) {
                                                    $("#error").fadeIn(1000,function() {
                                                            $("#error").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-info-sign"></span>Processing your request...</div>');
                                                    });
                                               },
                                               success: function (data) {
                                                   if(data==="ok"){
                                                        $("#error").fadeIn(1000,function() {
                                                            $("#error").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-info-sign"></span>Successfully Updated! We are Rediredting you</div>');
                                                            $("#error").focus();
                                                            $(window).scrollTop(200);
                                                            setTimeout(function() {
                                                                window.location.href="faculty-update.php";
                                                            },3000);
                                                            $("#btnSave").hide();
                                                            $("#btnCancle").hide();
                                                        });
                                                   }else{
                                                        $("#error").fadeIn(1000,function() {
                                                            $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span>Updation Failed</div>');
                                                        });
                                                   }
                                                }
                                            });
                                        }

                                       return false;
                                    });

                                    $("#btnCancle").click(function() {
                                        window.location.href="faculty-update.php";
                                    });
                                });
                            </script>

                            <div class="form-group">
                                <label class="control-label">Full Name</label>
                                <input type="text" id="faculty_fname" disabled name="faculty_fname" class="form-control" required/>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Username</label>
                                <input type="text" id="faculty_uname" disabled name="faculty_uname" class="form-control" required/>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Password</label>
                                <input type="password" id="faculty_pass" disabled name="faculty_pass" class="form-control" required/>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <input type="email" id="faculty_email" disabled name="faculty_email" class="form-control" required/>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Mobile Number</label>
                                <input type="text" id="faculty_cellno" disabled name="faculty_email" class="form-control" required/>
                            </div>

                            <div class="form-group">
                                <div>
                                    <label class="control-label">Gender:</label>
                                </div>
                                <div class="form-check-inline">
                                    <input type="radio" id="maleradio" disabled name="gender" value="Male" class="form-check" required/>Male
                                </div>
                                <div class="form-check-inline">
                                    <input type="radio" id="femaleradio" disabled name="gender" value="Female" class="form-check" required/>Female
                                </div>
                            </div>
                            <div id="error"></div>
                            <div class="form-group">
                                    <div style="margin-left: 36%;">
                                        <button type="submit" id="btnSubmit" class="btn btn-light btn-outline-primary" disabled>Edit</button>
                                    </div>
                            </div>

                            <div class="form-group">
                                    <div style="margin-left: 30%;">
                                        <button type="submit" id="btnSave" class="btn btn-light btn-outline-primary" style="display: none;">Update</button>
                                        <button type="button" id="btnCancle" class="btn btn-light btn-outline-primary" style="display: none;">Cancle</button>
                                    </div>
                            </div>
                        </form> <!-- END OF FORM TAG -->
                    </div>            
                </div>
                </div>
            </div>
        </div>       
    </body>
</html>