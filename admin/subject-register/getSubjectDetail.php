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
        <title>Subject Registration</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../../bootstrap-4.1.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/style.css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> <!-- cdn google icons -->
        <script src="../../node_modules/jquery/dist/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script>
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
        </script>
        
        <style>
            input[name=subject_code]::-webkit-inner-spin-button, 
                input[name=subject_code]::-webkit-outer-spin-button { 
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    appearance: none;
                    margin: 0; 
                }
        </style>
    </head>
    <body>
        <?php
            if(isset($_GET['subject_code'])){
                $subject_code = $_GET['subject_code'];
                $sub_name = $_GET['subject_name'];
                $short_name = $_GET['short_name'];
                $sem = $_GET['subject_sem'];
                $dept_id = $_SESSION['a_dept_id'];
                
                $theory_hour = $_GET['theory_hour'];
                $practical_hour = $_GET['practical_hour'];
                
                $conn = mysqli_connect("localhost", "root", "", "college");
                
                if(!$conn){
                    die("Connection Failed.. Try After While.");
                }else{
                    $status = false;
                    mysqli_autocommit($conn, FALSE);
                    $query = "INSERT INTO subject values($subject_code,'".$sub_name."','".$short_name."',$sem,$dept_id);";
                    if(mysqli_query($conn, $query)){
                        $sqlteaching = "INSERT INTO teaching_scheme value(0,$subject_code,$theory_hour,$practical_hour,$sem,$dept_id)";
                        if(mysqli_query($conn, $sqlteaching)){
                            
                            $sqlins = "INSERT INTO track_theory_hour(subject_code,total_theory,type) VALUE ($subject_code,$theory_hour,'A')";
                            $sqlins1 = "INSERT INTO track_theory_hour(subject_code,total_theory,type) VALUE ($subject_code,$theory_hour,'B')";
                            $sqlprac = "INSERT INTO track_practical_hour(subject_code,total_practical,type) VALUE($subject_code,$practical_hour,'B1')";
                            $sqlprac1 = "INSERT INTO track_practical_hour(subject_code,total_practical,type) VALUE($subject_code,$practical_hour,'B2')";
                            $sqlprac2 = "INSERT INTO track_practical_hour(subject_code,total_practical,type) VALUE($subject_code,$practical_hour,'B3')";
                            $sqlpra3 = "INSERT INTO track_practical_hour(subject_code,total_practical,type) VALUE($subject_code,$practical_hour,'B4')";
                            $sqlpra4 = "INSERT INTO track_practical_hour(subject_code,total_practical,type) VALUE($subject_code,$practical_hour,'B5')";
                            $sqlprac5 = "INSERT INTO track_practical_hour(subject_code,total_practical,type) VALUE($subject_code,$practical_hour,'B6')";
                            
                            if(mysqli_query($conn, $sqlins)&& mysqli_query($conn, $sqlins1)){
                                
                                if(mysqli_query($conn, $sqlprac)&&
                                        mysqli_query($conn, $sqlprac1)&&
                                        mysqli_query($conn, $sqlprac2)&&
                                        mysqli_query($conn, $sqlpra3)&&
                                        mysqli_query($conn, $sqlpra4)&&
                                        mysqli_query($conn, $sqlprac5)){
                                    
                                        if($theory_hour==0){
                                            $sqlalter = "ALTER TABLE sem".$sem."_".$dept_id." ADD COLUMN ".$subject_code."_v int(10)";
                                            if(mysqli_query($conn, $sqlalter)){
                                                $status=true;
                                            }
                                        }else{
                                            $sqlalter = "ALTER TABLE sem".$sem."_".$dept_id." ADD COLUMN ".$subject_code."_m int(10), ADD COLUMN ".$subject_code."_v int(10)";
                                            $sqlalterr = "ALTER TABLE sem".$sem."_".$dept_id."_r ADD COLUMN ".$subject_code."_r int(10)";
                                            if(mysqli_query($conn, $sqlalter)&& mysqli_query($conn, $sqlalterr)){
                                                $status=true;
                                            }
                                        }
                                }else{
                                    $status=false;
                                    echo mysqli_error($conn);
                                }
                            }else{
                                $status=false;
                                echo mysqli_error($conn);
                            }
                        }else{
                            $status=false;
                            echo mysqli_error($conn);
                        }
                    }else{
                        $status=false;
                        echo mysqli_error($conn);
                    }  
                }
                
                if($status){
                    mysqli_commit($conn);
                    header("Location: getSubjectDetail.php?status=success");
                    ?>
<!--                        <script>
                            setTimeout(function() {
                                window.history.forward();
                                window.history.forward();
                                window.location.href="getSubjectDetail.php?status=success";
                            },0);
                        </script>-->
                    <?php
                }else{
                    mysqli_rollback($conn);
                    echo mysqli_error($conn);
                }
            }else{
                ?>
            <div class="container">
                <?php
                    require_once '../../master-layout/admin/master-page-admin.php';
                ?>
                <div class="badge-light" style="margin-top: 2%;">
                    <div class="text-center">
                        <h5>Subject Entry Into Department</h5>
                    </div>
                </div>   
                <div>
                        <?php
                        if(isset($_GET['status'])){
                            if($_GET['status']=="success"){
                            ?>
                        <div id="msg" class="alert alert-success text-center">Successfully Added</div>
                            <?php        
                            }
                        }
                    ?>
                </div>
                
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <div class="form-group" style="margin-top: 3%;">
                            <form action="getSubjectDetail.php" method="get">
                                <input type="hidden" id="dept_id" value="<?php echo $_SESSION['a_dept_id']?>"/>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th>Subject Code</th>
                                            <td><input type="number" min="0" name="subject_code" id="subject_code" class="form-control" required></td>
                                        </tr>
                                        <script>
                                            $(document).ready(function(){
                                               $("#subject_code").focus();
                                               $("#subject_name").prop("disabled",true);
                                               $("#subject_sem").prop("disabled",true);
                                               $("#short_name").prop("disabled",true);
                                               $("#theory_hour").prop("disabled",true);
                                               $("#practical_hour").prop("disabled",true);
                                               $("#btnSubmit").prop("disabled",true);
                                               $("#btnReset").prop("disabled",true);
                                               
                                               $("#subject_code").keyup(function(){
                                                  var subject_code = $(this).val();
                                                  if(subject_code===""){
                                                      alert('Please Input Subject Code');
                                                      $("#subject_name").prop("disabled",true);
                                                  }else{
                                                      $("#subject_name").prop("disabled",false);
                                                  }
                                               });
                                               $("#subject_name").keyup(function(){
                                                  var subject_name = $(this).val();
                                                  if(subject_name===""){
                                                      $("#short_name").prop("disabled",true);
                                                  }else{
                                                      $("#short_name").prop("disabled",false);
                                                  }
                                               });
                                               
                                               $("#subject_name").blur(function(){
                                                  var subject_name = $(this).val();
                                                  if(subject_name===""){
                                                      alert('Please Input Subject Name');
                                                      $("#short_name").prop("disabled",true);
                                                  }
                                               });
                                               
                                               $("#short_name").keyup(function(){
                                                  var short_name = $(this).val();
                                                  if(short_name===""){
                                                      $("#subject_sem").prop("disabled",true);
                                                  }else{
                                                      $("#subject_sem").prop("disabled",false);
                                                  }
                                               });
                                               
                                               $("#short_name").blur(function(){
                                                  var short_name = $(this).val();
                                                  if(short_name===""){
                                                      alert('Please Input Subject Short Name');
                                                      $("#subject_sem").prop("disabled",true);
                                                  }
                                               });
                                               
                                               $("#subject_sem").keyup(function(){
                                                  var subject_sem = $(this).val();
                                                  if(subject_sem===""){
                                                      $("#theory_hour").prop("disabled",true);
                                                  }else{
                                                      $("#theory_hour").prop("disabled",false);
                                                  }
                                               });
                                               
                                               $("#subject_sem").blur(function(){
                                                  var subject_sem = $(this).val();
                                                  if(subject_sem===""){
                                                      alert('Please Input Subject Semester');
                                                      $("#theory_hour").prop("disabled",true);
                                                  }
                                               });
                                               
                                               $("#theory_hour").keyup(function(){
                                                  var theory_hour = $(this).val();
                                                  if(theory_hour===""){
                                                      $("#practical_hour").prop("disabled",true);
                                                  }else{
                                                      $("#practical_hour").prop("disabled",false);
                                                  }
                                               });
                                               
                                               $("#theory_hour").blur(function(){
                                                  var theory_hour = $(this).val();
                                                  if(theory_hour===""){
                                                      alert('Please Input Theory Hours');
                                                      $("#practical_hour").prop("disabled",true);
                                                  }
                                               });
                                               
                                               $("#practical_hour").keyup(function(){
                                                  var practical_hour = $(this).val();
                                                  if(practical_hour===""){
                                                      $("#btnSubmit").prop("disabled",true);
                                                      $("#btnReset").prop("disabled",true);
                                                  }else{
                                                      $("#btnSubmit").prop("disabled",false);
                                                      $("#btnReset").prop("disabled",false);
                                                  }
                                               });
                                               
                                               $("#practical_hour").blur(function(){
                                                  var practical_hour = $(this).val();
                                                  if(practical_hour===""){
                                                      alert('Please Input Practical Hours');
                                                      $("#btnSubmit").prop("disabled",true);
                                                      $("#btnReset").prop("disabled",true);
                                                  }
                                               });
                                               
                                            });
                                        </script>
                                        <tr>
                                            <th>Subject Name</th>
                                            <td><input type="text" name="subject_name" id="subject_name" class="form-control" required></td>
                                        </tr>
                                        <tr>
                                            <th>Subject Short Name</th>
                                            <td><input type="text" name="short_name" id="short_name" class="form-control" required></td>
                                        </tr>
                                        <tr>
                                            <th>Subject Semester</th>
                                            <td><input type="number" min="1" max="8" name="subject_sem" id="subject_sem" class="form-control" required></td>
                                        </tr>
                                        
                                        <script>
                                            $(document).ready(function(){
                                               $("#subject_sem").blur(function(){
                                                    var sem = $(this).val();
                                                    if(sem>=9 || sem<=0){
                                                        alert('Semester Should be in between 1 to 8');
                                                        $("#theory_hour").prop("disabled",true);
                                                    }else{
                                                        $("#theory_hour").prop("disabled",false);
                                                    }
                                                  
                                               });
                                            });
                                        </script>
                                        <tr>
                                            <th>No of Theory Hours</th>
                                            <td><input type="number" min="0" name="theory_hour" id="theory_hour" class="form-control" required></td>
                                        </tr>
                                        <tr>
                                            <th>No of Practical Hours</th>
                                            <td><input type="number" min="0" name="practical_hour" id="practical_hour" class="form-control" required></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><input type="submit" id="btnSubmit" class="btn btn-primary" value="Submit"></td>
                                            <td><input type="reset" id="btnReset" class="btn btn-primary" value="Reset"></td>
                                        </tr>
                                    </table>
                                </div>
                            </form>
                        </div>    
                    </div>
                </div>
            </div>
                    <?php
            }
        ?>
    </body>
</html>