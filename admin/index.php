<?php 
	require '../method/function.php';
	session_start();

	// ----------------------------
	// 		Waktu&Tanggal
	// ----------------------------
	date_default_timezone_set('Asia/Jakarta');
	$tglKritik    = date('l, j-n-Y',mktime());
	$kalender1    = date('j', mktime());
	$kalender2    = date('M, Y', mktime());
	$batas1       = date('j-n-Y',mktime()+86400);
	$explode      = explode('-', $batas1);
	$m            = $explode[1];
	$d            = $explode[0];
	$y            = $explode[2];
	$waktuSaatIni = date(mktime());
	$batas2       = date(mktime(0,0,0,$m,$d,$y));
	$selisih      = $batas2 - $waktuSaatIni;
	// $selisih = 50000;
	if($selisih <= 86400 && $selisih>= 50400){
		$waktu = 'pagi';
	}
	else if($selisih <= 50400 && $selisih>= 32400){
		$waktu = 'siang';
	}
	else if($selisih <= 32400 && $selisih>= 21600){
		$waktu = 'sore';
	}
	else{
		$waktu = 'malam';
	}
	$bgBesar  = $waktu.'.jpg';
	$bgKecil  = $waktu.'2.jpg';

	// ----------------------------
	//          SESSION 
	// ----------------------------
	if(!isset($_SESSION["admin"])){
		header("location:../login");
		exit;
	}

	// ----------------------------
	//        Tambah Admin 
	// ----------------------------
	if(isset($_POST["daftaradmin"])){
		if(daftaradmin($_POST) > 0){
			$berhasil = true;
		}
		else if(daftaradmin($_POST) == 'sama'){
			$sama = true;
		}
		else if(daftaradmin($_POST) == 'salah'){
			$salah = true;
		}
		else{
			echo mysqli_error($conn);
		}
	}

	// ambil nama admin
	$idNama = $_COOKIE["nameIdAdmin"];
	$admin  = tampil("SELECT*FROM admin WHERE id='$idNama'")[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../asset/imgBground/logo2.png" type="image/x-icon">	
	<title>Halaman Admin</title>

	<!------------------------------------ CSS ------------------------------------>
	<link href="https://fonts.googleapis.com/css2?family=Merienda+One&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="../mycss.css">
	<style>
		html,body{
			scroll-behavior: smooth;
		}
		body{
			background-image     : url(../asset/imgBground/<?= $bgBesar; ?>);
			background-size      : cover;
			background-repeat    : no-repeat;
			background-attachment: fixed;
			padding              : 0px 0px 0px 0px;
		}
		/* ///////////////////////////////////////////////// */
		@media(max-width: 710px){
			body{
				background-image     : url(../asset/imgBground/<?= $bgKecil; ?>);
				background-size      : cover;
				background-repeat    : no-repeat;
				background-attachment: fixed;
			}
		}
	</style>
</head>

<?php if(!isset($pengunjung)) : ?>
<body>

<section class="sec-one">
	<!-- NAV -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
		<a class="navbar-brand" href="" style="font-family: 'Oswald', sans-serif;">
			<img src="../asset/imgBground/logo2.png" alt="Logo" style="width:30px;">
			RumahEbook
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
			<a class="nav-link" href="../method/logout.php">
				<i class="fas fa-sign-out-alt" style="font-size: 20px;"> Logout </i> 
				<span class="sr-only">(current)</span>
			</a>
			</li>
		</ul>
		</div>
	</nav>
	<!-- </NAV> -->

	<div class="sapaKalender">
		<!-- SAPA -->
			<div class="d-flex align-items-start flex-column">
				<!-- foto admin -->
				<div class="fotoadmin mb-3">
					<img src="../asset/imgAdmin/<?= $admin['adminfoto']; ?>" width="100%" height="100%">
				</div>
				<!-- </foto admin> -->
				<div class="wrapSapa">
					<h1 class="sapa1">
						Selamat <?= $waktu; ?>, <?= $admin["adminname"]; ?>
					</h1>
					<h4 class="sapa2">
						<i class="fas fa-heart" style="color: #ff0730;"></i> . . Selamat bekerja . . <i class="fas fa-heart" style="color: #ff0730;"></i>
					</h4>
				</div>
			</div>
		<!-- </SAPA> -->

		<!-- <Kalender> -->
		<div class="kalender" style="transform: translateY(-28px);">
			<p class="k1">
				<?= $kalender1; ?>
			</p>
			<p class="k2">
				<?= $kalender2; ?>
			</p>
		</div>
		<!-- </Kalender> -->
	</div>

	<div class="wrapEdit">
		<a href="../crud/?xx=kritik" class="hrefEdit kritik">
			<h1><i class="fas fa-comments"></i></h1>
			<h3>KRITIK</h3>
		</a>
		<a href="../crud/?xx=admin" class="hrefEdit admin" style="color: white;">
			<h1><i class="fas fa-users-cog"></i></h1>
			<h3>ADMIN</h3>
		</a>
		<a href="../crud/?xx=ebook" class="hrefEdit ebook" style="color: white;">
			<h1><i class="fas fa-book"></i></h1>	
			<h3>E-BOOK</h3>
		</a>
	</div>

</section>

<!-- <footer> -->
<footer class="footerAdmin">
	<span>
		Made With
		<i class="fas fa-heart" style="color: red;"></i>
		by 
		<a href="https://www.instagram.com/el.koro_/" target="_blank" style="text-decoration: none; font-weight: 500;">
			<i class="fas fa-at"></i>Bagaskoro
		</a>
	</span>
	<span>
		<i class="fas fa-map-marker-alt"></i> South Tangerang, Indonesia
	</span>
</footer>
<!-- </footer> -->

<!---------------------- js ---------------------->
<script src="https://kit.fontawesome.com/6357e7545a.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="../myjs.js"></script>
</body>

<?php endif; ?>
</html>