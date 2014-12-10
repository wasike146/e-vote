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
 		<p> You are here : Home > [Log-In] > <strong> VOTE! </strong>	
 		</p>
 		<div class="voting">
 		<!-- SCRIPT UNTUK MELAKUKAN VOTING -->
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


<?php
session_start();
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
			<br>
			<p> Silakan memilih sesuai hati nurani Anda : </p>
			<div class="vote-form">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<table>
			<tr>
			<label><center><input type="radio" name="kandidat" value="1">WAHYU Muqsita</option></label></center> <center><img src="img/calon1.svg"></center><br><br> <br>
			<label><center><input type="radio" name="kandidat" value="2">SYAIFUL Andy </option></label> <center><img src="img/calon2.svg"></center>
			
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

	echo "Silakan <a href='log-in.php'>Login</a> terlebih dahulu ! ";
}
?>
<!-- SCRIPT VOTING SELESAI -->

	
	</div>

</div>
</body>
