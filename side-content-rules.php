<?php session_start();
?>
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
 		<p> You are here : Home > <strong> Rules </strong>	
 		</p>
 		<h1> PERATURAN E-VOTING 
 		</h1>
 		<div class="rules">
 		<ol>
 			<li> Waktu pemilihan dibuka pada tanggal 18 Desember dan ditutup pada 20 Desember 2014.
 			</li>
 			<li> Tiap Kru ARC ITB dari angkatan <strong> 2011 - 2014 </strong> berhak memilih 1 calon.	
 			</li>
 			<li> Untuk mendaftar (di halaman <a href="http://localhost/sign-up.php"> SIGN UP </a>), gunakan <strong> e-mail arc </strong>.
 			</li>
 			<li> Pemilihan hanya dapat dilakukan sekali.
 			</li>
 			<li> Hasil penghitungan suara akan diumumkan sehari setelah deadline pemilihan.
 			</li>
 			<li> Keputusan Panitia Pemilu tidak dapat diganggu gugat (diajukan ke MK).
 			</li>
 		</ol>
 		</div>
	</div>

</div>
</body>
