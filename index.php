<?php
	require 'method/function.php';

	// ----------------------------
	// 		Waktu&Tanggal
	// ----------------------------
	$getWaktu = getWaktu();
	if($getWaktu['waktu'] == 'pagi' || $getWaktu['waktu'] == 'malam'){
		$warna = 'E9E9E9';
		$stroke = '393939'; 
	}else{
		$warna = '393939';
		$stroke = 'E9E9E9'; 
	}

	// ----------------------------
	// 		Get Data Ebook
	// ----------------------------
	$jmlDataPerhalaman = 20;
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

	<!------------------------------------ CSS ------------------------------------>
	<link rel="preconnect" href="https://fonts.gstatic.com"><link href="https://fonts.googleapis.com/css2?family=Indie+Flower&family=Merienda+One&family=Oswald:wght@300&family=Permanent+Marker&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<style>
		body{
			background-image     : url(asset/imgBground/<?= $getWaktu['bgBesar']; ?>);
			background-size      : cover;
			background-repeat    : no-repeat;
			background-attachment: fixed;
		}
		#burgerOpen{
			display: block;
		}
		#burgerClose{
			display: none;
		}
		#burgerOpen.hidden{
			display: none;
		}
		#burgerClose.rise{
			display: block;
		}
		h1.sapa,#kalender h1{
			font-size: 60px;
		}
		h3.sapa,#kalender p{
			font-size: 30px;
		}
		#rowCard a:hover{
			transition: all 0.2s;
			transform: scale(1.1);
		}
		/* ///////////////////////////////////////////////// */
		@media(max-width: 768px){
			body{
				background-image     : url(asset/imgBground/<?= $getWaktu['bgKecil']; ?>);
				background-size      : cover;
				background-repeat    : no-repeat;
				background-attachment: fixed;
			}
			#kalender{
				margin-top: 20px;
			}
			h1.sapa,#kalender h1{
				font-size: 50px;
			}
			h3.sapa,#kalender p{
				font-size: 24px;
			}
			footer{
				flex-direction: column;
			}
			footer span{
				margin-bottom: 5px;
			}
		}
		@media(max-width: 576px){
			#header{
				flex-direction: column;
				text-align: center;
			}
			h1.sapa,#kalender h1{
				font-size: 40px;
			}
			h3.sapa,#kalender p{
				font-size: 16px;
				margin: 10px 0 0 0;
			}
		}
	</style>
