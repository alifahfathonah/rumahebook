<?php 
	require '../method/function.php';
	global $conn;
	
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
	// 			session 
	// ----------------------------
	session_start();
	if(!isset($_SESSION["admin"])){
		header("location:../login");
		exit;
	}

	// ----------------------------
	// 			edit admin
	// ----------------------------
	if(isset($_GET["idadmin"])){
		$idadmin  = $_GET["idadmin"];
		$dataadmin = tampil("SELECT*FROM admin WHERE id='$idadmin'")[0];
	}
	if(isset($_POST["editadmin"])){
		if(editadmin($_POST) > 0)
		{
			$berhasil = true;
		}
		else if(editadmin($_POST) == 'sama')
		{
			$sama = true;
		}
		else if(editadmin($_POST) == 'bukanfoto')
		{
			$bukanfoto = true;
		}
		else if(editadmin($_POST) == 'oversize')
		{
			$oversize = true;
		}
		else if(editadmin($_POST) == 'nothingupload')
		{
			$nothingupload = true;
		}
		else
		{
			echo mysqli_error($conn);
		}
	}

	// ----------------------------
	// 			edit ebook
	// ----------------------------
	if(isset($_GET["idbuku"])){
		$idbuku = $_GET["idbuku"];

		$dataebook = tampil("SELECT*FROM ebook WHERE id='$idbuku'")[0];
	}
	if(isset($_POST["editebook"])){
		if(editebook($_POST) > 0){
			$berhasil = true;
		}
		else if(editebook($_POST) == 'sama'){
			$nothingupload = true;
		}
		else if(editebook($_POST) == 'bukanfoto'){
			$bukanfoto = true;
		}
		else if(editebook($_POST) == 'oversize'){
			$oversize = true;
		}
		// else if(editebook($_POST) == 'nothingupload'){
		// 	$nothingupload = true;
		// }
		else{
			echo mysqli_error($conn);
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="css/edit.css">
	<link rel="icon" href="../asset/imgBground/logo2.png" type="image/x-icon">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit</title>

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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark d-flex justify-content-between fixed-top">
	<a class="navbar-brand" href="<?= (isset($idadmin)) ? '../crud/?xx=admin' : '../crud/?xx=ebook' ?>" style="font-family: 'Oswald', sans-serif;">
		<i class="fas fa-chevron-left"> Kembali</i>
	</a>
</nav>
<!-- </NAV> -->

<!-- <Flash Message> -->
<?php if(isset($nothingupload)) : ?>
	<div class="alert alert-danger alert-dismissible" style="position: fixed; top: 56px; left: 0px; right: 0; z-index: 10000;">
		<button type="button" class="close" data-dismiss="alert">
			&times;
		</button>
		<strong>Tidak Ada yang Di UPDATE!</strong>
	</div>
<?php endif; ?>
<?php if(isset($sama)) : ?>
	<div class="alert alert-danger alert-dismissible" style="position: absolute; top: 52px; left: 0px; right:0; z-index: 10000;">
		<button type="button" class="close" data-dismiss="alert">
			&times;
		</button>
		<strong>Gagal!</strong> username sudah ada . . .
	</div>
<?php endif; ?>
<?php if(isset($bukanfoto)) : ?>
	<div class="alert alert-danger alert-dismissible" style="position: absolute; top: 52px; left: 0px; right:0; z-index: 10000;">
		<button type="button" class="close" data-dismiss="alert">
			&times;
		</button>
		<strong>Gagal!</strong> Yang Anda Masukan Bukan foto . . .
	</div>
<?php endif; ?>
<?php if(isset($oversize)) : ?>
	<div class="alert alert-danger alert-dismissible" style="position: absolute; top: 52px; left: 0px; right:0; z-index: 10000;">
		<button type="button" class="close" data-dismiss="alert">
			&times;
		</button>
		<strong>Gagal!</strong> Ukuran foto anda lebih dari 1 Mb . . .
	</div>
<?php endif; ?>
<?php if(isset($berhasil)) : ?>
	<div class="alert alert-success alert-dismissible" style="position: absolute; top: 52px; left: 0px; right:0; z-index: 10000;">
		<button type="button" class="close" data-dismiss="alert">
			&times;
		</button>
		<strong>Success!</strong> Data berhasil di Edit . . .
	</div>
<?php endif; ?>
<!-- </Flash Message> -->

<!-- <form ADMIN> -->
<?php if(isset($_GET["idadmin"])) : ?>
<section class="sec-one d-flex justify-content-center align-items-center" style="padding: 0px 30px 30px 30px">
	<div class="formEditAdmin">
		<form method="post" enctype="multipart/form-data">
			<input type="hidden" name="idadmin" value="<?= $dataadmin['id']; ?>">
			<input type="hidden" name="passwordLama" value="<?= $dataadmin['pasword']; ?>">
			<input type="hidden" name="fotolama" value="<?= $dataadmin['adminfoto']; ?>">
			<div class="form-group">
				<img src="../asset/imgAdmin/<?= $dataadmin['adminfoto']; ?>" width="100px" height="100px" style="margin: 0px 0px 10px 90px;">
				<input type="file" name="fotoadmin" class="form-control-file">
			</div>
			<div class="form-group">
				<label>Nama admin</label>
				<input type="text" name="adminnameBaru" value="<?= $dataadmin['adminname']; ?>" class="form-control" required autocomplete="off">
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="text" name="passwordBaru" value="<?= $dataadmin['pasword']; ?>" class="form-control" required autocomplete="off">
			</div>
			<div class="container-fluid">
				<button type="submit" name="editadmin" class="btn btn-primary w-100">kirim</button>
				<button type="submit" class="btn btn-success w-100 mt-2">refresh</button>
			</div>
		</form>
	</div>
</section>
<?php endif; ?>
<!-- </form ADMIN> -->

<!-- <form ebook> -->
<?php if(isset($_GET["idbuku"])) : ?>
<section class="sec-one" style="padding: 60px 30px 60px 30px">
	<div class="formEditEbook">
		<div class="peraturan">
			1. Maximal Foto adalah 1 Mb <br>
			2. Maximal ebook adalah 100 Mb <br>
			3. Tidak mengupload ebook yang sudah ada <br>
			4. Tidak mengupload foto yang tidak semestinya
			<span class="closee">X</span>
		</div>

		<form method="post" enctype="multipart/form-data">
			<input type="hidden" name="idbuku" value="<?= $dataebook['id']; ?>">
			<input type="hidden" name="fotolama" value="<?= $dataebook['fotobuku']; ?>">
			<input type="hidden" name="kategoriLama" value="<?= $dataebook['kategori']; ?>">
			<div class="form-group">
				<img src="../asset/imgEbook/<?= $dataebook['fotobuku']; ?>" width="120px" height="150px">
				<input type="file" name="fotobuku" class="form-control-file mt-3">
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="judul-buku">Judul Buku</label>
					<input type="text" name="judulbukuBaru" class="form-control" id="judul-buku" value="<?= $dataebook['judulbuku']; ?>">
				</div>
				<div class="form-group col-md-6">
					<label for="nama-penulis">Nama Penulis</label>
					<input type="text" name="penulisBaru" class="form-control" id="nama-penulis" value="<?= $dataebook['penulis']; ?>">
				</div>
			</div>
			<div class="form-row">
			<div class="form-group col-md-6">
				<label for="nama-penerbit">Nama penerbit</label>
				<input type="text" name="penerbitBaru" class="form-control" id="nama-penerbit" value="<?= $dataebook['penerbit']; ?>">
			</div>
			<div class="form-group col-md-6">
				<label for="tahun-terbit">Tanggal Terbit</label>
				<input type="text" name="tglterbitBaru" class="form-control" id="tahun-terbit" value="<?= $dataebook['tglterbit']; ?>">
			</div>
			</div>
			<div class="form-row">
			<div class="form-group col-md-6">
				<label>upload file</label>
				<input type="file" name="fileebook" class="form-control-file" disabled>
			</div>
			<div class="form-group col-md-6">
				<label>pilih kategori</label>
				<select class="form-control form-control-sm" name="kategoriBaru" value="<?= $dataebook['kategori']; ?>">
					<option selected disabled hidden><?= $dataebook['kategori']; ?></option>
					<option>Novel</option>
					<option>Resep Makanan</option>
					<option>Buku Anak</option>
					<option>Komik</option>
					<option>Buku Islam</option>
					<option>Ilmu Pengetahuan</option>
				</select>
			</div>
			</div>
			<div class="form-group">
				<label for="comment">Sinopsis</label>
				<textarea class="form-control" rows="3" id="comment" name="sinopsisBaru"><?= $dataebook['sinopsis']; ?></textarea>
			</div>
			<div class="d-flex justify-content-end">
				<button type="submit" class="btn btn-success">refresh</button>
				<button type="submit" name="editebook" class="btn btn-primary ml-3">kirim</button>
			</div>
		</form>
	</div>
</section>
<?php endif; ?>
<!-- </form ebook> -->

	<!-- <footer> -->
	<footer class="footerCrud">
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
	<script src="../js/edit.js"></script>
</body>
</html>
