<?php 
	require '../method/function.php';

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
	// 		Get Ebook Data
	// ----------------------------
	if(!isset($_GET['idbuku'])){
		header('location:../');
	}
	$idBuku = $_GET["idbuku"];
	$dataNovel1 = tampil("SELECT * FROM ebook WHERE id = '$idBuku'")[0];

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../asset/imgBground/logo2.png" type="image/x-icon">
	<meta charset="UTF-8">
	<title>Download</title>

	<!------------------------------------------- CSS --------------------------------------------->
	<link href="https://fonts.googleapis.com/css2?family=Merienda+One&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="../mycss.css">
	<style>
		body{
			background-image     : url(../asset/imgBground/<?= $bgBesar; ?>);
			background-size      : cover;
			background-repeat    : no-repeat;
			background-attachment: fixed;
		}
		/*///////////////////////////////////////////////////////////////////////////////////////////////*/
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
<body>
	<!-- <NAV> -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="navbar-brand" href="../" style="font-family: 'Oswald', sans-serif;">
					<i class="fas fa-house-user" style="font-size: 17px;"> Beranda</i> 
				</a>
			</li>
		</ul>
	</nav>
	<!-- </NAV> -->

	<!-- <lemarin >-->
	<div class="lemariDownload">
		<div class="kotakAtas">
			<img src="../asset/imgEbook/<?= $dataNovel1['fotobuku']; ?>" width="160px" height="210px">
			<table>
				<tr>
					<td><strong>judul buku</strong> </td><td><strong>:</strong> <?= $dataNovel1['judulbuku']; ?></td>
				</tr>
				<tr>
					<td><strong>penulis</strong> </td><td><strong>:</strong> <?= $dataNovel1['penulis']; ?></td>
				</tr>
				<tr>
					<td><strong>penerbit</strong> </td><td><strong>:</strong> <?= $dataNovel1['penerbit']; ?></td>
				</tr>
				<tr>
					<td><strong>tahun terbit</strong> </td><td><strong>:</strong> <?= $dataNovel1['tglterbit']; ?></td>
				</tr>
				<tr>
					<td><strong>kategori</strong> </td><td><strong>:</strong> <?= $dataNovel1['kategori']; ?></td>
				</tr>
			</table>
		</div>
		<div class="kotakBawah">
			<h4><strong>Sinopsis</strong></h4>
			<?= $dataNovel1['sinopsis']; ?>
		</div>
		<a href="../asset/fileEbook/<?= $dataNovel1['fileebook']; ?>" class="btn btn-success" target="_blank">
			<i class="fas fa-download"></i> download
		</a>
	</div>
	<!-- </lemarin> -->

	<!-- <footer> -->
	<footer class="footerDownload">
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
</html>