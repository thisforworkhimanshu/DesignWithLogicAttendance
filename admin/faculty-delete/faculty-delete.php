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
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">-->
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
            <?php
            require_once '../../Connection.php';
            $connection = new Connection();
            $conn = $connection->createConnection("college");

            $dept_id = $_SESSION['a_dept_id'];
            $sql = "select faculty_id,faculty_fname from faculty where dept_id = $dept_id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                ?>
                <form action="faculty-delete.php" method="post">
                    <div class="row form-group" style="margin-top: 2%;">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <select name="faculty" class="form-control">
                                <option value="" disabled selected>--Select Faculty --</option>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <option value="<?php echo $row['faculty_id'] ?>"><?php echo $row['faculty_fname'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-4"></div>
                        <div class="col-4">
                            <input type="submit" class="form-control btn btn-danger" name="btnSubmit" id="btnSubmit"/>
                        </div>
                    </div>
                </form>
                <?php
            }

            if (isset($_POST['faculty']) && $_POST['faculty'] != "") {
                $sql = "delete from faculty where faculty_id=" . $_POST['faculty'];
                if (mysqli_query($conn, $sql)) {
                    ?>
                    <div class="alert alert-success">Record Delete Sucessfully...Redirecting</div>
                    <script>
                        setTimeout(function () {
                            window.location.href = 'faculty-delete.php';
                        }, 1000);
                    </script>
        <?php
    }
}
?>
        </div>
    </body>
</html>


