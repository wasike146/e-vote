<?php
	session_start();
	if(file_exists("sql.php")){
		require 'sql.php';
	} else {
		die("Error");
	}
	$username = $_SESSION["changepassid"];

	$con = mysqli_connect("$host","$user","$passdb","$db");
			
	if (mysqli_connect_errno()){
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			//Password
			if (empty($_POST["password"])) {
				 $passErr = "Password harus diisi";
			   } else {
				 $pass = htmlspecialchars($_POST["password"]);
				 $pass = md5($pass);
				 $passOK = true;
			   }


			 //check confirm password 
			 if(!(($_POST["password"]) == ($_POST["cpassword"]))){
				$cpassErr = "Password tidak sama"; 
			 } else {
				$cpassOK = true;
			 }
			 
			  if($passOK && $cpassOK){
			  		
					$result = mysqli_query($con,"SELECT * FROM user WHERE username = '$username'");
					$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
					if((is_array($row))) {
						$sql="UPDATE user SET password='$pass' WHERE username='$username'";
						if (!mysqli_query($con,$sql)) {
						  die('Error: ' . mysqli_error($con));  
						}
						$sql="DELETE FROM reqpass WHERE username='$username'";
						if (!mysqli_query($con,$sql)) {
							 die('Error: ' . mysqli_error($con));
						}
						header("Location:login.php");
					} else {
						echo "error";
					}
					
					mysqli_close($con);
				}
			}
?>