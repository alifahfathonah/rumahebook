<?php 
	require '../method/function.php';

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
		$stroke = '393939'; 
	}else{
		$warna = '393939';
		$stroke = 'E9E9E9'; 
	}
	
	// ----------------------------
	// $_GET['xx']
	// ----------------------------
	$xx = $_GET['xx'];
	// ambil data kritik
	if($xx == 'kritik'){
		$tableJudul = 'Tabel Kritik';
		$kritik1 = tampil("SELECT*FROM kritik ORDER BY id DESC");
	}
	// ambil data admin
	if($xx == 'admin'){
		$tableJudul = 'Tabel Admin';
		$alladmin = tampil("SELECT*FROM admin ORDER BY id DESC");
	}
	// ambil data ebook
	if($xx == 'ebook'){
		$tableJudul = 'Tabel Ebook';
		$ebook = tampil("SELECT*FROM ebook ORDER BY id DESC");
	}

	// ----------------------------
	// ambil nama uploader
	// ----------------------------
	$idNama = $_COOKIE["nameIdAdmin"];
	$uploader  = tampil("SELECT adminname FROM admin WHERE id='$idNama'")[0]['adminname'];
	
	// ----------------------------
	// 		Tambah Admin 
	// ----------------------------
	if(isset($_POST["daftaradmin"])){
		if(daftaradmin($_POST) > 0){
			$success = true;
			$pesan = 'Admin berhasil ditambahkan';
		}
		else if(daftaradmin($_POST) == 'sama'){
			$error = true;
			$pesan = 'Nama sudah dipakai';
		}
		else if(daftaradmin($_POST) == 'salah'){
			$error = true;
			$pesan = 'Tulis ulang password dengan benar';
		}
		else{
			echo mysqli_error($conn);
		}
	}

	// ----------------------------
	// 		upload ebook 
	// ----------------------------
	if(isset($_POST["upload"])){
		if(upload($_POST) > 0){
			$success = true;
			$pesan = 'Ebook berhasil ditambahkan';
		}
		else if(upload($_POST) == 'bukanebook'){
			$error = true;
			$pesan = 'Yang anda upload bukan ebook';
		}
		else if(upload($_POST) == 'bukuoversize'){
			$error = true;
			$pesan = 'Ukuran ebook lebih dari 10mb';
		}
		else if(upload($_POST) == 'bukanfoto'){
			$error = true;
			$pesan = 'Yang anda upload bukan foto';
		}
		else if(upload($_POST) == 'oversize'){
			$error = true;
			$pesan = 'Ukuran foto terlalu besar';
		}
		else{
			echo mysqli_error($conn);
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../asset/imgBground/logo2.png" type="image/x-icon">
	<meta charset="UTF-8">
	<title>Halaman Admin</title>

	<!------------------------------------ CSS ------------------------------------>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Indie+Flower&family=Merienda+One&family=Oswald:wght@300&family=Permanent+Marker&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<style>
		body{
			background-image     : url(../asset/imgBground/<?= $getWaktu['bgBesar']; ?>);
			background-size      : cover;
			background-repeat    : no-repeat;
			background-attachment: fixed;
		}
		#header{
			padding: 0 16px;
		}
		h1.tabelJudul,#kalender h1{
			font-size: 70px;
		}
		#kalender p{
			font-size: 40px;
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
		/* ///////////////////////////////////////////////// */
		@media(max-width: 1140px){
			#header{
				margin: 20px 0;
			}
			#kalender h1{
				font-size: 7vw;
			}
			#kalender p{
				font-size: 2vw;
			}
		}
		@media(max-width: 768px){
			body{
				background-image     : url(../asset/imgBground/<?= $getWaktu['bgKecil']; ?>);
				background-size      : cover;
				background-repeat    : no-repeat;
				background-attachment: fixed;
			}
			h1.tabelJudul,#kalender h1{
				font-size: 70px;
			}
			#kalender p{
				font-size: 30px;
			}
			#footer{
				margin-top: 60px;
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
			#kalender{
				margin: 20px 0 12px 0;
			}
			h1.tabelJudul,#kalender h1{
				font-size: 40px;
			}
			h3.sapa,#kalender p{
				font-size: 20px;
				margin: 10px 0 0 0;
			}
		}
	</style>
