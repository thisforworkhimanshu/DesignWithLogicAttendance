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
                require_once '../../master-layout/admin/master-page-admin.php';
            ?>
            <div class="badge-light" style="margin-top: 1%;">
                <div class="text-center"><h5>Detain Student List</h5></div>
            </div>
            <div class="row" style="margin-top: 2%;">
                <div class="col-lg-12 text-center">
                    Get List Of Detain Student by Admission Year
                </div>
            </div>
            <form id="form-detain" method="post">
                <div class="row" style="margin-top: 1%;">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4">
                        <input type="text" name="admyr" id="admyr" class="form-control" placeholder="Admission Year"/>
                    </div>
                </div>
            </form>
            <script>
                $(document).ready(function(){
                   $("#admyr").blur(function(){
                      $("#form-detain").submit();
                   });
                });
            </script>
            
            <?php
                if(isset($_POST['admyr'])){
                    $adm_yr = $_POST['admyr'];
                    $dept_id = $_SESSION['a_dept_id'];
                    
                    require_once '../../Connection.php';
                    $connection = new Connection();
                    $conn = $connection->createConnection("college");
                    
                    $sqldet = "SELECT student.student_enrolment as enrol ,student.student_name as name ,student.student_semester as sem FROM student INNER JOIN detain_stud ON student.student_enrolment = detain_stud.enrolment WHERE student.student_adm_yr = $adm_yr and student.student_dept_id = $dept_id";
                    $resultdet = mysqli_query($conn, $sqldet);
                    ?>
            <div class="table-responsive" style="margin-top: 3%;">
                <table class="table table-striped">
                    <tr>
                        <th>Enrolment</th>
                        <th>Name</th>
                        <th>Last Semester</th>
                    </tr>
                            <?php
                        if(mysqli_num_rows($resultdet)){
                            while($row = mysqli_fetch_assoc($resultdet)){
                                $enrol = $row['enrol'];
                                $sem = $row['sem'];
                                $name = $row['name'];
                                ?>
                    <tr>
                        <td><?php echo $enrol?></td>
                        <td><?php echo $name?></td>
                        <td><?php echo $sem?></td>
                    </tr>
                                    <?php
                            }
                        }else{
                            echo mysqli_error($conn);
                        }
                    }
                ?>
                </table>
            </div>
        </div>
    </body>
</html>