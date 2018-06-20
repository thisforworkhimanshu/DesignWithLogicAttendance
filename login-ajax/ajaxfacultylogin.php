<?php
    session_start();
    $name = $_POST['uname1'];
    $pass = $_POST['pass1'];
    
    require_once '../Connection.php';
    $connection = new Connection();
    $conn = $connection->createConnection("college");
    
    $sql = "select * from faculty where faculty_uname = '".$name."' and faculty_pass = '".$pass."'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['fid'] = $row['faculty_id'];
        $_SESSION['f_name'] = $row['faculty_fname'];
        $_SESSION['f_dept_id'] = $row['dept_id'];
        echo "ok";
    }else{
        echo "Please Verify Deails";
    }