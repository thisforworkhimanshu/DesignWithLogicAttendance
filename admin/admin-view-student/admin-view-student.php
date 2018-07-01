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
        <title>View Students - Batch Year</title>
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
    </head>
    <body>
        <div class="container">
            <?php
                require_once '../../master-layout/admin/master-page-admin.php';
            ?>
            <div class="badge-light" style="margin-top: 1%;">
                <div class="text-center">
                    <h5>Student Details</h5>
                </div>
            </div>
            
            <div id="studentDetailHere">
                <form action="admin-view-student.php" method="get">
                <div class="row" id="hideIt">
                    <div class="col-lg-3 form-group">
                        <input type="text" id="batchyear" placeholder="Batch Year" name="batchyear" class="form-control" required/>                            
                    </div>
                    <div class="col-lg-3 form-group">
                        <input type="submit" name="submit_btn" id="btnSubmit" value="View" class="form-control btn btn-success"/>
                    </div>
                    <div class="col-lg-3 form-group">
                        <input type="text" id="searchBox" class="form-control" placeholder="Search"/>
                    </div>
                    <div class="col-lg-3 text-center form-group">
                        <input type="button" id="print" class="btn btn-outline-dark" value="Print"/>
                    </div>
                </div>
                </form>
                
                <script>
                    $("#print").click(function(){
                       print();
                    });
                </script>
                <script>
                    $(document).ready(function(){
                        $("#searchBox").on("keyup",function(){
                            var value = $(this).val().toUpperCase();
                            $("#myTable tr").filter(function(){
                               $(this).toggle($(this).text().toUpperCase().indexOf(value) > -1);
                            });
                        });
                    });
                </script>
                <?php
                    if(isset($_GET['batchyear'])&&$_GET['batchyear']!=""){
                        
                        $batch_year = $_GET['batchyear'];
                        require_once '../../Connection.php';
                        $connection = new Connection();
                        $conn = $connection->createConnection("college");
                        
                        $dept_id = $_SESSION['a_dept_id'];
                        
                        $sqlbatch = "SELECT year FROM adm_yrs_eq WHERE year = $batch_year and dept_id = $dept_id";
                        $result = mysqli_query($conn, $sqlbatch);
                        if(mysqli_num_rows($result)>0){
                            ?>
                            <div style="margin-top: 2%;" id="printThese">
                                <div class="table-responsive-lg">
                                    <table class="table text-center">
                                        <thead>
                                        <tr>
                                            <th colspan="8">Shantilal Shah Engineering College</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Batch Year : <?php echo $_GET['batchyear'];?></th>
                                            <th colspan="4">Category: Student</th>
                                            <th colspan="2">Branch : 
                                            <?php
                                                $sql = "SELECT dept_name FROM department WHERE dept_id = $dept_id";
                                                $result = mysqli_query($conn, $sql);
                                                $row = mysqli_fetch_object($result);
                                                echo $row->dept_name;
                                            ?>
                                            </th>
                                        </tr>
                                        
                                        <tr>
                                            <th>Enrolment Number</th>
                                            <th>Name</th>
                                            <th>Admission Year</th>
                                            <th>Batch Year</th>
                                            <th>Division</th>
                                            <th>Practical Batch</th>
                                            <th>Email</th>
                                            <th>Mobile Number</th>
                                        </tr>
                                        </thead>
                                        <tbody id="myTable">
                                        <?php
                                            $sqlGetStudent = "SELECT * FROM student WHERE batch_year = $batch_year and student_dept_id = $dept_id";
                                            $resultStud = mysqli_query($conn, $sqlGetStudent);
                                            if(mysqli_num_rows($result)>0){
                                                while($rowStud = mysqli_fetch_assoc($resultStud)){
                                                    ?>
                                        <tr>
                                            <td><?php echo $rowStud['student_enrolment']?></td>
                                            <td><?php echo $rowStud['student_name']?></td>
                                            <td><?php echo $rowStud['student_adm_yr']?></td>
                                            <td><?php echo $rowStud['batch_year']?></td>
                                            <td><?php echo $rowStud['student_division']?></td>
                                            <td><?php echo $rowStud['student_batch']?></td>
                                            <td><?php echo $rowStud['student_email']?></td>
                                            <td><?php echo $rowStud['student_cellno']?></td>
                                        </tr>
                                                        <?php
                                                }
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php
                        }else{
                            ?>
                        <div style="margin-top: 2%;">
                            <div class="alert">
                                No Such Batch Present
                            </div>
                        </div>
                                <?php
                        }
                    }
                ?>
            </div>
        </div>
    </body>
</html>