</head>
<body>

	<!-- alert -->
	<?php if(isset($success)) : ?>
	<div class="alert alert-success alert-dismissible" style="position: fixed; top: 56px; left: 0px; right: 0; z-index: 10000;">
		<button type="button" class="close" data-dismiss="alert" onclick="window.location.href = '';">&times;</button>
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
	<nav class="navbar fixed-top px-3" style="background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 6px );-webkit-backdrop-filter: blur( 6px );">
		<button onclick="goBack()" class="navbar-brand font-weight-bold btn btn-info d-flex align-items-center justify-content-center">
			<img src="../asset/imgBground/home.svg" width="30px">
		</button>
	</nav><!-- </NAV> -->

	<!-- main-content -->
	<div class="position-relative container-fluid px-3" style="padding: 80px 0;min-height:100vh">

		<!-- header -->
		<div id="header" class="w-full row m-0 p-0" style="display: flex;align-items: center;">
			<div class="col p-0 d-flex justify-content-center align-items-center" style="color: #<?= $warna; ?>;">
				<h1 class="tabelJudul" style="-webkit-text-stroke-width: 1px;-webkit-text-stroke-color: #<?= $stroke; ?>;font-weight: bolder;font-family: 'Oswald', sans-serif;letter-spacing: 1px;"><?= $tableJudul; ?></h1>
			</div>
			<div id="kalender" class="col-3 col-sm-3 col-md-3 col-lg-2 col-xl-2 p-0 bg-warning rounded-lg position-relative" style="box-shadow: 4px 4px 6px 0px rgba(0,0,0,0.6); min-width: 100px;">
				<img src="../asset/imgAdmin/gambardefault.jpg" width="100%" style="opacity: 0;">
				<div style="position: absolute; top:0; bottom:0; left:0; right:0;" class="d-flex flex-column justify-content-center align-items-center">
					<h1 class="k1" style="font-family: 'Permanent Marker', cursive;">
						<?= $getWaktu['kalender1']; ?></h1>
					<p class="k2" style="font-family: 'Oswald', sans-serif;">
						<?= $getWaktu['kalender2']; ?></p>
				</div>
			</div>
		</div><!-- header -->

		<!-- All-tabel -->
		<div class="w-full container-fluid mx-0 mt-5 px-0 d-flex justify-content-around align-items-start">
			
			<!-- tabel kritik-->
			<?php if($tableJudul == 'Tabel Kritik') : ?>
			<div class="container-fluid p-0" style="overflow: auto; max-height: 380px;">
			<table class="table m-0" style="background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 6px );-webkit-backdrop-filter: blur( 6px );">
				<thead class="thead-dark text-center">
					<tr>
						<th scope="col">ID</th>
						<th scope="col" style="min-width: 180px;">Kritikus</th>
						<th scope="col" style="min-width: 140px;">Tanggal</th>
						<th scope="col" style="min-width: 160px;">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; ?>
					<?php foreach($kritik1 as $kritik2) : ?>
					<tr class="text-center">
						<th class="align-middle"><?= $i++; ?></th>
						<td class="align-middle"><?= $kritik2['nama']; ?></td>
						<td class="align-middle"><?= $kritik2['tglkritik']; ?></td>
						<td>
							<a href="" data-toggle="modal" data-target="#ModalPesanKritik" onclick="modalPesanKritik('<?= $kritik2['pesan']; ?>');" class="btn btn-info pt-1 pl-2 pr-2 pb-0">
								<img src="../asset/imgBground/eye.svg" width="32px"></i></a></a>
							<a href="../method/delete.php?xx=<?= $kritik2['id']; ?>&table=kritik&colom=id" onclick="return confirm('Anda Yakin Ingin Menghapus');" class="btn btn-danger ml-2 pt-2 pl-3 pr-3 pb-0">
								<img src="../asset/imgBground/delete.svg" width="24px"></i></a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			</div>
			<?php endif; ?><!-- tabel kritik-->

			<!-- <tabel admin> -->
			<?php if($tableJudul == 'Tabel Admin') : ?>
			<div class="container-fluid h-100 p-0">
				<div class="row mx-0 mb-3" style="height:8.6%;">
					<div class="col p-0">
						<input type="text" class="form-control w-100" placeholder="&#xF002; search" style="font-family:Arial, FontAwesome; border-radius: 20px;" id="SearchAdmin">
					</div>
					<div class="col-3 col-sm-3 col-md-2 col-lg-2 col-xl-1 pr-0">
						<a href="" class="btn btn-success" style="display:block;" data-toggle="modal" data-target="#ModalTambahAdmin">
							<img src="../asset/imgBground/plus.svg" width="24px">
						</a>
					</div>
				</div>
				<div class="row mx-0" style="max-height:380px;overflow: auto;" id="div-tabel-admin">
					<table class="table m-0" style="background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 6px );-webkit-backdrop-filter: blur( 6px );">
						<thead class="thead-dark text-center">
							<tr>
								<th scope="col">No</th>
								<th scope="col">Foto</th>
								<th scope="col" style="min-width: 180px;">Username</th>
								<th scope="col" style="min-width: 160px;">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach($alladmin as $alladmin2) : ?>
							<tr class="text-center">
								<th class="align-middle"><?= $i++; ?></th>
								<th><img src="../asset/imgAdmin/<?= $alladmin2['adminfoto']; ?>" title="<?= $alladmin2['adminname']; ?>" width="100px" height="100px" id="adminfoto"></th>
								<td class="align-middle"><?= $alladmin2['adminname']; ?></td>
								<td class="align-middle">
									<a href="../edit/?idadmin=<?= $alladmin2['id']; ?>" class="btn btn-warning pt-2 pl-3 pr-3 pb-1">
										<img src="../asset/imgBground/edit.svg" width="24px"></i></a>
									<a href="../method/delete.php?xx=<?= $alladmin2['id']; ?> & table=admin & colom=id" onclick="return confirm('yakin ingin menghapus?');" class="btn btn-danger ml-2 pt-2 pl-3 pr-3 pb-0">
										<img src="../asset/imgBground/delete.svg" width="24px"></i></a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php endif; ?><!-- <tabel admin> -->

			<!-- <tabel ebook> -->
			<?php if($tableJudul == 'Tabel Ebook') : ?>
			<div class="container-fluid h-100 p-0">
				<div class="row mx-0 mb-3" style="height:8.6%;">
					<div class="col p-0">
						<input type="text" class="form-control w-100" placeholder="&#xF002; search" style="font-family:Arial, FontAwesome; border-radius: 20px;" id="SearchEbook">
					</div>
					<div class="col-3 col-sm-3 col-md-2 col-lg-2 col-xl-1 pr-0">
						<a href="" class="btn btn-success" style="display:block;" data-toggle="modal" data-target="#ModalTambahEbook" onclick="peraturan();">
							<img src="../asset/imgBground/plus.svg" width="24px" onclick="peraturan();">
						</a>
					</div>
				</div>
				<div class="row mx-0" style="max-height:380px;overflow: auto;" id="div-tabel-ebook">
					<table class="table m-0" style="background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 6px );-webkit-backdrop-filter: blur( 6px );">
						<thead class="thead-dark text-center">
							<tr>
								<th scope="col">Foto</th>
								<th scope="col" style="min-width: 200px;">Judul</th>
								<th scope="col" style="min-width: 160px;">Kategori</th>
								<th scope="col" style="min-width: 160px;">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($ebook as $eb) : ?>
							<tr class="text-center">
								<th><img src="../asset/imgEbook/<?= $eb['fotobuku']; ?>" title="<?= $eb['judulbuku']; ?>" width="100px" height="120px" id="ebookfoto"></th>
								<th class="align-middle"><?= $eb['judulbuku']; ?></th>
								<td class="align-middle"><?= $eb['kategori']; ?></td>
								<td class="align-middle">
									<a href="../edit/?idbuku=<?= $eb['id']; ?>" class="btn btn-warning pt-2 pl-3 pr-3 pb-1">
										<img src="../asset/imgBground/edit.svg" width="24px"></i></a>
									<a href="../method/delete.php?xx=<?= $eb['judulbuku']; ?> & table=ebook & colom=judulbuku" class="btn btn-danger ml-2 pt-2 pl-3 pr-3 pb-0" onclick="return confirm('yakin ingin menghapus?');">
										<img src="../asset/imgBground/delete.svg" width="24px"></i></a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php endif; ?><!-- <tabel ebook> -->
			
		</div><!-- All-tabel -->

		<!-- <Modal Pesan Kritik> -->
		<div class="modal fade" id="ModalPesanKritik" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Pesan</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body"></div>
					<div class="modal-footer"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></div>
				</div>
			</div>
		</div><!-- </Modal Pesan Kritik> -->

		<!-- <Modal Tambah Admin> -->
		<div class="modal fade" id="ModalTambahAdmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<form method="post" class="container-fluid row m-0">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Tambah Admin</h5>
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<input type="text" name="adminname" class="form-control" placeholder="username" required>
							</div>
							<div class="form-group">
								<input type="password" name="password" class="form-control" placeholder="password" required>
							</div>
							<div class="form-group">
								<input type="password" name="retype" class="form-control" placeholder="retype password" required>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-info" name="daftaradmin">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div><!-- </Modal Tambah Admin> -->

		<!-- <Modal Tambah ebook> -->
		<div class="modal fade" id="ModalTambahEbook" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow: hidden;">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="z-index: 20;">

				<form method="post" enctype="multipart/form-data" class="container-fluid row m-0">
				<div class="modal-content">
					<div class="modal-header d-flex align-items-center">
						<h5 class="modal-title" id="exampleModalLabel">Tambah Ebook</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body pt-3 pl-3 pr-3 pb-0">
						<input type="hidden" name="uploader" value="<?php echo $uploader; ?>">
						<div class="form-group">
							<img src="../asset/imgEbook/gambardaefault.png" width="120px" height="150px" style="margin: 0px 0px 10px 0px;">
							<input type="file" name="fotobuku" style="width: 300px;" class="form-control-file form-control-sm">
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="judul-buku">Judul Buku</label>
								<input type="text" name="judulbuku" class="form-control form-control-sm" id="judul-buku" required>
							</div>
							<div class="form-group col-md-6">
								<label for="nama-penulis">Nama Penulis</label>
								<input type="text" name="penulis" class="form-control form-control-sm" id="nama-penulis" required>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="nama-penerbit">Nama penerbit</label>
								<input type="text" name="penerbit" class="form-control form-control-sm" id="nama-penerbit" value="----">
							</div>
							<div class="form-group col-md-6">
								<label for="tahun-terbit">Tanggal Terbit</label>
								<input type="text" name="tglterbit" class="form-control form-control-sm" id="tahun-terbit" value="----">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-lg-6">
								<label>Pilih Kategori</label>
								<select class="form-control form-control-sm" name="kategori" required>
									<option selected disabled hidden>-- Pilih Kategori --</option>
									<option>Novel</option>
									<option>Resep Makanan</option>
									<option>Buku Anak</option>
									<option>Komik</option>
									<option>Buku Islam</option>
									<option>Ilmu Pengetahuan</option>
								</select>
							</div>
							<div class="form-group col-lg-6">
								<label for="radio-gdrive" onclick="radioGdrive();">Link GDrive
								<input type="radio" id="radio-gdrive" name="radio" value="radio-gdrive" checked></label>
								<label for="radio-upload" onclick="radioUpload();" class="ml-3">Upload biasa
								<input type="radio" id="radio-upload" name="radio" value="radio-upload"></label>
								<span id="span-input-file-ebook"><input type="text" name="linkgdrive" class="form-control form-control-sm" placeholder="masukan link gdrive" required></span>
							</div>
						</div>
						<div class="form-group">
							<label for="comment">Sinopsis</label>
							<textarea class="form-control" rows="3" id="comment" name="sinopsis"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<button type="submit" name="upload" class="btn btn-info">Submit</button>
					</div>
				</div>
				</form>
			</div>
		</div><!-- </Modal Tambah ebook> -->
		
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


		<!-- footer -->
		<footer class="fixed-bottom m-0 px-3" style="background: linear-gradient(to bottom, rgba(255, 255, 255, 0.0) 10%, black 98%);display: flex;align-items: center;justify-content: space-between;"><!-- " default pb-2 " -->
			<span class="text-light" style="word-spacing: 2px;">Made With <img src="../asset/imgBground/love.svg" width="30px" style="transform: translateY(-2px);"> by <a href="https://www.instagram.com/el.koro_/" target="_blank" style="text-decoration: none; font-weight: 500;"><i class="fas fa-at"></i>Bagaskoro</a>
			</span>
			<span class="text-light"><img src="../asset/imgBground/pin.svg" width="30px" style="transform: translateY(-4px);">  South Tangerang, Indonesia</span>
		</footer><!-- footer -->

	</div><!-- main-content -->
	
	<!---------------------- js ---------------------->
	<script src="https://kit.fontawesome.com/6357e7545a.js" crossorigin="anonymous"></script><script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script><script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script>
		//  go back
		function goBack() {
			window.history.back();
		}
		// ------------------------
		// Modal Pesan Kritik
		// ------------------------
		function modalPesanKritik(pesan){
			document.querySelector('div#ModalPesanKritik .modal-body').innerHTML = `"${pesan}"`;
		}
		// ------------------
		// alert peraturan
		// ------------------
		let spanInputFileEbook = '';
		function peraturan(){
			document.querySelector('.peraturan').classList.add('rise');
			document.querySelector('#ModalTambahEbook').style.overflow = 'hidden';
			spanInputFileEbook = document.querySelector('span#span-input-file-ebook');
		}
		function closePeraturan(){
			document.querySelector('.peraturan').classList.remove('rise');
			document.querySelector('#ModalTambahEbook').style.overflow = 'auto';
		}
		// ------------------------
		// radio btn upload
		// ------------------------
		function radioGdrive(){
			let el = `<input type="text" name="linkgdrive" class="form-control form-control-sm" placeholder="masukan link gdrive" required>`;
			spanInputFileEbook.innerHTML = el;
		}
		function radioUpload(){
			let el = `<input type="file" name="fileebook" class="form-control-file" required>`;
			spanInputFileEbook.innerHTML = el;
		}
		let searchAdmin = document.getElementById('SearchAdmin');
		if(searchAdmin){
			let divTabelAdmin = document.getElementById('div-tabel-admin');
			searchAdmin.addEventListener('keyup', function () {
				let xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function () {
					if (xhr.readyState == 4 && xhr.status == 200) {
						divTabelAdmin.innerHTML = xhr.responseText;
					}
				}
				xhr.open('GET', '../ajax/tabeladmin.php?key=' + searchAdmin.value, true);
				xhr.send();
			})
		}
		let searchEbook = document.getElementById('SearchEbook');
		if(searchEbook){
			let divTabelEbook = document.getElementById('div-tabel-ebook');
			searchEbook.addEventListener('keyup', function () {
				let xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function () {
					if (xhr.readyState == 4 && xhr.status == 200) {
						divTabelEbook.innerHTML = xhr.responseText;
					}
				}
				xhr.open('GET', '../ajax/tabelebook.php?key=' + searchEbook.value, true);
				xhr.send();
			})
		}
	</script>
</body>
</html>