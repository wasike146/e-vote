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
		if(file_exists("sql.php")){
			require 'sql.php';
		} else {
			die("Error");
		}
		session_start();
		$message = "";
		$username = "";
		$usernameErr = "";
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
			function test_input($data) {
			   $data = trim($data);
			   $data = stripslashes($data);
			   $data = htmlspecialchars($data);
			   return $data;
			}
			
			function generateUpper($length = 1) {
				$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$randomUpper = '';
				for ($i = 0; $i < $length; $i++) {
					$randomUpper .= $characters[rand(0, strlen($characters) - 1)];
				}
				return $randomUpper;
			}
			
			function generateLower($length = 1) {
				$characters = 'abcdefghijklmnopqrstuvwxyz';
				$randomLower = '';
				for ($i = 0; $i < $length; $i++) {
					$randomLower .= $characters[rand(0, strlen($characters) - 1)];
				}
				return $randomLower;
			}
			
			function generateNumber($length = 1) {
				$characters = '0123456789';
				$randomNumber = '';
				for ($i = 0; $i < $length; $i++) {
					$randomNumber .= $characters[rand(0, strlen($characters) - 1)];
				}
				return $randomNumber;
			}
			
			function generateChar($length = 1) {
				$characters = '?!@#$%^*()';
				$randomChar = '';
				for ($i = 0; $i < $length; $i++) {
					$randomChar .= $characters[rand(0, strlen($characters) - 1)];
				}
				return $randomChar;
			}
			
			
			function generateRandomCode() {
				$randomString = '';
					$randomString .= generateUpper();
					$randomString .= generateChar();
					$randomString .= generateNumber();
					$randomString .= generateLower();
					$randomString .= generateNumber();
					$randomString .= generateNumber();
					$randomString .= generateLower();
					$randomString .= generateUpper();
				return $randomString;
			}
			
			if (empty($_POST["username"])) {
			 $usernameErr = "username harus diisi";
		   } else {
			 $username = test_input($_POST["username"]);
		   }
		
			$con = mysqli_connect("$host","$user","$passdb","$db");
			
			if (mysqli_connect_errno()){
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
			  }
			
			$result = mysqli_query($con,"SELECT * FROM user WHERE username = '$username'");
			//$row  = mysql_fetch_array($result);
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			if(is_array($row)) {
				//generate random code
				
				$randomcode = generateRandomCode();
				
				//kirim ke email
				//masih belum bisa
				
				$result2 = mysqli_query($con,"SELECT * FROM reqpass WHERE username = '$username'");
				$row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
				if(is_array($row2)) {
					$sql="UPDATE reqpass SET randomcode = '$randomcode',request = NOW(),expire = ADDDATE(NOW(), INTERVAL 1 DAY) WHERE username='$username'";
					if (!mysqli_query($con,$sql)) {
					  die('Error: ' . mysqli_error($con));
					}					
				} else {
					$sql="INSERT INTO reqpass(randomcode,username,request,expire) VALUES('$randomcode','$username',NOW(),ADDDATE(NOW(), INTERVAL 1 DAY))";
					if (!mysqli_query($con,$sql)) {
					  die('Error: ' . mysqli_error($con));
					}
				}
				echo "Permintaan reset password berhasil. Silahkan cek email Anda";
				$to = "$username";
				$subject = "Reset Password";
				$link = "http://pemilu.arc.itb.ac.id/polling/change_pass.php?forgetpass=".$randomcode;
				$txt = "Untuk melakukan registrasi. Klik $link";
				$headers = "From: pemilu@arc.itb.ac.id" . "\r\n" .
				"CC: somebodyelse@example.com";

				mail($to,$subject,$txt,$headers);

			} else {

				echo "Username tidak ditemukan";
			}
			
			
			
		}
	?>
	<div class="resetpass-form">
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<table>
		<tr><td width="80">E-mail:</td><td><input width="250" type="text" required placeholder="Username" name="username" value="">
		<?php echo $message; ?></td></tr>
		</table>
		<input type="submit" name="submit" value="Submit">
	</form>
	</div>
	<a href="log-in.php">Back to login</a>
</body>

</html>