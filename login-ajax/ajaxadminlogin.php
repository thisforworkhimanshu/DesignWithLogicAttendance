<?php
    session_start();
    $name = $_POST['uname1'];
    $pass = $_POST['pass1'];
    
    require_once '../Connection.php';
    $connection = new Connection();
    $conn = $connection->createConnection("college");
    
    $sql = "select * from admin where admin_uname = '".$name."' and admin_pass = '".$pass."'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['aid'] = $row['admin_id'];
        $_SESSION['a_fname'] = $row['admin_fname'];
        $_SESSION['a_uname'] = $_POST['uname1'];
        $_SESSION['a_dept_id'] = $row['admin_dept_id'];
        echo "ok";
    }else{
        echo "Please Verify Deails";
    }