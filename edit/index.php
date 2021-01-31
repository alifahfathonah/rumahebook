<?php 
	require '../method/function.php';
	global $conn;

	// ----------------------------
	// 			session 
	// ----------------------------
	session_start();
	if(!isset($_SESSION["admin"])){
		header("location:../login");
		exit;
	}
	
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
	// 			edit admin
	// ----------------------------
	if(isset($_GET["idadmin"])){
		$idadmin  = $_GET["idadmin"];
		$dataadmin = tampil("SELECT*FROM admin WHERE id='$idadmin'")[0];
	}
	if(isset($_POST["editadmin"])){
		if(editadmin($_POST) > 0)
		{
			$success = true;
			$pesan = 'Admin berhasil diedit';
		}
		else if(editadmin($_POST) == 'sama')
		{
			$error = true;
			$pesan = 'Nama sudak dipakai';
		}
		else if(editadmin($_POST) == 'bukanfoto')
		{
			$error = true;
			$pesan = 'Yang anda upload bukan foto';
		}
		else if(editadmin($_POST) == 'oversize')
		{
			$error = true;
			$pesan = 'Ukuran foto terlalu besar';
		}
		else if(editadmin($_POST) == 'nothingupload')
		{
			$error = true;
			$pesan = 'Tidak ada admin yang diedit';
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
			$success = true;
			$pesan = 'Ebook berhasil di edit';
		}
		else if(editebook($_POST) == 'sama'){
			$error = true;
			$pesan = 'Tidak ada ebook yang diedit';
		}
		else if(editebook($_POST) == 'bukanfoto'){
			$error = true;
			$pesan = 'Yang anda upload bukan foto';
		}
		else if(editebook($_POST) == 'oversize'){
			$error = true;
			$pesan = 'Ukuran foto lebih dari 1mb';
		}
		else{
			echo mysqli_error($conn);
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="icon" href="../asset/imgBground/logo2.png" type="image/x-icon">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit</title>

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
		.peraturan{
			z-index: -1;
			opacity: 0;
		}
		.peraturan.rise{
			z-index: 10000;
			animation: peraturanRise 0.5s 0.5s forwards;
		}
		@keyframes peraturanRise{
			to{
				opacity: 1;
			}
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
	</style>
</head>
<body>

	<!-- alert -->
	<?php if(isset($success)) : ?>
	<div class="alert alert-success alert-dismissible" style="position: fixed; top: 56px; left: 0px; right: 0; z-index: 10000;">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Berhasil!</strong> <?= $pesan; ?>
	</div>
	<?php endif; ?>
	<?php if(isset($error)) : ?>
	<div class="alert alert-danger alert-dismissible" style="position: fixed; top: 56px; left: 0px; right: 0; z-index: 10000;">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Gagal!</strong> <?= $pesan; ?>
	</div>
	<?php endif; ?><!-- alert -->

	<!-- NAV -->
	<nav class="navbar px-3" style="background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 6px );-webkit-backdrop-filter: blur( 6px );">
		<button onclick="goBack()" class="navbar-brand font-weight-bold btn btn-info p-2 d-flex align-items-center justify-content-center">
			<img src="../asset/imgBground/back.svg" width="24px">
		</button>
		<!-- <a href="<?= (isset($idadmin)) ? '../crud/?xx=admin' : '../crud/?xx=ebook' ?>" class="navbar-brand font-weight-bold btn btn-info p-2 d-flex align-items-center justify-content-center">
			<img src="../asset/imgBground/back.svg" width="24px">
		</a> -->
	</nav>
	<!-- </NAV> -->
	
	<!-- main-content -->
	<div class="position-relative container-fluid d-flex justify-content-center align-items-center" style="min-height: 93.6vh;">
	
		<!-- <form ADMIN> -->
		<?php if(isset($_GET["idadmin"])) : ?>
		<div class="container-fluid row d-flex justify-content-center py-4">
			<form method="post" enctype="multipart/form-data" class="col-lg-7 col-xl-6 rounded-lg" style="overflow: hidden;background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 6px );-webkit-backdrop-filter: blur( 6px );">	
				<input type="hidden" name="idadmin" value="<?= $dataadmin['id']; ?>">
				<input type="hidden" name="passwordLama" value="<?= $dataadmin['pasword']; ?>">
				<input type="hidden" name="fotolama" value="<?= $dataadmin['adminfoto']; ?>">
				<div id="formWraper" class="row h-100">
					<!-- foto-preview -->
					<div class="col-sm-5 p-3 d-flex flex-column align-items-center">
						<img src="../asset/imgAdmin/<?= $dataadmin['adminfoto']; ?>" width="100%" height="" style="max-width:190px" class="img-thumbnail">
						<input type="file" name="fotoadmin" class="form-control-file mt-3">
					</div>
					<!-- data -->
					<div class="col p-3">
						<div class="form-group">
							<label>Nama</label>
							<input type="text" name="adminnameBaru" value="<?= $dataadmin['adminname']; ?>" class="form-control" required autocomplete="off">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="text" name="passwordBaru" value="<?= $dataadmin['pasword']; ?>" class="form-control" required autocomplete="off">
						</div>
						<div class="mt-4 d-flex justify-content-end"> 
							<button type="submit" name="editadmin" class="btn btn-primary" style=" letter-spacing: 2px;">submit</button>
							<button type="submit" class="btn btn-success ml-3" style=" letter-spacing: 2px;">refresh</button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<?php endif; ?><!-- </form ADMIN> -->

		<!-- </form EBOOK> -->
		<?php if(isset($_GET["idbuku"])) : ?>
		<div class="container-fluid row d-flex justify-content-center py-4">
			<div class="col-sm-11 col-md-10 col-lg-9 col-xl-8 p-3 rounded-lg" style="overflow: hidden;background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 6px );-webkit-backdrop-filter: blur( 6px );">	
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
						<div class="form-group col-md-6">
							<?php if(!$dataebook['linkgdrive'] == '') : ?>
							<label>Link GDrive</label>
							<input type="text" name="linkgdrive" class="form-control form-control-sm" value="<?= $dataebook['linkgdrive']; ?>">
							<?php else : ?>
							<label>File</label>
							<input type="file" name="fileebook" class="form-control-file" disabled>
							<?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="comment">Sinopsis</label>
						<textarea class="form-control" rows="3" id="comment" name="sinopsisBaru"><?= $dataebook['sinopsis']; ?></textarea>
					</div>
					<div class="d-flex justify-content-end">
						<button type="submit" class="btn btn-success" style="letter-spacing: 2px;">refresh</button>
						<button type="submit" name="editebook" class="btn btn-primary ml-3" style="letter-spacing: 2px;">kirim</button>
					</div>
				</form>
			</div>
		</div><!-- </form EBOOK> -->
		<?php endif; ?>
	    
		<!-- Modal peraturan -->
		<div class="peraturan d-flex justify-content-center align-items-center" style="position: absolute;top: 0;bottom: 0;left: 0;right: 0; background-color:rgba(0,0,0,0.3);">
			<div class="container row d-flex justify-content-center">
				<div class="col-lg-7 col-xl-6 rounded-lg position-relative p-4" style="overflow: hidden;background: rgba( 255, 0, 0, 0.6 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 6px );-webkit-backdrop-filter: blur( 6px );">	
					<h4 class="text-center text-light">PERATURAN :</h4>
					<ol class="text-light mt-4">
						<li>Ekstensi foto : jpg, jpeg, png</li>
						<li>Ekstensi ebook : pdf</li>
						<li>Max size foto 1 mb</li>
						<li>Max size ebook 10 mb <br>*kecuali link Google Drive</li>
					</ol>
					<button type="button" class="close" style="position: absolute; top: 0px; right: 8px; font-size: 40px;" onclick="closePeraturan();">&times;</button>
				</div>
			</div>
		</div><!-- Modal peraturan -->
		
	</div><!-- main-content -->


	<!---------------------- js ---------------------->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script><script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script>
		//  go back
		function goBack() {
			window.history.back();
		}
		// open peraturen
		setTimeout(() => {
			document.querySelector('.peraturan').classList.add('rise');
			document.body.style.overflow = 'hidden';
		}, 1000);
		function closePeraturan(){
			document.querySelector('.peraturan').classList.remove('rise');
			document.body.style.overflow = 'inherit';
		}
	</script>
</body>
</html>
