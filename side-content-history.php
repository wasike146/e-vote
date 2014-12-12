<?php session_start();
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
 		<p> You are here : Home > <strong> History </strong>	
 		</p>
 		<h1> KETUA ARC DARI MASA KE MASA
 		</h1>
 		<div class="history">
 		<!-- SCRIPT UNTUK ZOOM IN IMAGE IN THE CURRENT PAGE
	<img id="zoom_05" src="small/image1.png" data-zoom-image="large/image1.jpg"/>

		UNTUK INCLUDE FILE .js, scriptnya :
		<script type="text/javascript" src="file.js"></script>
 		-->
		
 		<ol>
 			 
 			<div class="kiri">

 			<li> Ketua ARC 2010 :<br> Wahyu Hardianto (EL '07)
 			</li>
 			<a href="img/1.png" target="_blank" title="click to zoom in"> <img src="img/1-kecil.png"> </a>
 			<li> Ketua ARC 2011 :<br> Faisal Dwiyana (KL '08)
 			</li>
 			<a href="img/2.png" target="_blank" title="click to zoom in"> <img src="img/2-kecil.png"> </a>
 			<li> Ketua ARC 2012 :<br> Fatih Kalifa (EL '09)
 			</li>
 			<a href="img/3.png" target="_blank" title="click to zoom in"> <img src="img/3-kecil.png"> </a>
 			</div>
 			<!-- div kanan -->
 			<div class="kanan">
 			<li> Ketua ARC 2013 :<br> Lukmanul Hakim (AS '10)
 			</li>
 			<a href="img/4.png" target="_blank" title="click to zoom in"> <img src="img/4-kecil.png"> </a>
 			<li> Ketua ARC 2014 :<br> Habibie Faried (IF '11)
 			</li>
 			<a href="img/5.png" target="_blank" title="click to zoom in"> <img src="img/5-kecil.png"> </a>
 			<li><strong>  Ketua ARC 2015 :<br> Who's next ? </strong>
 			</li>
 			<img src="img/6.svg"> </a>
 			</div>
 			</ol>
 		</div>
	</div>
</div>
</body>
