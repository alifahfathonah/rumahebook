<?php
	require 'method/function.php';

	// ----------------------------
	// 		Waktu&Tanggal
	// ----------------------------
	date_default_timezone_set('Asia/Jakarta');
	$tglKritik    = date('D, j-n-Y, G:i:s',mktime());
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
	// 		Get Data Ebook
	// ----------------------------
	$jmlDataPerhalaman = 6;
	$totalDataEbook = count(tampil("SELECT*FROM ebook"));
	$jmlHalaman = ceil($totalDataEbook / $jmlDataPerhalaman);
	if(isset($_GET['halaman'])){
		$halamanAktiv = $_GET['halaman'];
	}
	else{
		$halamanAktiv = 1;
	}
	$indexAwal = ($jmlDataPerhalaman*$halamanAktiv) - $jmlDataPerhalaman;
	$dataebook1 = tampil("SELECT*FROM ebook ORDER BY id DESC LIMIT $indexAwal,$jmlDataPerhalaman");

	// ----------------------------
	// 		Button Kritik
	// ----------------------------
	if(isset($_POST["tombolKritik"])){
		if(sendKritik($_POST)>0)
		{
			$terkirim = true;
		}
		else{
			echo mysqli_error($conn);
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="icon" href="asset/imgBground/logo2.png" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<title>RumahEbook</title>

	<!---------------------- CSS ---------------------->
	<link href="https://fonts.googleapis.com/css2?family=Merienda+One&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="mycss.css">
	<style>
		body{
			background-image     : url(asset/imgBground/<?= $bgBesar; ?>);
			background-size      : cover;
			background-repeat    : no-repeat;
			background-attachment: fixed;
			padding              : 0px 0px 0px 0px;
		}
		/* ///////////////////////////////////////////////// */
		@media(max-width: 710px){
			body{
				background-image     : url(asset/imgBground/<?= $bgKecil; ?>);
				background-size      : cover;
				background-repeat    : no-repeat;
				background-attachment: fixed;
			}
		}
	</style>
</head>
<body>
<section class="sec-one">

	<!-- NAVBAR -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
		<a class="navbar-brand" href="" style="font-family: 'Oswald', sans-serif;">
			<img src="asset/imgBground/logo2.png" alt="Logo" style="width:30px;">
			RumahEbook
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-layer-group"> Kategori</i>
					</a>
					<div class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="kategori/?kategori=novel">Novel</a>
						<a class="dropdown-item" href="kategori/?kategori=resep makanan">Resep Makanan</a>
						<a class="dropdown-item" href="kategori/?kategori=buku anak">Buku Anak</a>
						<a class="dropdown-item" href="kategori/?kategori=komik">Komik</a>
						<a class="dropdown-item" href="kategori/?kategori=buku islam">Buku Islam</a>
						<a class="dropdown-item" href="kategori/?kategori=ilmu pengetahuan">Ilmu Pengetahuan</a>
					</div>
				</li>
				<li class="nav-item ">
					<a class="nav-link" href="#kritik&saran">
						<i class="fas fa-comment-dots"> Kritik & Saran</i> 
					</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link" href="admin/">
					<i class="fas fa-cloud-upload-alt"> Upload</i> 
					<span class="sr-only">(current)</span></a>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="logout.php">
						<i class="fas fa-sign-out-alt" style="font-size: 20px;"> Logout </i> 
					</a>
				</li>
			</ul>
		</div>
	</nav>
	<!-- </NAVBAR> -->

	<!-- Flash Message -->
	<?php if(isset($terkirim)) : ?>
	<div class="alert alert-success alert-dismissible" style="position: fixed; top:56px; left:0 ; right: 0; z-index: 10000;">
		<button type="button" class="close" data-dismiss="alert">
			&times;
		</button>
		<strong>Success!</strong> Pesan Terkirim . . .
	</div>
	<?php endif; ?>
	<!-- </info pesan terkirim> -->

	<div class="sapaKalender">
	<!-- SAPA -->
		<div class="divSapa">
			<h1 class="sapa1">
				Selamat <?= $waktu; ?> <i class="fas fa-smile-beam" style="color: #f99f2a;"></i>
			</h1>
			<h4 class="sapa2">
				Sudah baca buku hari ini ?
			</h4>
		</div>
	<!-- </SAPA> -->

	<!-- <Kalender> -->
		<div class="kalender">
			<p class="k1">
				<?= $kalender1; ?>
			</p>
			<p class="k2">
				<?= $kalender2; ?>
			</p>
		</div>
	<!-- </Kalender> -->
	</div>
		
	<!-- <SEARCH> -->
	<div class="" id="divSearchIndex">
		<form>
			<div class="form-group w-100">
				<input type="text" class="form-control w-100" id="formSearchIndex" placeholder="&#xF002; search" style="font-family:Arial, FontAwesome;">
			</div>
		</form>
	</div>
	<!-- </SEARCH> -->

	<!-- <container-lemari> -->
		<div class="container-lemari" id="lemariIndex">
			
			<?php foreach($dataebook1 as $dataebook2) : ?>
				<a href="download/?idbuku=<?= $dataebook2['id']; ?>" id="MyCard" title="<?= $dataebook2['judulbuku']; ?>">
					<img src="asset/imgEbook/<?= $dataebook2['fotobuku']; ?>">
				</a>
			<?php endforeach; ?>

			<ul class="pagination">
				<?php if($halamanAktiv > 1) : ?>
				<li class="page-item">
					<a class="page-link" href="?halaman=<?= $halamanAktiv - 1; ?>" aria-label="Previous">
						<span aria-hidden="true">&laquo;</span>
					</a>
				</li>
				<?php endif; ?>

				<?php for($i=1; $i<=$jmlHalaman; $i++) : ?>
					<?php if($i == $halamanAktiv) : ?>
					<li class="page-item active" aria-current="page">
						<a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
					</li>
					<?php else : ?>
					<li class="page-item"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
					<?php endif; ?>
				<?php endfor; ?>

				<?php if($halamanAktiv < $jmlHalaman) : ?>
				<li class="page-item">
					<a class="page-link" href="?halaman=<?= $halamanAktiv + 1; ?>" aria-label="Next">
						<span aria-hidden="true">&raquo;</span>
					</a>
				</li>
				<?php endif; ?>
			</ul>
			
		</div>
	<!-- </container-lemari> -->

</section>

<section class="sec-two">
<!-- <FOOTOER> -->
	<footer class="bg-dark footer-one">
		<h3>Kritik & Saran</h3>
		<div class="container">
			<form method="post" id="formKritik">
				<input id="tglKritik" type="hidden" name="tglKritik" value="<?= $tglKritik; ?>">
				<div class="form-group">
					<input type="text" class="form-control" name="namaKritik" placeholder="Username">
				</div>
				<div class="form-group">
					<textarea id="pesanKritik" class="form-control" rows="5" name="pesanKritik" required></textarea>
				</div>
				<button type="submit" class="btn btn-primary" name="tombolKritik" id="kritik&saran" style="letter-spacing:4px;">
					<strong>Kirim</strong>
				</button>
			</form>
		</div>
		<div class="footer-two">
			<span>
				Made With <i class="fas fa-heart" style="color: red;"></i> by <a href="https://www.instagram.com/el.koro_/" target="_blank" style="text-decoration: none; font-weight: 500;"><i class="fas fa-at"></i>Bagaskoro</a>
			</span>
			<span>
				<i class="fas fa-map-marker-alt"></i> South Tangerang, Indonesia
			</span>
		</div>
	</footer>
<!-- </FOOTOER> -->
</section>

<!---------------------- js ---------------------->
<script src="https://kit.fontawesome.com/6357e7545a.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="myjs.js"></script>
</body>
</html>