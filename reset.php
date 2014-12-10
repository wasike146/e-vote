<?php
$pass = "1234";
		$con = mysqli_connect("localhost","root","1234","wordpress");
		
			$sql="UPDATE wp_users
			SET user_pass = md5($pass)";
			if (!mysqli_query($con,$sql)) {
			  die('Error: ' . mysqli_error($con));
			 }
			 echo "done";
			
?>