<?php 
	require '../method/function.php';
	session_start();

	// ----------------------------
	//          SESSION 
	// ----------------------------
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
	// ambil nama admin
	// ----------------------------
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
	<link rel="preconnect" href="https://fonts.gstatic.com"><link href="https://fonts.googleapis.com/css2?family=Indie+Flower&family=Merienda+One&family=Oswald:wght@300&family=Permanent+Marker&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<style>
		body{
			background-image     : url(../asset/imgBground/<?= $getWaktu['bgBesar']; ?>);
			background-size      : cover;
			background-repeat    : no-repeat;
			background-attachment: fixed;
		}
		h1.sapa,#kalender h1{
			font-size: 70px;
		}
		h3.sapa,#kalender p{
			font-size: 40px;
		}
		/* ///////////////////////////////////////////////// */
		@media(max-width: 768px){
			body{
				background-image     : url(../asset/imgBground/<?= $getWaktu['bgKecil']; ?>);
				background-size      : cover;
				background-repeat    : no-repeat;
				background-attachment: fixed;
			}
			h1.sapa,#kalender h1{
				font-size: 50px;
			}
			h3.sapa,#kalender p{
				font-size: 30px;
			}
			footer{
				flex-direction: column;
			}
			footer span{
				margin-bottom: 5px;
			}
		}
		@media(max-width: 576px){
			.navbar-collapse{
				margin-top: 10px;
			}
			#header{
				flex-direction: column;
				text-align: center;
			}
			#kalender{
				margin: 20px 0 12px 0;
			}
			h1.sapa,#kalender h1{
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

	<!-- NAV -->
	<nav class="navbar fixed-top px-1 py-1" style="background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 4px );-webkit-backdrop-filter: blur( 4px );">
		<a class="navbar-brand font-weight-bold" href="" style="font-family: 'Oswald', sans-serif; color: #<?= $warna; ?>;-webkit-text-stroke-width: 0.02vw;-webkit-text-stroke-color: #<?= $stroke; ?>;">
			<img src="../asset/imgBground/logo2.png" alt="Logo" style="width:30px;"><span class="align-middle"> RumahEbook</span>
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<img src="../asset/imgAdmin/<?= $admin['adminfoto']; ?>" width="40px" height="40px" class="rounded-circle">
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="btn btn-danger py-2 px-3 d-flex align-items-center justify-content-center" href="../method/logout.php">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20px" height="20px"><g><path fill="#<?= $warna; ?>"" d="M510.371,226.513c-1.088-2.603-2.645-4.971-4.629-6.955l-63.979-63.979c-8.341-8.32-21.824-8.32-30.165,0
						c-8.341,8.341-8.341,21.845,0,30.165l27.584,27.584H320.013c-11.797,0-21.333,9.557-21.333,21.333s9.536,21.333,21.333,21.333
						h119.168l-27.584,27.584c-8.341,8.341-8.341,21.845,0,30.165c4.16,4.181,9.621,6.251,15.083,6.251s10.923-2.069,15.083-6.251
						l63.979-63.979c1.984-1.963,3.541-4.331,4.629-6.955C512.525,237.606,512.525,231.718,510.371,226.513z"/><path fill="#<?= $warna; ?>"" d="M362.68,298.667c-11.797,0-21.333,9.557-21.333,21.333v106.667h-85.333V85.333c0-9.408-6.187-17.728-15.211-20.437 l-74.091-22.229h174.635v106.667c0,11.776,9.536,21.333,21.333,21.333s21.333-9.557,21.333-21.333v-128
						C384.013,9.557,374.477,0,362.68,0H21.347c-0.768,0-1.451,0.32-2.197,0.405c-1.003,0.107-1.92,0.277-2.88,0.512
						c-2.24,0.576-4.267,1.451-6.165,2.645c-0.469,0.299-1.045,0.32-1.493,0.661C8.44,4.352,8.376,4.587,8.205,4.715
						C5.88,6.549,3.939,8.789,2.531,11.456c-0.299,0.576-0.363,1.195-0.597,1.792c-0.683,1.621-1.429,3.2-1.685,4.992
						c-0.107,0.64,0.085,1.237,0.064,1.856c-0.021,0.427-0.299,0.811-0.299,1.237V448c0,10.176,7.189,18.923,17.152,20.907
						l213.333,42.667c1.387,0.299,2.795,0.427,4.181,0.427c4.885,0,9.685-1.685,13.525-4.843c4.928-4.053,7.808-10.091,7.808-16.491
						v-21.333H362.68c11.797,0,21.333-9.557,21.333-21.333V320C384.013,308.224,374.477,298.667,362.68,298.667z"/></g></svg>
					</a>
				</li>
			</ul>
		</div>
	</nav><!-- </NAV> -->
	
	<!-- main-content -->
	<div class="position-relative container-fluid px-3" style="padding: 80px 0;min-height:100vh">

		<!-- header -->
		<div id="header" class="w-full row m-0 p-0" style="display: flex;justify-content: space-between;align-items: center;">
			<div class="col h-100 p-0 d-flex flex-column justify-content-center align-items-center" style="color: #<?= $warna; ?>;">
				<h1 class="sapa" style="-webkit-text-stroke-width: 1px;-webkit-text-stroke-color: #<?= $stroke; ?>;font-weight: bolder;font-family: 'Oswald', sans-serif;letter-spacing: 1px;">
					Selamat <?= $getWaktu['waktu']; ?>, <?= $admin["adminname"]; ?></h1>
				<h3 class="sapa" style="-webkit-text-stroke-width: 0.02vw;-webkit-text-stroke-color: #<?= $stroke; ?>;font-weight: bolder;font-family: 'Oswald', sans-serif;letter-spacing: 1px;">
					<i class="fas fa-heart" style="color: #ff0730;"></i> . . Selamat bekerja . . <i class="fas fa-heart" style="color: #ff0730;"></i></h3>
			</div>
			<div class="col-3 col-sm-3 col-md-3 col-lg-2 col-xl-2 p-0 bg-warning rounded-lg position-relative" style="box-shadow: 4px 4px 6px 0px rgba(0,0,0,0.6); min-width: 100px;" id="kalender">
				<img src="../asset/imgAdmin/<?= $admin['adminfoto']; ?>" width="100%" style="opacity: 0;">
				<div style="position: absolute; top:0; bottom:0; left:0; right:0;" class="d-flex flex-column justify-content-center align-items-center">
					<h1 class="k1" style="font-family: 'Permanent Marker', cursive;">
						<?= $getWaktu['kalender1']; ?></h1>
					<p class="k2" style="font-family: 'Oswald', sans-serif;">
						<?= $getWaktu['kalender2']; ?></p>
				</div>
			</div>
		</div><!-- header -->

		<!-- card -->
		<div id="cardWraper" class="w-full row mx-0 mt-5 d-flex justify-content-around align-items-start" style="">
			<div class="col-md-4 col-lg-4 col-xl-4 px-4 mb-3">
				<a href="../crud/?xx=kritik" class="d-flex flex-column justify-content-center align-items-center rounded-lg text-white" style="width:100%; height:240px;text-decoration:none;background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 4px );-webkit-backdrop-filter: blur( 4px );">
					<img src="../asset/imgBground/kritik.svg" width="60px">
					<h3>KRITIK</h3>
				</a>
			</div>
			<div class="col-md-4 col-lg-4 col-xl-4 px-4 mb-3">
				<a href="../crud/?xx=admin" class="d-flex flex-column justify-content-center align-items-center rounded-lg text-white" style="width:100%; height:240px;text-decoration:none;background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 4px );-webkit-backdrop-filter: blur( 4px );">
					<img src="../asset/imgBground/admin.svg" width="60px">
					<h3>ADMIN</h3>
				</a>
			</div>
			<div class="col-md-4 col-lg-4 col-xl-4 px-4 mb-3">
				<a href="../crud/?xx=ebook" class="d-flex flex-column justify-content-center align-items-center rounded-lg text-white" style="width:100%; height:240px;text-decoration:none;background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 4px );-webkit-backdrop-filter: blur( 4px );">
					<img src="../asset/imgBground/ebook.svg" width="60px">
					<h3>E-BOOK</h3>
				</a>
			</div>
		</div><!-- card -->

		<!-- footer -->
		<footer class="fixed-bottom m-0 px-3" style="background: linear-gradient(to bottom, rgba(255, 255, 255, 0.0) 10%, black 98%);display: flex;align-items: center;justify-content: space-between;"><!-- " default pb-2 " -->
			<span class="text-light" style="word-spacing: 2px;">Made With <img src="../asset/imgBground/love.svg" width="30px" style="transform: translateY(-2px);"> by <a href="https://www.instagram.com/el.koro_/" target="_blank" style="text-decoration: none; font-weight: 500;"><i class="fas fa-at"></i>Bagaskoro</a>
			</span>
			<span class="text-light"><img src="../asset/imgBground/pin.svg" width="30px" style="transform: translateY(-4px);">  South Tangerang, Indonesia</span>
		</footer><!-- footer -->
		
	</div><!-- main-content -->
	

	<!---------------------- js ---------------------->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script><script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		
	</script>
</body>

</html>