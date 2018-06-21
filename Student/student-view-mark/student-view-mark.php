<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if(!isset($_SESSION['enrolment'])){
    header("Location: ../studentindex.php");
}
$dept_id = $_SESSION['s_dept_id'];
$enrolment =  $_SESSION['enrolment'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="../bootstrap-4.1.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="bg-light text-center">
                <hr style="border-color: greenyellow; margin-top: 0%;"/>
                <div>
                    <h3>Shantilal Shah Engineering College</h3>
                    <label>New Sidsar Campus, Bhavnagar - 364001</label>
                </div>
                <hr style="border-color: greenyellow;"/>
            </div>
            <nav class="navbar navbar-expand-md bg-light navbar-light">
                <a class="navbar-brand" href="../welcomestudent.php">Student</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                  <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="student-view-mark.php" style="color: #99a22f; ">View Marks</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="" style="color: #000000;">View Attendance</a>
                    </li>
                  </ul>
                </div>  
            </nav>
            
            <div class="row" style="margin-top: 2%;">
                <div class="col-lg-4"></div>
                <div class="col-lg-4 form-group">
                    <?php
                        require_once '../../Connection.php';
                        $connection = new Connection();
                        $conn = $connection->createConnection("college");
                        
                        $sqlGetSemester = "select student_semester from student where student_enrolment = $enrolment and student_dept_id = $dept_id";
                        $resultGetSemester = mysqli_query($conn, $sqlGetSemester);
                        if(mysqli_num_rows($resultGetSemester)){
                            $rowSem = mysqli_fetch_assoc($resultGetSemester);
                            $semester = $rowSem['student_semester'];
                            $_SESSION['s_sem'] = $semester;
                        }
                    ?>
                    <select id="semester" name="semester" class="form-control">
                        <option value="" disabled selected>--Select Semester--</option>
                        <?php
                            for($i=1;$i<=$semester;$i++){
                                ?>
                        <option value="<?php echo $i?>"><?php echo $i?></option>
                                    <?php
                            }
                        ?>
                    </select>
                </div>
                
                <script>
                    $(document).ready(function(){
                        $("#semester").change(function(){
                            var sem = $(this).val();
                            $.ajax({
                                type: 'POST',
                                url: "ajax-return-mark.php",
                                data: {semester:sem},
                                success: function (data, textStatus, jqXHR) {
                                    $("#showTable").html(data);
                                }
                            });
                        });
                    });
                </script>
            </div>
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div id="showTable"></div>
                </div>
            </div>
            
        </div>
    </body>
</html>