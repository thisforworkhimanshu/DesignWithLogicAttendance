<?php
$conn = mysqli_connect("localhost", "root", "", "college");

if(!$conn){
    die('Failed');
}

session_start();

$fid = $_SESSION['fid'];

$sub_code = $_POST['subject'];

$sql = "SELECT DISTINCT(lecture_type) as lecture_type FROM subject_faculty_allocation where subject_code = $sub_code and faculty_id =$fid";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result)>0){
    echo "<option value='null'>--Select Lecture/Practical--</option>";
    while($row = mysqli_fetch_assoc($result)){
        $type = $row['lecture_type'];
        if($type==="theory") {
            $typeT = "Theory";
            echo "<option value='".$type."'>".$typeT."</option>";
        }else if($type==="practical"){
            $typeP = "Practical";
            echo "<option value='".$type."'>".$typeP."</option>";
        }
        
    }
}else{
    echo mysqli_error($conn);
}
