<html>
<head><title></title>
<script>
function reload() {
    location.reload();
}
</script>
</head>
<body>
<?php
if(!isset($_SESSION["id"])) {
?>
	<?php
		if(file_exists("sql.php")){
			require 'sql.php';
		} else {
			die("Error");
		}
		session_start();
		$message = "";
		$username = $password = "";
		$usernameErr = $passwordErr = "";
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
			function test_input($data) {
			   $data = trim($data);
			   $data = stripslashes($data);
			   $data = htmlspecialchars($data);
			   return $data;
			}
			
			if (empty($_POST["username"])) {
			 $usernameErr = "username harus diisi";
		   } else {
			 $username = test_input($_POST["username"]);
		   }
		   
		   if (empty($_POST["password"])) {
			 $passwordErr = "password harus diisi";
		   } else {
			 $password = $_POST["password"];
			 $password = md5($password);
		   }
			echo "$password";
			$con = mysqli_connect("$host","$user","$passdb","$db");
			
			if (mysqli_connect_errno()){
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
			  }
  
			//echo $password;
			$result = mysqli_query($con,"SELECT * FROM reqpass WHERE username = '$username'");
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			if(is_array($row)) {
			
				$result = mysqli_query($con,"SELECT * FROM reqpass WHERE username = '$username' and newpass = '$password'");
				//$row  = mysql_fetch_array($result);
				$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
				if(is_array($row)) {
					//cek apakah token masih berlaku
					$expiredate = strtotime($row["expire"]);
					$curdate = strtotime(date("Y-m-d H:i:s"));
					$datediff = $curdate - $expiredate;
					if($datediff<0){
						$sql="UPDATE user
						SET password = '$password' WHERE username = '$username'";
						if (!mysqli_query($con,$sql)) {
						  die('Error: ' . mysqli_error($con));
						}
						
						$sql="DELETE FROM reqpass
						WHERE username = '$username'";
						if (!mysqli_query($con,$sql)) {
						  die('Error: ' . mysqli_error($con));
						}
						
						$result2 = mysqli_query($con,"SELECT * FROM user WHERE username = '$username' and password = '$password'");
						//$row  = mysql_fetch_array($result);
						$row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
						if(is_array($row2)) {
							echo "zzz";
							$_SESSION["id"] = $row2["id"];
							$_SESSION["username"] = $row2["username"];
							$_SESSION["hasVoted"] = $row2["hasVoted"];
							$_SESSION["active"] = $row2["active"];
							//echo $_SESSION["id"];
					} else {
						//sudah tidak berlaku
						echo "Request untuk reset password sudah tidak berlaku. Jika masih ingin mereset password, klik <a href='reset_pass.php'>di sini</a>";
						
					}
					} else {
						echo "Invalid Username or Password!";
					}
			
				} else {
					$message = "Invalid  password!";
				}
				if(isset($_SESSION["id"])) {
					
					header("Location:change_pass.php");
					
				}
			} else {
				echo "Anda tidak mereset";
			}
			
		}
	?>
	<div class="login-form">
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<table>
		<tr><td width="80">Username:</td><td><input width="250" type="text" required placeholder="Username" name="username" value="">
		</td></tr>
		<tr><td>Password:</td><td><input type="password" required placeholder="Password" name="password" value="">
		</td></tr>
		</table>
		<?php echo $message; ?>
		<input type="submit" name="submit" value="Submit"><input type="reset" value="Reset!">
	</form>
	</div>
	<a href="reset_pass.php">Reset password</a>
</body>
<?php } else {
	echo "Anda sudah login";
}?>
</html>