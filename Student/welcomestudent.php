<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and opens the template in the editor.
-->
<?php
session_start();
if(!isset($_SESSION['enrolment'])){
    header("Location: studentindex.php");
}
$enrolment = $_SESSION['enrolment'];
$semester = $_SESSION['s_sem'];
$dept_id = $_SESSION['s_dept_id'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="../css/circle.css">
        <link rel="stylesheet" type="text/css" href="../bootstrap-4.1.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>
            .percentbar { background:#CCCCCC; border:1px solid #666666; height:15px; }
            .percentbar div { background: green; height: 15px; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="bg-light text-center">
                <hr style="margin-top: 0%;"/>
                <div>
                    <h3>Shantilal Shah Engineering College</h3>
                    <label>New Sidsar Campus, Bhavnagar - 364001</label>
                </div>
                <hr/>
            </div>
            <nav class="navbar navbar-expand-md bg-light navbar-light">
                <a class="navbar-brand" href="welcomestudent.php">Student</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                  <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="student-view-mark/student-view-mark.php" style="color: #000000;">View Marks</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="" style="color: #000000;">View Attendance</a>
                    </li>
                  </ul>
                </div>  
            </nav>
            
            <script>
                $(document).ready(function(){
                   $("#markShow").hide();
                   $("#attShow").hide();
                   var valbtn = $("#toggle").val();
                   if(valbtn==="Marks"){
                        $("#attShow").hide();
                        $("#markShow").show();
                        $("#toggle").prop("value","Attendance");
                   }else{
                       $("#markShow").hide();
                       $("#attShow").show();
                       $("#toggle").prop("value","Marks");
                       
                   }
                   
                   $("#toggle").click(function(){
                      if($(this).val()==="Marks") {
                            $("#attShow").hide();
                            $("#markShow").show();
                            $("#toggle").prop("value","Attendance");
                      }else{
                            $("#markShow").hide();
                            $("#attShow").show();
                            $("#toggle").prop("value","Marks");
                      }
                   });
                });
            </script>
            
            <div class="float-right">
                <input type="button" value="Attendance" id="toggle" class="btn btn-primary btn-outline-dark"/>
            </div>
            
            <div id="dashboard" style="margin-top: 3%;">
                <div id="markShow">
                    <div class="text-center"><h4>Marks</h4></div>
                    <div class="row">
                    <?php
                        require_once '../Connection.php';
                        $connectionn = new Connection();
                        $conn = $connectionn->createConnection("college");

                        //Try Query 
                        //SELECT subject.subject_code,subject.subject_name,teaching_scheme.total_theory FROM subject INNER JOIN teaching_scheme ON teaching_scheme.subject_code=subject.subject_code WHERE subject.semester=7 and subject.dept_id=16 and teaching_scheme.total_theory >0

                        if($semester>0&&$semester<9){
                            $sqlGetSubject = "select short_name,subject_code from subject where semester = $semester and dept_id = $dept_id";
                            $resultSubject = mysqli_query($conn, $sqlGetSubject);
                            if(mysqli_num_rows($resultSubject)>0){
                                while($rowSubject= mysqli_fetch_assoc($resultSubject)){
                                    $sub_code = $rowSubject['subject_code'];
                                    $sql = "select total_theory from teaching_scheme where subject_code = $sub_code";
                                    $resultTeach = mysqli_query($conn, $sql);
                                    if(mysqli_num_rows($resultTeach)>0){
                                        $rowteach = mysqli_fetch_assoc($resultTeach);
                                        $teachhour = $rowteach['total_theory'];
                                    }

                                    if($teachhour>1){
                                        $sqlMark = "select ".$sub_code."_m as mid from sem".$semester."_".$dept_id." where enrolment = $enrolment";
                                        $resultMark = mysqli_query($conn, $sqlMark);

                                        if(mysqli_num_rows($resultMark)>0){
                                                $rowMark = mysqli_fetch_assoc($resultMark);
                                                $markobtain = $rowMark['mid'];
                                                if(!is_numeric($markobtain)){

                                                }else{
                                                    $percent = floor(($markobtain/30)*100);
                                                    if($percent<50){
                                                        ?>
                                                    <div class="col-lg-4">
                                                        <label><?php echo $rowSubject['short_name']?></label>
                                                        <br/>
                                                        <div class="c100 p<?php echo $percent?> red" style="margin-left: 40%;">
                                                            <span><?php echo $percent?>%</span>
                                                            <div class="slice">
                                                                <div class="bar"></div>
                                                                <div class="fill"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    }else{
                                                        ?>
                                                    <div class="col-lg-4">
                                                        <label><?php echo $rowSubject['short_name']?></label>
                                                        <br/>
                                                        <div class="c100 p<?php echo $percent?> green" style="margin-left: 40%;">
                                                            <span><?php echo $percent?>%</span>
                                                            <div class="slice">
                                                                <div class="bar"></div>
                                                                <div class="fill"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }

                                            }
                                        }else{

                                        }
                                    }
                                }
                            }
                        }
                    ?>
                    </div>
                </div>
                
                <div id="attShow">
                    <div class="text-center"><h4>Attendance</h4></div>
                    <div class="row">
                    <?php
                        require_once '../Connection.php';
                        $connectionn = new Connection();
                        $conn = $connectionn->createConnection("college");
                        
                        $type1 = "theory";
                        $type2 = "practical";
                        
                        $sqlstud = "select * from student where student_enrolment = ".$enrolment;
			$resultstud = mysqli_query($conn,$sqlstud);
			if(mysqli_num_rows($resultstud)>0)
			{
                            $row = mysqli_fetch_assoc($resultstud);
                            $sem = $row['student_semester'];


                            $sqlSubject = "select * from subject where semester = $sem";
                            $resultSubject = mysqli_query($conn, $sqlSubject);
                            $no_of_subject = mysqli_num_rows($resultSubject);

                            if(mysqli_num_rows($resultSubject)>0)
                            {
                    ?>
                            <table align="center" class="table-sm table-hover">
                                <tr>					
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Theory(%)</th>
                                    <th>Practical(%)</th>
                                </tr>
                            <?php
                                while($rowSubject = mysqli_fetch_assoc($resultSubject))
                                {
                                    $subname = $rowSubject['subject_name'];
                                    $subcode = $rowSubject['subject_code'];

                                    $sqlCountTotalThoery = "SELECT COUNT(DISTINCT lecture_id) as t FROM lecture_tb_".$dept_id." WHERE subject_code = $subcode and type = '".$type1."'";
                                    $resultSqlTotalThoery = mysqli_query($conn, $sqlCountTotalThoery);
                                    $rowcountThoery = mysqli_fetch_assoc($resultSqlTotalThoery);
                                    $totalsbThoery = $rowcountThoery['t'];
                            ?>
                                    <tr>
                                        <td align="center"><?php echo $subcode;?></td>
                                        <td><?php echo $subname;?></td>
                                    <?php
                                        $sqlAttGetThoery = "SELECT * "
                                            . "FROM attendance_of_".$dept_id." INNER JOIN lecture_tb_".$dept_id." ON attendance_of_".$dept_id.".lecture_id = lecture_tb_".$dept_id.".lecture_id where subject_code = $subcode and type = 'theory' and enrolment = $enrolment and is_present=1";
                                        $resultAttGetThoery = mysqli_query($conn, $sqlAttGetThoery);
                                        $totalAttendentThoery = mysqli_num_rows($resultAttGetThoery);
                                        if($totalsbThoery!=0)
                                        {
                                            $percent_Thoery = ($totalAttendentThoery/$totalsbThoery)*100;			
                                        }
                                        else
                                        {
                                            $percent_Thoery = 0;
                                        }
                                        ?>
                                        <?php	
                                            $value = $percent_Thoery;
                                            $max = 100;
                                            $scale = 1.5;
                                            // Get Percentage out of 100
                                            if ( !empty($max) ) { $percent = ($value * 100) / $max; } 
                                            else { $percent = 0; }
                                            // Limit to 100 percent (if more than the max is allowed)
                                            if ( $percent > 100 ) { $percent = 100; }
                                                if($percent<70){
                                            ?>
                                            <td>														
                                                <div class="percentbar" style="width:<?php echo round(100 * $scale);  ?>px;">
                                                    <div style="width:<?php echo round($percent * $scale);?>px;background: red;"></div>
                                                </div>
                                                    Percentage: <?php echo $percent; ?>
                                            </td>

                                            <?php
                                            }
                                            else{
                                            ?>
                                            <td>														
                                                <div class="percentbar" style="width:<?php echo round(100 * $scale); ?>px;">
                                                    <div style="width:<?php echo round($percent * $scale); ?>px;"></div>
                                                </div>
                                                Percentage: <?php echo $percent; ?>
                                            </td>
                                            <?php

                                            }
                                            ?>
                                    <?php

                                    //practical
                                    $sqlCountTotalPractical = "SELECT COUNT(DISTINCT lecture_id) as p FROM lecture_tb_".$dept_id." WHERE subject_code = $subcode and type = '".$type2."'";
                                    $resultSqlTotalPractical = mysqli_query($conn, $sqlCountTotalPractical);
                                    $rowcountPractical = mysqli_fetch_assoc($resultSqlTotalPractical);
                                    $totalsbPractical = $rowcountPractical['p'];

                                    $sqlAttGetPractical = "SELECT * "
                                            . "FROM attendance_of_".$dept_id." INNER JOIN lecture_tb_".$dept_id." ON attendance_of_".$dept_id.".lecture_id = lecture_tb_".$dept_id.".lecture_id where subject_code = $subcode and type = 'practical' and enrolment = $enrolment and is_present=1";
                                    $resultAttGetPractical = mysqli_query($conn, $sqlAttGetPractical);
                                    $totalAttendentPractical = mysqli_num_rows($resultAttGetPractical);
                                    if($totalsbPractical!=0)
                                    {
                                            $percent_Practical = ($totalAttendentPractical/$totalsbPractical)*100;
                                    }
                                    else
                                    {
                                                    $percent_Practical = 0;
                                    }
                                    ?>
                                    <?php	
                                    $value = $percent_Practical;
                                    $max = 100;
                                    $scale = 1.5;

                                    // Get Percentage out of 100
                                    if ( !empty($max) ) { $percent = ($value * 100) / $max; } 
                                    else { $percent = 0; }

                                    // Limit to 100 percent (if more than the max is allowed)
                                    if ( $percent > 100 ) { $percent = 100; }

                                    if($percent<70){
                                    ?>
                                    <td>														
                                        <div class="percentbar" style="width:<?php echo round(100 * $scale);  ?>px;">
                                            <div style="width:<?php echo round($percent * $scale);?>px;background: red;"></div>
                                        </div>
                                        Percentage: <?php echo $percent; ?>
                                    </td>
                                    
                                    <?php
                                    }
                                    else{
                                    ?>
                                    <td>														
                                        <div class="percentbar" style="width:<?php echo round(100 * $scale); ?>px;">
                                            <div style="width:<?php echo round($percent * $scale); ?>px;"></div>
                                        </div>
                                        Percentage: <?php echo $percent; ?>
                                    </td>
                                    <?php
                                    }
                                    ?>
                                    </tr>
                                    <?php
                                }
                            ?>
                            </table>
                            <?php
                            }
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