</head>
<body>

	<!-- NAVBAR -->
	<nav class="navbar navbar-expand-md fixed-top px-3 py-2" style="background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 4px );-webkit-backdrop-filter: blur( 4px );">
		<a class="navbar-brand font-weight-bold" href="" style="font-family: 'Oswald', sans-serif; color: #<?= $warna; ?>;-webkit-text-stroke-width: 0.02vw;-webkit-text-stroke-color: #<?= $stroke; ?>;">
			<img src="asset/imgBground/logo2.png" alt="Logo" style="width:30px;"><span class="align-middle"> RumahEbook</span>
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 124 124" id="burgerOpen">
				<g><path fill="#<?= $warna; ?>" d="M112,6H12C5.4,6,0,11.4,0,18s5.4,12,12,12h100c6.6,0,12-5.4,12-12S118.6,6,112,6z"/><path fill="#<?= $warna; ?>" d="M112,50H12C5.4,50,0,55.4,0,62c0,6.6,5.4,12,12,12h100c6.6,0,12-5.4,12-12C124,55.4,118.6,50,112,50z"/><path fill="#<?= $warna; ?>" d="M112,94H12c-6.6,0-12,5.4-12,12s5.4,12,12,12h100c6.6,0,12-5.4,12-12S118.6,94,112,94z"/></g>
			</svg>
			<svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 348.333 348.334" id="burgerClose">
				<g><path fill="#<?= $warna; ?>" d="M336.559,68.611L231.016,174.165l105.543,105.549c15.699,15.705,15.699,41.145,0,56.85
					c-7.844,7.844-18.128,11.769-28.407,11.769c-10.296,0-20.581-3.919-28.419-11.769L174.167,231.003L68.609,336.563
					c-7.843,7.844-18.128,11.769-28.416,11.769c-10.285,0-20.563-3.919-28.413-11.769c-15.699-15.698-15.699-41.139,0-56.85
					l105.54-105.549L11.774,68.611c-15.699-15.699-15.699-41.145,0-56.844c15.696-15.687,41.127-15.687,56.829,0l105.563,105.554
					L279.721,11.767c15.705-15.687,41.139-15.687,56.832,0C352.258,27.466,352.258,52.912,336.559,68.611z"/>
				</g>
			</svg>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto text-center">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="sans-serif; color: #<?= $warna; ?>;-webkit-text-stroke-width: 0.02vw;-webkit-text-stroke-color: #<?= $stroke; ?>;">
						<strong>Kategori</strong>
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
					<a class="nav-link link" href="#kritiksaran" style="sans-serif; color: #<?= $warna; ?>;-webkit-text-stroke-width: 0.02vw;-webkit-text-stroke-color: #<?= $stroke; ?>;">
						<strong>Kritik & Saran</strong> 
					</a>
				</li>
				<li class="nav-item ">
					<a class="nav-link" href="admin/" style="sans-serif; color: #<?= $warna; ?>;-webkit-text-stroke-width: 0.02vw;-webkit-text-stroke-color: #<?= $stroke; ?>;">
						<strong>Upload</strong> 
						<span class="sr-only">(current)</span></a>
				</li>
			</ul>
		</div>
	</nav>
	<!-- </NAVBAR> -->

	<!-- main-content -->
	<div class="position-relative container-fluid vh-100" style="padding: 60px 0 0 0;">

		<!-- header -->
		<div id="header" class="container-fluid m-0 pt-4 pl-4 pr-4 pb-4" style="display: flex;justify-content: space-between;align-items: center;">
			<div class="col h-100 p-0 m-0" style="color: #<?= $warna; ?>;">
				<h1 class="sapa" style="-webkit-text-stroke-width: 1px;-webkit-text-stroke-color: #<?= $stroke; ?>;font-weight: bolder;font-family: 'Oswald', sans-serif;letter-spacing: 1px;">
					Selamat <?= $getWaktu['waktu']; ?></h1>
				<h3 class="sapa" style="-webkit-text-stroke-width: 0.02vw;-webkit-text-stroke-color: #<?= $stroke; ?>;font-weight: bolder;font-family: 'Oswald', sans-serif;letter-spacing: 1px;">
					Sudah baca buku hari ini ??</h3>
			</div>
			<div id="kalender" class="col-3 col-sm-3 col-md-3 col-lg-2 col-xl-2 p-0 bg-warning rounded-lg position-relative" style="box-shadow: 4px 4px 6px 0px rgba(0,0,0,0.6); min-width: 100px;">
				<img src="asset/imgAdmin/gambardefault.jpg" width="100%" style="opacity: 0;">
				<div style="position: absolute; top:0; bottom:0; left:0; right:0;" class="d-flex flex-column justify-content-center align-items-center">
					<h1 class="k1" style="font-family: 'Permanent Marker', cursive;">
						<?= $getWaktu['kalender1']; ?></h1>
					<p class="k2" style="font-family: 'Oswald', sans-serif;">
						<?= $getWaktu['kalender2']; ?></p>
				</div>
			</div>
		</div><!-- header -->

		<!-- card -->
		<div class="container-fluid m-0 px-4" style="min-height: 62%;" id="containerCard">
			<div class="row m-0 d-flex justify-content-center" id="rowSearch">
				<div class="col-md-6 col-lg-6 col-xl-4 p-0">
					<input type="text" class="form-control w-100" id="formSearchEbook" placeholder="&#xF002; search" style="font-family:Arial, FontAwesome; border-radius:20px;">
				</div>
			</div>
			<div class="position-relative row mx-0 mt-3 pt-3 px-2 rounded-lg d-flex align-items-start flex-wrap" id="rowCard" style="background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 4px );-webkit-backdrop-filter: blur( 4px );">
				
				<!-- ebooks -->
				<?php foreach($dataebook1 as $dataebook2) : ?>
					<a href="download/?idbuku=<?= $dataebook2['id']; ?>" class="col-1 px-2 mb-3" title="<?= $dataebook2['judulbuku']; ?>" data-toggle="tooltip" style="min-width:100px;">
						<img src="asset/imgEbook/<?= $dataebook2['fotobuku']; ?>" class=" rounded-lg" width="100%" height="136px">
					</a>
				<?php endforeach; ?><!-- ebooks -->

				<!-- pagination -->
				<div class="d-flex justify-content-center" style="position: absolute;bottom: -18px;left:0;right:0;">
				<ul class="pagination m-0">
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
				</ul><!-- pagination -->
				</div>

			</div>
		</div><!-- card -->


		<!-- <FOOTOER> -->
		<div class="position-relative w-full" id="kritiksaran" style="padding: 16px 0px 60px 0px;background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 4px );-webkit-backdrop-filter: blur( 4px );">
			<h4 class="text-light text-center mb-3"><strong>Kritik & Saran</strong></h4>
			<div class="container-fluid p-4">
				<form method="post" id="formKritik">
					<input id="tglKritik" type="hidden" name="tglKritik" value="<?= $tglKritik; ?>">
					<div class="form-group">
						<input type="text" class="form-control" name="namaKritik" placeholder="Username">
					</div>
					<div class="form-group">
						<textarea id="pesanKritik" class="form-control" rows="8" name="pesanKritik" required></textarea>
					</div>
					<div class="d-flex justify-content-end">
						<button type="submit" class="btn btn-primary" name="tombolKritik" id="kritik&saran" style="letter-spacing:4px;">
							<strong>Kirim</strong>
						</button>
					</div>
				</form>
			</div>
			
			<footer class="position-absolute fixed-bottom px-4" style="background: linear-gradient(to bottom, rgba(255, 255, 255, 0.0) 10%, black 98%);display: flex;align-items: center;justify-content: space-between;">
				<span class="text-light" style="word-spacing: 2px;">Made With <img src="asset/imgBground/love.svg" width="30px" style="transform: translateY(-2px);"> by <a href="https://www.instagram.com/el.koro_/" target="_blank" style="text-decoration: none; font-weight: 500;"><i class="fas fa-at"></i>Bagaskoro</a>
				</span>
				<span class="text-light"><img src="asset/imgBground/pin.svg" width="30px" style="transform: translateY(-4px);">  South Tangerang, Indonesia</span>
			</footer>
		</div>
		<!-- </FOOTOER> -->
	</div>



	<!---------------------- js ---------------------->
	<script src="https://kit.fontawesome.com/6357e7545a.js" crossorigin="anonymous"></script><script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script><script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="myjs.js"></script>
	<script>
		// burger open & close
		document.querySelector('.navbar-toggler').addEventListener('click',function(){
			if(!document.querySelector('#burgerOpen').classList.contains('hidden')){
				document.querySelector('#burgerOpen').classList.add('hidden');
				document.querySelector('#burgerClose').classList.add('rise');
			}else{
				document.querySelector('#burgerOpen').classList.remove('hidden');
				document.querySelector('#burgerClose').classList.remove('rise');
			}
		})
		// smooth scroll
		document.querySelectorAll('a.link').forEach(trigger => {
			trigger.onclick = function(e) {
				e.preventDefault();
				let hash = this.getAttribute('href');
				let target = document.querySelector(hash);
				let headerOffset = 0;
				let elementPosition = target.offsetTop;
				let offsetPosition = elementPosition - headerOffset;
				window.scrollTo({
					top: offsetPosition,
					behavior: "smooth"
				});
			};
		});
		// container card height
		let containerCardHeigh = document.querySelector('#containerCard').clientHeight;
		document.querySelector('#rowCard').style.minHeight = (containerCardHeigh/1.26)+'px';
		// search enggine
		let formSearchEbook = document.querySelector('#formSearchEbook');
		formSearchEbook.addEventListener('keyup', function () {
			let xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function () {
				if (xhr.readyState == 4 && xhr.status == 200) {
					document.querySelector('#rowCard').innerHTML = xhr.responseText;
				}
			}
			xhr.open('GET', 'ajax/ebookSearch.php?key=' + formSearchEbook.value, true);
			xhr.send();
		});
	</script>
</body>
</html>