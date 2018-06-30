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
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4">
                        <div class="form-group" style="margin-top: 3%;">
                            <form action="getSubjectDetail.php" method="get">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th>Subject Code</th>
                                            <td><input type="text" name="subject_code" class="form-control" required></td>
                                        </tr>
                                        <tr>
                                            <th>Subject Name</th>
                                            <td><input type="text" name="subject_name" class="form-control" required></td>
                                        </tr>
                                        <tr>
                                            <th>Subject Short Name</th>
                                            <td><input type="text" name="short_name" class="form-control" required></td>
                                        </tr>
                                        <tr>
                                            <th>Subject Semester</th>
                                            <td><input type="text" name="subject_sem" class="form-control" required></td>
                                        </tr>
                                        <tr>
                                            <th>No of Theory Hours</th>
                                            <td><input type="text" name="theory_hour" class="form-control" required></td>
                                        </tr>
                                        <tr>
                                            <th>No of Practical Hours</th>
                                            <td><input type="text" name="practical_hour" class="form-control" required></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><input type="submit" class="btn btn-primary" style="margin-left: 44%;" value="Submit"></td>
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