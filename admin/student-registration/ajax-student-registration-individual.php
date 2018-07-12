 <?php

	if(isset($_POST['enrol'])&&isset($_POST['name'])&&isset($_POST['semester'])&&isset($_POST['dept_id'])&&isset($_POST['adm_yr'])&&isset($_POST['batch_yr'])&&isset($_POST['division'])&&isset($_POST['batch'])&&isset($_POST['email'])&&isset($_POST['cellno'])&&isset($_POST['password']))
	{
		session_start();
		$enrol = $_POST['enrol'];
		$name = $_POST['name'];
		$semester = $_POST['semester'];
		$dept_id = $_POST['dept_id'];
		$adm_yr = $_POST['adm_yr'];
		$batch_yr = $_POST['batch_yr'];
		$division = $_POST['division'];
		$batch = $_POST['batch'];
		$email = $_POST['email'];
		$cellno = $_POST['cellno'];
		$password = $_POST['password'];
			
		require_once 'Connection.php';
		$connection = new Connection();
		$conn = $connection->createConnection("college");
		if(!$conn)
		{ 
			die('Failed');
		}
		else
		{
			$sql = "insert into student (student_enrolment,student_name,student_semester,student_dept_id,student_adm_yr,batch_year,student_division,student_batch,student_email,student_cellno,student_password) values($enrol,'".$name."',$semester,$dept_id,$adm_yr,$batch_yr,'".$division."','".$batch."','".$email."',$cellno,'".$password."')";
                        if(mysqli_query($conn, $sql))
                        {
                            echo "ok";
                        }
                        else {
                            echo "Registration not successfully...";
                        }
		}
	}
	else
	{
	}