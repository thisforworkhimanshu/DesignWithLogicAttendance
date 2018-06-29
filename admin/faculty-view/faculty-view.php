<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if (!isset($_SESSION['aid'])) {
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
        <script src="../../jquery/jquery-3.3.1.js"></script> <!-- jquery js -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
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
            });
        </script>
    </head>
    <body>
        <div class="container">
            <?php
            require_once '../../master-layout/admin/master-page-admin.php';
            ?>
            <div class="badge-light" style="margin-top: 2%;">
                <div class="text-center">
                    <h5>Faculty Details</h5>
                </div>
            </div>
            <?php
            require_once '../../Connection.php';
            $connection = new Connection();
            $conn = $connection->createConnection("college");
            $dept_id = $_SESSION['a_dept_id'];
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive-lg" style="margin-top: 2%;">
                        <table class="table table-striped">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Designation</th>
                                <th>Email</th>
                                <th>Mobile Number</th>
                            </tr>
                            <?php
                            $sql = "select * from faculty where dept_id = $dept_id";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['faculty_id'] ?></td>
                                        <td><?php echo $row['faculty_fname'] ?></td>
                                        <td><?php echo $row['faculty_uname'] ?></td>
                                        <td><?php echo $row['faculty_pass'] ?></td>
                                        <td><?php echo $row['faculty_designation'] ?></td>
                                        <td><?php echo $row['faculty_email'] ?></td>
                                        <td><?php echo $row['faculty_cellno'] ?></td>
                                    </tr>

                                    <?php
                                }
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
