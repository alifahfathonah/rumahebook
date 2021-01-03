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
	// 			session 
	// ----------------------------
	session_start();
	if(!isset($_SESSION["admin"])){
		header("location:../login");
		exit;
	}

	// ambil $_GET['xx']
	$xx = $_GET['xx'];
	// ambil data kritik
	if($xx == 'kritik'){
		$tableKritik = true;
		$kritik1 = tampil("SELECT*FROM kritik ORDER BY id DESC");
	}
	// ambil data admin
	if($xx == 'admin'){
		$tableAdmin = true;
		$alladmin = tampil("SELECT*FROM admin ORDER BY id DESC");
	}
	// ambil data ebook
	if($xx == 'ebook'){
		$tableEbook = true;
		$ebook = tampil("SELECT*FROM ebook ORDER BY id DESC");
	}
	// ambil nama uploader
	$idNama = $_COOKIE["nameIdAdmin"];
	$uploader  = tampil("SELECT adminname FROM admin WHERE id='$idNama'")[0]['adminname'];
	// var_dump($uploader);
	// echo $uploader;
	
	// ----------------------------
	// 		Tambah Admin 
	// ----------------------------
	if(isset($_POST["daftaradmin"])){
		if(daftaradmin($_POST) > 0){
			$adminBerhasil = true;
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

	// ----------------------------
	// 		upload ebook 
	// ----------------------------
	if(isset($_POST["upload"])){
		// var_dump($_POST);
		// var_dump($_FILES);
		// die;
		if(upload($_POST) > 0){
			$ebookBerhasil = true;
		}
		else if(upload($_POST) == 'bukanebook'){
			$bukanebook = true;
		}
		else if(upload($_POST) == 'bukuoversize'){
			$bukuoversize = true;
		}
		else if(upload($_POST) == 'bukanfoto'){
			$bukanfoto = true;
		}
		else if(upload($_POST) == 'oversize'){
			$oversize = true;
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
<!-- <Flash Message> -->
<?php if(isset($salah)) : ?>
	<div class="alert alert-danger alert-dismissible" style="position: fixed; top: 56px; left: 0px; right: 0; z-index: 10000;">
		<button type="button" class="close" data-dismiss="alert">
			&times;
		</button>
		<strong>Gagal!</strong> Tulis ulang password dengan benar
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
<?php if(isset($adminBerhasil)) : ?>
	<div class="alert alert-success alert-dismissible" style="position: absolute; top: 52px; left: 0px; right:0; z-index: 10000;">
		<button type="button" class="close" data-dismiss="alert" onclick="window.location.href = '../crud/?xx=admin';">
			&times;
		</button>
		<strong>Success!</strong> Data berhasil di tambah
	</div>
<?php endif; ?>
<?php if(isset($ebookBerhasil)) : ?>
	<div class="alert alert-success alert-dismissible" style="position: absolute; top: 52px; left: 0px; right:0; z-index: 10000;">
		<button type="button" class="close" data-dismiss="alert" onclick="window.location.href = '../crud/?xx=ebook';">
			&times;
		</button>
		<strong>Success!</strong> Data berhasil di tambah
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
<?php if(isset($bukanebook)) : ?>
	<div class="alert alert-danger alert-dismissible" style="position: absolute; top: 52px; left: 0px; right:0; z-index: 10000;">
		<button type="button" class="close" data-dismiss="alert">
			&times;
		</button>
		<strong>Gagal!</strong> yang Anda upload bukan Ebook . . .
	</div>
<?php endif; ?>
<?php if(isset($oversize)) : ?>
	<div class="alert alert-danger alert-dismissible" style="position: absolute; top: 52px; left: 0px; right:0; z-index: 10000;">
		<button type="button" class="close" data-dismiss="alert">
			&times;
		</button>
		<strong>Gagal!</strong> Ukuran foto Anda lebih dari 1 Mb . . .
	</div>
<?php endif; ?>
<?php if(isset($bukuoversize)) : ?>
	<div class="alert alert-danger alert-dismissible" style="position: absolute; top: 52px; left: 0px; right:0; z-index: 10000;">
		<button type="button" class="close" data-dismiss="alert">
			&times;
		</button>
		<strong>Gagal!</strong> Ukuran Ebook anda lebih dari 100 Mb . . .
	</div>
<?php endif; ?>
<!-- </Flash Message> -->

<!-- <crud-kritik> -->
<?php if(isset($tableKritik)) : ?>
	<!-- <NAV> -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark d-flex justify-content-between">
		<a class="navbar-brand" href="../admin/" style="font-family: 'Oswald', sans-serif;">
			<i class="fas fa-house-user" style="font-size: 17px;"> Beranda</i> 
		</a>
	</nav>
	<!-- </NAV> -->

	<div class="NtblKalender">
	<!-- SAPA -->
		<div class="divSapa">
			<h1 class="NamaTbl">Table <?= $xx; ?></h1>
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

	<div class="container-fluid">
		<div id="div-tabel" style="overflow: auto;">
		<table class="table table-bordered table-hover">
			<thead class="thead-dark text-center">
				<tr>
					<th scope="col">
						ID
					</th>
					<th scope="col" style="min-width: 180px;">
						Kritikus
					</th>
					<th scope="col" style="min-width: 140px;">
						Tanggal
					</th>
					<th scope="col" style="min-width: 120px;">
						Aksi
					</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1; ?>
				<?php foreach($kritik1 as $kritik2) : ?>
				<tr class="text-center" style="background-color: rgba(255, 255, 255, 0.5);">
					<th>
						<?= $i++; ?>
					</th>
					<td>
						<?= $kritik2['nama']; ?>
					</td>
					<td>
						<?= $kritik2['tglkritik']; ?>
					</td>
					<td>
						<a href="" data-toggle="modal" data-target="#Modal<?= $kritik2['id']; ?>" class="btn btn-info">
							<i class="far fa-eye"></i>
						</a>
						<a href="../method/delete.php?xx=<?= $kritik2['tglkritik']; ?> & table=kritik & colom=tglkritik" onclick="return confirm('Anda Yakin Ingin Menghapus');"
						class="btn btn-danger">
							<i class="fas fa-trash-alt"></i>
						</a>
						<!-- <Modal Pesan> -->
						<div class="modal fade" id="Modal<?= $kritik2['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Pesan</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<?= $kritik2['pesan']; ?>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
						<!-- </Modal Pesan> -->
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		</div>
	</div>
<?php endif; ?>
<!-- </crud-kritik> -->

<!-- <crud-admin> -->
<?php if(isset($tableAdmin)) : ?>
	<!-- <NAV> -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark d-flex justify-content-between">
		<a class="navbar-brand" href="../admin/" style="font-family: 'Oswald', sans-serif;">
			<i class="fas fa-house-user" style="font-size: 17px;"> Beranda</i> 
		</a>
		
		<a class="btn btn-success" href="" data-toggle="modal" data-target="#ModalTambahAdmin">
			<i class="fas fa-plus"></i>
		</a>
	</nav>
	<!-- </NAV> -->

	<div class="NtblKalender">
		<!-- SAPA -->
		<div class="divSapa">
			<h1 class="NamaTbl">Table <?= $xx; ?></h1>
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

	<div class="container-fluid">
		<form>
			<div class="form-group w-100">
				<input type="text" class="form-control w-100" id="SearchAdmin" placeholder="&#xF002; search" style="font-family:Arial, FontAwesome;">
			</div>
		</form>
		<div id="div-tabel-admin" style="overflow: auto;">
		<table class="table table-bordered table-hover">
			<thead class="thead-dark text-center">
				<tr>
					<th scope="col">
						No
					</th>
					<th scope="col">
						Foto
					</th>
					<th scope="col" style="min-width: 180px;">
						Username
					</th>
					<th scope="col" style="min-width: 120px;">
						Aksi
					</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1; ?>
				<?php foreach($alladmin as $alladmin2) : ?>
				<tr class="text-center" style="background-color: rgba(255, 255, 255, 0.5);">
					<th class="align-middle">
						<?= $i++; ?>
					</th>
					<th>
						<img src="../asset/imgAdmin/<?= $alladmin2['adminfoto']; ?>" title="<?= $alladmin2['adminname']; ?>" width="100px" height="100px" id="adminfoto">
					</th>
					<td class="align-middle">
						<?= $alladmin2['adminname']; ?>
					</td>
					<td class="align-middle">
						<a href="../edit/?idadmin=<?= $alladmin2['id']; ?>" class="btn btn-warning">
							<i class="fas fa-edit"></i>
						</a>
						<a href="../method/delete.php?xx=<?= $alladmin2['id']; ?> & table=admin & colom=id" onclick="return confirm('yakin ingin menghapus?');" class="btn btn-danger">
							<i class="fas fa-trash-alt"></i>
						</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		</div>
	</div>

	<!-- <Modal Tambah Admin> -->
	<div class="modal fade" id="ModalTambahAdmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form method="post">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Tambah Admin</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
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
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" name="daftaradmin" class="btn btn-info">Submit</button>
				</div>
			</div>
			</form>
		</div>
	</div>
	<!-- </Modal Tambah Admin> -->
<?php endif; ?>
<!-- </crud-admin> -->

<!-- <crud-ebook> -->
<?php if(isset($tableEbook)) : ?>
	<!-- <NAV> -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark d-flex justify-content-between">
		<a class="navbar-brand" href="../admin/" style="font-family: 'Oswald', sans-serif;">
			<i class="fas fa-house-user" style="font-size: 17px;"> Beranda</i> 
		</a>
		
		<a class="btn btn-success" href="" data-toggle="modal" data-target="#ModalTambahEbook">
			<i class="fas fa-plus"></i>
		</a>
	</nav>
	<!-- </NAV> -->

	<div class="NtblKalender">
	<!-- SAPA -->
		<div class="divSapa">
			<h1 class="NamaTbl">Table <?= $xx; ?></h1>
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

	<div class="container-fluid">
		<form>
			<div class="form-group w-100">
				<input type="text" class="form-control w-100" id="SearchEbook" placeholder="&#xF002; search" style="font-family:Arial, FontAwesome;">
			</div>
		</form>
		<div id="div-tabel-ebook" style="overflow: auto;">
			<table class="table table-bordered table-hover">
				<thead class="thead-dark text-center">
					<tr>
						<th scope="col">
							Foto
						</th>
						<th scope="col" style="min-width: 200px;">
							Judul
						</th>
						<th scope="col" style="min-width: 160px;">
							Kategori
						</th>
						<th scope="col" style="min-width: 120px;">
							Aksi
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($ebook as $eb) : ?>
					<tr class="text-center" style="background-color: rgba(255, 255, 255, 0.5);">
						<th>
							<img src="../asset/imgEbook/<?= $eb['fotobuku']; ?>" title="<?= $eb['judulbuku']; ?>" width="100px" height="120px" id="ebookfoto">
						</th>
						<th class="align-middle">
							<?= $eb['judulbuku']; ?>
						</th>
						<td class="align-middle">
							<?= $eb['kategori']; ?>
						</td>
						<td class="align-middle">
							<a href="../edit/?idbuku=<?= $eb['id']; ?>" class="btn btn-warning">
								<i class="fas fa-edit"></i>
							</a>
							<a href="../method/delete.php?xx=<?= $eb['judulbuku']; ?> & table=ebook & colom=judulbuku" class="btn btn-danger" onclick="return confirm('yakin ingin menghapus?');">
								<i class="fas fa-trash-alt"></i>
							</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
<!-- <Modal Tambah ebook> -->
	<div class="modal fade" id="ModalTambahEbook" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<form method="post" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Tambah Ebook</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="uploader" value="<?php echo $uploader; ?>">
					<div class="form-group">
						<img src="../asset/imgEbook/gambardaefault.png" width="120px" height="150px" style="margin: 0px 0px 10px 0px;">
						<input type="file" name="fotobuku" style="width: 300px;" class="form-control-file" required>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="judul-buku">Judul Buku</label>
							<input type="text" name="judulbuku" class="form-control" id="judul-buku" required>
						</div>
						<div class="form-group col-md-6">
							<label for="nama-penulis">Nama Penulis</label>
							<input type="text" name="penulis" class="form-control" id="nama-penulis" required>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="nama-penerbit">Nama penerbit</label>
							<input type="text" name="penerbit" class="form-control" id="nama-penerbit" value="----">
						</div>
						<div class="form-group col-md-6">
							<label for="tahun-terbit">Tanggal Terbit</label>
							<input type="text" name="tglterbit" class="form-control" id="tahun-terbit" value="----">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>upload file</label>
							<input type="file" name="fileebook" class="form-control-file">
						</div>
						<div class="form-group col-md-6">
							<label>pilih kategori</label>
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
					</div>
					<div class="form-group">
						<label for="comment">Sinopsis</label>
						<textarea class="form-control" rows="3" id="comment" name="sinopsis"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" name="upload" class="btn btn-info">Submit</button>
				</div>
			</div>
			</form>
		</div>
	</div>
<!-- </Modal Tambah ebook> -->
<?php endif; ?>
<!-- <crud-ebook> -->
	
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
</body>
</html>