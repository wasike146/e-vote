<?php
session_start();
?>
<html>
<head>
<title>Tidak ada judul</title>
<script>
function reload() {
    location.reload();
}
function message() {
    alert("Terima kasih sudah ngevote");
}
</script>

</head>
<body>
Vote</br>

<?php
if(file_exists("sql.php")){
	require 'sql.php';
} else {
	die("Error");
}
if(isset($_SESSION["id"])) {
?>



Welcome <?php echo $_SESSION["username"]; ?>. Click here to <a href="logout.php" tite="Logout">Logout</a></br>
<?php
	$con = mysqli_connect("$host","$user","$passdb","$db");

	// Check connection
		if (mysqli_connect_errno()) {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		$id = $_SESSION["id"];
		$result = mysqli_query($con,"SELECT * FROM user WHERE id = $id");
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		if(is_array($row)) {
			$isActive = $row["active"];
		} else {
			echo 'Error';
		}
	if($isActive){
	
		if($_SESSION["hasVoted"] == false){

		$kandidat = "";
		$kandidatErr = "";
		$valid = false;
		
		function test_input($data) {
		   $data = trim($data);
		   $data = stripslashes($data);
		   $data = htmlspecialchars($data);
		   return $data;
		}
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//Nama
		   if (empty($_POST["kandidat"])) {
			 $kandidatErr = "Harus pilih";
		   } else {
			 $kandidat = test_input($_POST["kandidat"]);
			 $valid = true;
		   }
	   }

					
			?>
			
			<div class="vote-form">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<table>
			<tr>
			<input type="radio" name="kandidat" value="1">Orang 1</option>
			<input type="radio" name="kandidat" value="2">Orang 2</option>
			<input type="radio" name="kandidat" value="3">Orang 3</option>
			</tr>
			</table>
			<input type="submit" name="submit" value="Submit">
			</form>
			</div>
			<?php
			
			
			

			if($valid){
				$id = $_SESSION["id"];
				$sql="UPDATE user
				SET hasVoted = true
				WHERE id = $id";
				if (!mysqli_query($con,$sql)) {
				  die('Error: ' . mysqli_error($con));
				}
				
				$result = mysqli_query($con,"SELECT * FROM kandidat WHERE id = $kandidat");
				
				$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
				if(is_array($row)) {
					$count = $row["count"];
					$count++;
				} else {
					echo 'Error';
				}
				
				$sql="UPDATE kandidat
				SET count = count+1 WHERE id = $kandidat";
				if (!mysqli_query($con,$sql)) {
				  die('Error: ' . mysqli_error($con));
				}
				
				//SET SESSION
				$_SESSION["hasVoted"] = true;
				 
				echo '<script type="text/javascript">'
			   , 'message();'
			   , '</script>'
				;
			
				echo '<script type="text/javascript">'
			   , 'reload();'
			   , '</script>'
				;
			}
				
			
		} else {
			echo "Anda sudah vote";
		}
	} else {
		echo "Silakan buka email Anda untuk aktivasi";
	}
?>
<?php
} else {  
	echo "Silahkan <a href='login.php'>Login</a> atau <a href='register.php'>Register</a>";
}
?>

</body>
</html>