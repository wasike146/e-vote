<?php
session_start();
?>
<html>
<head><title></title>
</head>
<body>
<?php
if(file_exists("sql.php")){
	require 'sql.php';
} else {
	die("Error");
}

$pass = $cpass = "";
	$passErr = $cpassErr = "";
	$passOK = $cpassOK = "";
	
function test_input($data) {
	$data = trim($data);	
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function generateRandomString($length = 20) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
   return $randomString;
}

if (empty($_GET["forgetpass"])){
	if(empty($code)){
		$code = "";
	}
} else {
	$code = $_GET["forgetpass"];
}


if(!(isset($_SESSION["id"]))) {

	

	$con = mysqli_connect("$host","$user","$passdb","$db");
			
	if (mysqli_connect_errno()){
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	if($code != ""){
		$result = mysqli_query($con,"SELECT * FROM reqpass WHERE randomcode = '$code'");
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

		if(is_array($row)) {
			$username = $row["username"];
			$_SESSION["changepassid"] = $username;
?>
Ganti password
<div class="register-form">
	<form name="form-reg" method="post" action="<?php echo htmlspecialchars("change_pass_updatepass.php");?>" onsubmit="return chkEmail();">
		<table>
		<tr><td>New Password:</td><td><input id="pass1" type="password" required placeholder="Password" name="password" value="" onkeyup="chkPasswordStrength(this.value)">
		</td><td><span class="error"><?php echo $passErr;?></td><td id="strendth" class="strength5">Password Strength</td><td id="error"></td></span></tr>
		<tr><td>Confirm Password:</td><td><input id="pass2" type="password" required placeholder="Confirm password" name="cpassword" value="" onkeyup="checkPass()">
		</td><td><span class="error"><?php echo $cpassErr;?></td><td id="confirmMessage"><td></span></tr>
		</table>
		<input type="submit" name="submit" value="Submit"><input type="reset" value="Reset!">
	</form>
</div>
	
<script>

function chkEmail(){
	//password
	var txtpass = document.getElementById('pass1').value;
	
	if(txtpass.length < 6){
		alert("Password minimal 6 karakter");
		return false;
		//emailok = false;
	}
	
	if(!(txtpass.match(/[a-z]/)) || !(txtpass.match(/[A-Z]/))){
		alert("Password harus mengandung huruf besar dan kecil");
		return false;
		//emailok = false;
	}
	
	if(!(txtpass.match(/.[!,?,@,#,$,%,^,&,*,),(,-,_]/))){
		alert("Password harus mengandung karakter spesial");
		return false;
		//emailok = false;
	}
	
	//confirmpass
	var pass1 = document.getElementById('pass1').value;
	var pass2 = document.getElementById('pass2').value;
	if(pass1 != pass2){
		alert("Password harus match");
		return false;
	}
	
}

function chkPasswordStrength(txtpass){

		var desc = new Array();
		desc[0] = "Sangat lemah";
		desc[1] = "Lemah";
		desc[2] = "Sedang";
		desc[3] = "Kuat";
		desc[4] = "Sangat Kuat";
		var strengthMsg = document.getElementById("strendth");
		var errorMsg = document.getElementById("error");
		errorMsg.innerHTML = "";
		var score = 0;
	
		if(txtpass.length > 6){
			score++;
		}
	
		if((txtpass.match(/[a-z]/)) && (txtpass.match(/[A-Z]/))){
			score++;
		}
		
		if(txtpass.match(/.[!,@,#,$,%,^,&,*,),(,-,_]/)){
			score++;
		}
		
		if(txtpass.length > 12){
			score++;
		}
		
		strengthMsg.innerHTML = desc[score];
		strengthMsg.className = "strength" + score;
		
		if(txtpass.length<6){
			errorMsg.innerHTML = "Password harus minimum 6 karakter";
			errorMsg.className = "error";
		}
}

function checkPass(){
	var pass1 = document.getElementById('pass1');
	var pass2 = document.getElementById('pass2');

	var message = document.getElementById('confirmMessage');
	
	var goodColor = "#66cc66";
	var badColor = "#ff6666";
	
	if(pass1.value == pass2.value){
		pass2.style.backgroundColor = goodColor;
		message.style.color = goodColor;
		message.innerHTML = "Password Match!";
	} else {
		pass2.style.backgroundColor = badColor;
		message.style.color = badColor;
		message.innerHTML = "Password Do Not Match!";
	}
}
  
</script>
<?php } else {
			echo "Permintaan reset password tidak valid";
		}

	} else {
		echo "Permintaan reset password tidak valid2";
	}

} else {
	header("Location:change_pass2.php");
	//atau dirediret ke login mungkin
}?>
</body>
</html>