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
        <link rel="stylesheet" href="../../css/style.css">
        <script src="../../node_modules/jquery/dist/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <?php require_once '../../master-layout/admin/master-page-admin.php'; ?>
            
            <div class="badge-light" style="margin-top: 1%;">
                <div class="text-center">
                    <h5>Past Subject Allocation</h5>
                </div>
            </div>
            <form action="subjectAllocationHistory.php" method="post">
                <div class="row" style="margin-top: 2%;">
                    <div class="col-lg-3 form-group">
                        <input type="text" placeholder="Batch Year" id="batchyear" name="batchyear" class="form-control"/>
                    </div>
                    <div class="col-lg-4 form-group">
                        <select id="semester" name="semester" class="form-control">
                            <option value="null">--Select Semester--</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                    </div>
                    
                    <div class="col-lg-2 form-group">
                        <input type="submit" id="btnSubmit" name="btnSubmit" value="See" class="btn btn-primary"/>
                    </div>
                </div>
            </form>
            
            <?php
            
            if(isset($_POST['batchyear'])&&$_POST['semester']){
                require_once '../../Connection.php';
                $connection = new Connection();
                $conn = $connection->createConnection("college");
                $dept_id = $_SESSION['a_dept_id'];
                $sem = $_POST['semester'];
                $batch_year = $_POST['batchyear'];
                
                if($sem==1||$sem==2){
                    $sql = "SELECT * FROM faculty where dept_id  in ($dept_id,1)";
                } else {
                    $sql = "SELECT * FROM faculty where dept_id  = $dept_id";
                }
                
                $result = mysqli_query($conn, $sql);
                
                if(mysqli_num_rows($result)>0){
                    while($rowFac = mysqli_fetch_assoc($result)){
                        $fac_id = $rowFac['faculty_id'];
                        $fac_name = $rowFac['faculty_fname'];
                        
                        $sqlSub = "select * from duplicate_subject_faculty_allocation where faculty_id = $fac_id and batch_year = $batch_year and semester = $sem and dept_id = $dept_id";
                        $rsqlSub = mysqli_query($conn,$sqlSub);
                        if(mysqli_num_rows($rsqlSub)>0){
                            ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="3" style="width: 50%;">Faculty Name : <?php echo $fac_name ?></th>
                                    <th colspan="1" style="width: 10%;">Semester : <?php echo $sem?></th>
                                    <th style="width: 15%;">Department Id: <?php echo $dept_id?></th>
                                    <th style="width: 20%;">Category : Past Subject Allocation</th>
                                </tr>
                                <tr>
                                    <th style="width: 12%;">Subject Code</th>
                                    <th>Subject Name</th>
                                    <th style="width: 5%;">Theory/Practical</th>
                                    <th>Division/Batch</th>
                                    <th>Hours Allocated</th>
                                    <th>Approx. Total Theory/Practical in Term</th>
                                </tr>
                                        <?php
                                    while($rowSub = mysqli_fetch_assoc($rsqlSub)){
                                        $sub_code = $rowSub['subject_code'];
                                        $subName = "select subject_name from subject where subject_code = $sub_code and dept_id = $dept_id and semester = $sem";
                                        $rSubject = mysqli_query($conn, $subName);

                                        $rowSubject = mysqli_fetch_assoc($rSubject);
                                        $subject_name = $rowSubject['subject_name'];

                                        ?>
                                <tr>
                                    <td><?php echo $sub_code?></td>
                                    <td><?php echo $subject_name?></td>
                                    <td><?php echo $rowSub['lecture_type']?></td>
                                    <td><?php echo $rowSub['type']?></td>
                                    <td><?php echo $rowSub['total_hours']?></td>
                                    <td><?php echo $rowSub['expected_total_lecture']?></td>
                                </tr>
                                            <?php
                                    }
                                    $status=true;//Flag to decided whether data present or not
                        }else{
                            $status = false;
                        }
                    }
                }
                ?>
                </table>
                            <?php
                            if(!$status){
                                echo 'No Data Present'; //Message to user according to flag value
                            }
                            ?>
            </div>
                    <?php
            }
            
            ?>
        </div>
    </body>
</html>
