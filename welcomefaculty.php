<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if(isset($_SESSION['fid'])){
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
                        <a class="navbar-brand" href="">Management</a>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                    Task
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="faculty/view-subject/view-subject-lecture.php">Check My Subject Allocation</a>
                                </div>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                    Marks
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="faculty/faculty-marks-entry/faculty-marks-entry.php">Marks Entry</a>
                                    <a class="dropdown-item" href="faculty/faculty-view-mark/faculty-view-marks.php">View Marks</a>
                                    <a class="dropdown-item" href="">Change Marks</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="mx-auto order-0">
                        <label class="navbar-brand mx-auto" href="#"> <?php
                            echo 'Welcome : '.$_SESSION['f_name'];
                        ?></label>
                    </div>
                   
                    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                    Attendance
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="">Fill Attendance</a>
                                    <a class="dropdown-item" href="">View Attendance</a>
                                </div>
                            </li>
                            <li class="nav-item"><a class="nav-link"  href="sessionDestroy.php">Logout</a></li>
                        </ul>
                    </div>
                
            </nav>
            </div>
            <div class="row">
                <div class="col"></div>
                <div class="col">
                </div>
                <div class="col"></div>
            </div>
            <div>
                
            </div>
        </div>
    </body>
</html>
<?php
} else {
    header("Location: index.php");
}