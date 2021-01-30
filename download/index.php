<?php 
	require '../method/function.php';

	// ----------------------------
	// 		Waktu&Tanggal
	// ----------------------------
	$getWaktu = getWaktu();
	if($getWaktu['waktu'] == 'pagi' || $getWaktu['waktu'] == 'malam'){
		$warna = 'E9E9E9';
	}else{
		$warna = '393939';
	}

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
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Indie+Flower&family=Merienda+One&family=Oswald:wght@300&family=Permanent+Marker&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<style>
		body{
			background-image     : url(../asset/imgBground/<?= $getWaktu['bgBesar']; ?>);
			background-size      : cover;
			background-repeat    : no-repeat;
			background-attachment: fixed;
		}
		/*///////////////////////////////////////////////////////////////////////////////////////////////*/
		@media(max-width: 710px){
			body{
				background-image     : url(../asset/imgBground/<?= $getWaktu['bgKecil']; ?>);
				background-size      : cover;
				background-repeat    : no-repeat;
				background-attachment: fixed;
			}
		}
		@media(max-width: 576px){
			.row-image-desk{
				flex-direction: column;
			}
		}
		@media(max-width: 400px){
			#col-deskripsi h1{
				font-size: 25px;
			}
			#col-deskripsi h5{
				font-size: 13px;
			}
		}
	</style>
</head>
<body>

	<!-- NAV -->
	<nav class="navbar px-3" style="background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 4px );-webkit-backdrop-filter: blur( 4px );">
		<a href="../" class="navbar-brand font-weight-bold btn btn-info">
			<img src="../asset/imgBground/home.svg" width="28px">
		</a>
	</nav><!-- </NAV> -->

	<!-- main-content -->
	<div class="position-relative container-fluid d-flex justify-content-center align-items-center" style="min-height: 93.6vh;">

		<!-- <div download> -->
		<div class="container-fluid row d-flex justify-content-center pt-4 pb-5">
			<div class="col-sm-11 col-md-10 col-lg-9 col-xl-8 rounded-lg" style="overflow: hidden;background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 6px );-webkit-backdrop-filter: blur( 6px );">	
				<div class="row row-image-desk d-flex align-items-center">
					<!-- foto-preview -->
					<div class="col-6 col-sm-4 col-md-4 col-lg-4 col-xl-3 p-3" style="min-width: 200px;">
						<img src="../asset/imgEbook/<?= $dataNovel1['fotobuku']; ?>" width="100%">
					</div>
					<!-- deskripsi -->
					<div class="col p-3" id="col-deskripsi">
						<h1 class="text-center" style="-webkit-text-stroke: 1px white;"><strong><?= $dataNovel1['judulbuku']; ?></strong></h1>
						<ol class="mt-4 py-0 px-3">
							<li><h5>Penulis : <?= $dataNovel1['penulis']; ?></h5></li>
							<li><h5>Penerbit : <?= $dataNovel1['penerbit']; ?></h5></li>
							<li><h5>Tahun Terbit : <?= $dataNovel1['tglterbit']; ?></h5></li>
							<li><h5>Kategori : <?= $dataNovel1['kategori']; ?></h5></li>
						</ol>
					</div>
				</div>
				<div class="row p-3">
					<!-- Sinopsis Box -->
					<div class="col px-4 py-2 rounded-lg" style="overflow:auto; height:240px;font-family: monospace; background: rgba( 255, 255, 255, 0.7 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 6px );-webkit-backdrop-filter: blur( 6px );">
						<h3 class="text-center mt-2"><strong>SINOPSIS</strong></h3>
						<h6 class="mt-3"><?= $dataNovel1['sinopsis']; ?></h6>
					</div>
				</div>
			</div>
		</div>

		
		<a href="<?= ($dataNovel1['linkgdrive']) ? $dataNovel1['linkgdrive'] : '../asset/fileEbook/'.$dataNovel1['fileebook']  ?>" class="btn btn-success p-0 rounded-circle" target="_blank" title="download" data-toggle="tooltip" data-placement="left" style="position: fixed; bottom:20px; right:20px;">
			<img src="../asset/imgBground/download.svg" width="60px"></a>
		
	</div><!-- main-content -->
	
	<!---------------------- js ---------------------->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script><script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script>
		($('[data-toggle="tooltip"]')) ? $('[data-toggle="tooltip"]').tooltip() : ''; 
	</script>
</body>
</html>