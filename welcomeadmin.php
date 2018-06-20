<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if(isset($_SESSION['aid'])){
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="bootstrap-4.1.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css"/>
        <!-- jQuery library -->
        <script src="node_modules/jquery/dist/jquery.min.js"></script>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
         

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        
    </head>
    <body>
        <div class="container">
            <div>
                <nav class="navbar navbar-expand-sm bg-light">
                    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
                        <a class="navbar-brand" href="index.php">Management</a>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                    Faculty
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="admin/facultyRegistration/faculty-register.php">Faculty Registration</a>
                                    <a class="dropdown-item" href="admin/subject-faculty-allocation/subject-faculty-allocation.php">Faculty Subject Allocation</a>
                                    <a class="dropdown-item" href="admin/faculty-update/faculty-update.php">Faculty Detail Updation</a>
                                    <a class="dropdown-item" href="admin/faculty-view/faculty-view.php">List Faculty</a>
                                 </div>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                    Student
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="admin/student-registration/student-registration.php">Student Registration</a>
                                    <a class="dropdown-item" href="admin/detain-student-registration/register-into-detain.php">Detain Student</a>
                                    <a class="dropdown-item" href="admin/student-division-allocation/student-division-allocation.php">Division Allocation</a>
                                    <a class="dropdown-item" href="admin/student-prac-batch-allocation/student-prac-batch-allocation.php">Practical Batch Allocation</a>
                                    <a class="dropdown-item" href="admin/admin-view-student/admin-view-student.php">View Students</a>
                                </div>
                            </li>
                        </ul>
                        
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                    Marks
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="admin/admin-marks-view/admin-marks-view.php">View Student Marks</a>
                                    <a class="dropdown-item" href="admin/admin-marks-view/admin-view-grade.php">Student Grade History</a>
                                    <a class="dropdown-item" href="admin/admin-change-marks/get-Student-Details.php">Change Student Marks</a>
                                    <a class="dropdown-item" href="admin/admin-change-marks-different/get-Change-Detail.php">Marks Change Multiple Sem wise</a>
                                 </div>
                            </li>
                        </ul>
                    </div>
                    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                    Attendance
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="">Check Attendance</a>
                                    <a class="dropdown-item" href="">Change Attendance</a>
                                    <a class="dropdown-item" href="">Generate Detention List</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                    Misclleneous
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="admin/move-batch-next-sem/getBatchDetails.php">Move Batch to Next Sem</a>
                                    <a class="dropdown-item" href="admin/subject-register/getSubjectDetail.php">Add Subject</a>
                                </div>
                            </li>
                            <li class="nav-item"><a class="nav-link"  href="sessionDestroy.php">Logout</a></li>
                        </ul>
                    </div>
                
            </nav>
            </div>
                
            </div> <!--End of Container-->
    </body>
</html>
<?php
} else {
    header("Location: index.php");
}