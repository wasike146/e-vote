<?php 
session_start();
?>
<head>
	
</head>

<body>

<link rel="stylesheet" type="text/css" href="side-content.css">

<div class="main-content">

	<div class="sidebar">
		<ul>
				<li> <a href="/index.php" title="Back to home"> <img src="img/home.svg">	</a>	</li>
				<li> <a href="/history.php" title="See the history"> <img src="img/history.svg">	</a>	</li> 
				<li> <a href="/candidates.php" title="Who are the candidates ?"> <img src="img/candidates.svg"> </a>	</li> 
				<li> <a href="/rules.php" title="Read the rules">	<img src="img/rules.svg"> 		</a>	</li> 
				<li> <a href="/sign-up.php" title="Sign yourself here"> <img src="img/sign-up.svg">		</a>	</li> 
				<li> <a href="/log-in.php" title="Get in here"> <img src="img/log-in.svg">	</a>	</li> 
				<li> <a href="/vote.php" title="Vote! here"> <img src="img/vote.svg">	</a>	</li>
				<li> <a href="/about.php" title="About this web"> <img src="img/about.svg"> 		</a>	</li> 
				<?php
 		 		 		if(isset($_SESSION["id"])) {

				echo "<li> <a href='/logout.php' title='Log out'> <img src='img/logout.svg'> 		</a>	</li>";
				}	
				?> 	
			</ul> 
			<br><br>
			<!-- CONTACT PERSON -->
			
			<div class="contact">
				<div1>
				<strong> CONTACT US	</strong>	<br>
			</div1>
			<p>	Sekretariat ARC ITB 			<br>
				Sunken Court W-05				<br>
				E-mail :<a href="mailto:pemilu@arc.itb.ac.id"> pemilu@arc.itb.ac.id 	</a><br>
			</p>
			</div>
	</div>

 	<div class="content">
 		<p> You are here : Home > Login > <strong> Forget Password ? </strong>	
 		</p>
 		<h1>
 			FORGET PASSWORD
 		</h1>
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
			
			
			
			function generateRandomCode() {
				$randomString = '';
					$randomString .= generateUpper();
					$randomString .= generateNumber();
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
		<tr><td width="80">E-mail :</td><td><input width="250" type="text" required placeholder="E-mail @arc.itb.ac.id" name="username" value="">
		<?php echo $message; ?></td></tr>
		</table>
		<input type="submit" name="submit" value="Submit">
	</form>
	Or remember again ? Just back to <a href="log-in.php"> login</a>
	</div>		
	</div>
</div>
</body>
