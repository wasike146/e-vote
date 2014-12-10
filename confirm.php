<?php
session_start();
?>
<?php
if(file_exists("sql.php")){
	require 'sql.php';
} else {
	die("Error");
}

$error = "";
if (empty($_GET["name"])){
	$name = "";
} else {
	$name = $_GET["name"];
	
}
//echo $name;
echo '<br>';
if (empty($_GET["code"])){
	$code = "";
} else {
	$code = $_GET["code"];
}

$active = false;

$con = mysqli_connect("$host","$user","$passdb","$db");

if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if(isset($_SESSION["id"]))	{
	$id = $_SESSION["id"];
	$result = mysqli_query($con,"SELECT * FROM user WHERE id = '$id'");
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	if($row["active"] == true){
		$active = true;
		echo "Anda sudah aktif";
	}
} 

if($active == false){
	$result = mysqli_query($con,"SELECT * FROM user WHERE username = '$name'");
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	if(is_array($row)) {
		//user ada, cek apakah sudah aktif
		if($row["active"] == false){
			//belum aktif, cek token
			$result = mysqli_query($con,"SELECT * FROM user WHERE username = '$name' AND token='$code'");
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			if(is_array($row)) {
				//cek apakah token masih berlaku
				$expiredate = strtotime($row["expire"]);
				$curdate = strtotime(date("Y-m-d H:i:s"));
				$datediff = $curdate - $expiredate;
				if($datediff<0){
					
					//token berlaku
					$sql="UPDATE user
					SET active = true WHERE username = '$name'";
					if (!mysqli_query($con,$sql)) {
					  die('Error: ' . mysqli_error($con));
					} else {
						if(isset($_SESSION["id"])){
							$error = "Akun Anda berhasil diaktifkan.<br>Klik <a href='vote.php'>di sini</a> untuk vote";
						} else {
							$error = "Akun Anda berhasil diaktifkan.<br>Klik <a href='log-in.php'>di sini</a> untuk login";
						}
					}
					
				} else {
					//token tidak berlaku, minta pesan baru lagi
					$error = "token sudah tidak berlaku <a href='request_token.php'>Kirim ulang lagi</a>";
				}
			} else {
				//token salah
				$error = "token salah";
			}
		} else {
			//sudah aktif
			$error = "Akun anda sudah aktif";
		}

	} else {
		//user tidak ada
		$error = "User tidak ada. Silahkan <a href='register.php'>daftar</a>";
	}
}
//echo $type;

?>

<?php echo $error;?>