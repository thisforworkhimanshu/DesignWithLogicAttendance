<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
error_reporting(E_ALL ^ E_WARNING); 
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
                require_once '../../master-layout/admin/master-page-admin.php';
            ?>
            <div class="badge-light" style="margin-top: 1%;">
                <div class="text-center">
                    <h4>Student Grade History</h4>
                </div>
            </div>
            
            <div style="margin-top: 2%;">
                <form action="admin-view-grade.php" method="post">
                    <div class="row form-group">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" placeholder="Enrolment Number" name="enrol" required autofocus/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-5"></div>
                        <div class="col-lg-2">
                            <input type="submit" class="form-control btn btn-success" name="submit_btn" required/>
                        </div>
                    </div>
                </form>
            </div>
            <div id="showMarks">
                <?php
                    if(isset($_POST['enrol'])&& $_POST['enrol']!=""){
                        require_once '../../Connection.php';
                        $connection = new Connection();
                        $conn = $connection->createConnection("college");
                        
                        $dept_id = $_SESSION['a_dept_id'];
                        
                        $enrol =  $_POST['enrol'];
                        $sql = "select * from student where student_enrolment = $enrol";
                        $resultStud = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($resultStud)>0){
                            $rowStud = mysqli_fetch_assoc($resultStud);
                            ?>
                <div class="table-responsive-sm">
                    <table class="table table-hover table-light">
                        <tr>
                            <th>Name: <?php echo $rowStud['student_name']?></th>
                            <th style="text-align: center;">Enrolment:<?php echo $rowStud['student_enrolment'] ?></th>
                            <th style="text-align: right;">Department Id:<?php  echo $rowStud['student_dept_id']?></th>
                        </tr>
                        <tr>
                            <th>Mobile Number: <?php echo $rowStud['student_cellno']?></th>
                            <th></th>
                            <th style="text-align: right;">Email: <?php echo $rowStud['student_email']?></th>
                        </tr>
                    </table>
                    
                    <?php
                        for($i=1;$i<=8;$i++){
                            $sqlGetSubject = "select * from subject where semester = $i and dept_id = $dept_id";
                            $resultSubject = mysqli_query($conn, $sqlGetSubject);
                            if(mysqli_num_rows($resultSubject)>0){
                                ?>
                    <table class="table table-sm table-hover">
                        <tr>
                            <td colspan="5"><b>Semester : </b><?php echo $i;?></td>
                            
                        </tr>
                        <tr>
                            <th style="width: 10%;">Subject Code</th>
                            <th style="width: 40%;">Subject Name</th>
                            <th style="text-align: center;">Mid Marks</th>
                            <th style="text-align: center;">Remedial Marks</th>
                            <th style="text-align: center;">Internal Viva</th>
                        </tr>
                                <?php
                                while($rowSubject = mysqli_fetch_assoc($resultSubject)){
                                    $sub_code = $rowSubject['subject_code'];
                                    $sub_name = $rowSubject['subject_name'];
                                    ?>
                        <tr>
                            <td style="width: 10%;"><?php echo $sub_code?></td>
                            <td style="width: 40%;"><?php echo $sub_name?></td>
                            <?php
                                $sqlMarks = "select ".$sub_code."_m as mid from sem".$i."_16 where enrolment = $enrol";
                                $sqlvivaMark = "select ".$sub_code."_v as viva from sem".$i."_16 where enrolment = $enrol";
                                $resultMarks = mysqli_query($conn, $sqlMarks);
                                $resultviva = mysqli_query($conn, $sqlvivaMark);
                                if(mysqli_num_rows($resultMarks)>0 || mysqli_num_rows($resultviva)>0){
                                    
                                    $rowMark = mysqli_fetch_assoc($resultMarks);
                                    $rowViva = mysqli_fetch_assoc($resultviva);
                                    $midmark = $rowMark['mid'];
                                    $vivamark = $rowViva['viva'];
                                    ?>
                            <td style="text-align: center;">
                                <?php
                                if($midmark!=""){
                                    if($midmark<12){
                                        echo "FF";
                                    }else{
                                        if($midmark==12){
                                            echo "DD";
                                        }else if($midmark>=13&&$midmark<=15){
                                            echo "CD";
                                        }
                                        else if($midmark>=16&&$midmark<=18){
                                            echo "CD";
                                        }else if($midmark>=13&&$midmark<=15){
                                            echo "CC";
                                        }else if($midmark>=19&&$midmark<=21){
                                            echo "BC";
                                        }else if($midmark>=22&&$midmark<=24){
                                            echo "BB";
                                        }else if($midmark>=25&&$midmark<=27){
                                            echo "AB";
                                        }else if($midmark>=28&&$midmark<=30){
                                            echo "AA";
                                        }
                                    }
                                }else{
                                    echo '--';
                                }
                                ?>
                            </td>
                            <?php
                                if($rowMark['mid']<12){
                                    $sqlMarksr = "select ".$sub_code."_r as remid from sem".$i."_16_r where enrolment = $enrol";
                                    $resultMarksr = mysqli_query($conn, $sqlMarksr);
                                    if(mysqli_num_rows($resultMarksr)>0){
                                        $rowMarkr = mysqli_fetch_assoc($resultMarksr);
                                        $midmarkr = $rowMarkr['remid'];
                                    ?>
                                        <td style="text-align: center;">
                                        <?php 
                                        if($midmarkr!=""){
                                            if($midmark<12){
                                                if($midmarkr<12 && $midmarkr!=""){
                                                    echo "FF";
                                                }else{
                                                    if($midmarkr==12){
                                                        echo "DD";
                                                    }else if($midmarkr>=13&&$midmarkr<=15){
                                                        echo "CD";
                                                    }
                                                    else if($midmarkr>=16&&$midmarkr<=18){
                                                        echo "CD";
                                                    }else if($midmarkr>=13&&$midmarkr<=15){
                                                        echo "CC";
                                                    }else if($midmarkr>=19&&$midmarkr<=21){
                                                        echo "BC";
                                                    }else if($midmarkr>=22&&$midmarkr<=24){
                                                        echo "BB";
                                                    }else if($midmarkr>=25&&$midmarkr<=27){
                                                        echo "AB";
                                                    }else if($midmarkr>=28&&$midmarkr<=30){
                                                        echo "AA";
                                                    }
                                                }
                                            }else{
                                                echo "--";
                                            }
                                        }else{
                                            echo '--';
                                        }
                                        ?>
                                        </td>
                                                    <?php
                                    }else{
                                        ?>
                                        <td style="text-align: center;">--</td>
                                        <?php
                                    }
                                }else{
                                    ?>
                                    <td style="text-align: center;">--</td>
                                    <?php
                                }
                            ?>
                            <td style="text-align: center;">
                            <?php
                                if($vivamark!=""){
                                    if($vivamark<12&&$vivamark!=""){
                                        echo "FF";
                                    }else{
                                        if($vivamark==12){
                                            echo "DD";
                                        }else if($vivamark>=13 && $vivamark<=15)
                                        {
                                                echo "CD";
                                        }
                                        else if($vivamark>=16 && $vivamark<=18)
                                        {
                                                echo "CC";
                                        }
                                        else if($vivamark>=19 && $vivamark<=21)
                                        {
                                                echo "BC";
                                        }
                                        else if($vivamark>=22 && $vivamark<=24)
                                        {
                                                echo "BB";
                                        }
                                        else if($vivamark>=25 && $vivamark<=27)
                                        {
                                                echo "AB";
                                        }
                                        else if($vivamark>=28 && $vivamark<=30)
                                        {
                                                echo "AA";
                                        }
                                    }
                                }else{
                                    echo '--';
                                }                                
                            ?>
                            </td>          
                                        <?php
                                }else{
                                    ?>
                            <td style="text-align: center;">--</td>
                            <td style="text-align: center;">--</td>
                            <td style="text-align: center;">--</td>
                                        <?php
                                }
                            ?>
                        </tr>
                                        <?php
                                }
                                ?>
                    </table>
                                    <?php
                            }else{
                                continue;
                            }
                        }
                    ?>
                </div>                
                        <?php
                        }else{
                            ?>
                <div>
                    No Record Found
                </div>
                                <?php
                        }
                    }
                ?>
            </div>
        </div>
    </body>
</html>
