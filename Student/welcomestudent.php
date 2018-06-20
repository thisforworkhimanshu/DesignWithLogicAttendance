<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if(!isset($_SESSION['enrolment'])){
    header("Location: studentindex.php");
}
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
            <div id="dashboard" style="margin-top: 2%;">
                H
            </div>
        </div>
    </body>
</html>
