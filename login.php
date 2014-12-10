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
session_start();
?>
<?php
if(file_exists("sql.php")){
	require 'sql.php';
} else {
	die("Error");
}
if(!isset($_SESSION["id"])) {
?>
	<?php
		
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
		
			$con = mysqli_connect("$host","$user","$passdb","$db");
			
			if (mysqli_connect_errno()){
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
			  }
  
			//echo $password;
			$result = mysqli_query($con,"SELECT * FROM user WHERE username = '$username' and password = '$password'");
			//$row  = mysql_fetch_array($result);
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			if(is_array($row)) {
				$_SESSION["id"] = $row["id"];
				echo $_SESSION["id"];
				$_SESSION["username"] = $row["username"];
				$_SESSION["hasVoted"] = $row["hasVoted"];
				$_SESSION["active"] = $row["active"];
			} else {
				$message = "Invalid Username or Password!";
			}
			if(isset($_SESSION["id"])) {
				
				header("Location:vote.php");
				
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
	<a href="reset_pass.php">Lupa password?</a>
</body>
<?php } else {
	echo "Anda sudah login";
}?>
</html>