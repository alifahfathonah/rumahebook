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
	$bgBesar  = $waktu;
	$bgBesar .= '.jpg';
	$bgKecil  = $waktu;
	$bgKecil .= '2.jpg';

	// ----------------------------
	// 			Login
	// ----------------------------
	if(isset($_POST["login"])){
		
		$username = $_POST["usernameL"];
		$password = $_POST["passwordL"];
		
		// cek apakah ada di database
		$result = mysqli_query($conn,"SELECT*FROM admin WHERE adminname='$username'");
		if(mysqli_num_rows($result)){
			$user = mysqli_fetch_assoc($result);
			if(password_verify($password, $user["pasword"])){
				
				// set COOKIE
				if(isset($_POST["remember"])){
					setcookie('idadmin',$user["id"],time()+60*60*24*100);
					setcookie('cookieadmin',hash('sha256', $user["adminname"]),time()+60*60*24*100, "/");
					setcookie('nameIdAdmin',$user["id"],time()+60*60*24*100, "/");
				}
				
				// set session
				$_SESSION["admin"] = true;
				
				// pindah ke halaman UTAMA
				setcookie('nameIdAdmin',$user["id"],time()+60*60*24*100, "/");
				header('location:../admin/');
				exit;
			}
			else{
				$passwordSalah = true;
			}
		}
		else{
			$userNameSalah = true;
		}
	}
	
	// var_dump($_SESSION['admin']);

	// ----------------------------
	// 		Remember Me 
	// ----------------------------
	if (isset($_COOKIE["idadmin"]) && isset($_COOKIE["cookieadmin"])){
		$idadmin     = $_COOKIE["idadmin"];
		$cookieadmin = $_COOKIE["cookieadmin"];
		$result    = mysqli_query($conn,"SELECT adminname FROM admin WHERE id='$id'");
		$adminname = mysqli_fetch_assoc($result);
		if ($cookieadmin === hash('sha256', $adminname["adminname"])){
			$_SESSION["admin"] = true;
		}
	}

	// ----------------------------
	//          SESSION 
	// ----------------------------
	if(isset($_SESSION["admin"])){
		header('location:../admin/');
		exit;
	}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../asset/imgBground/logo2.png" type="image/x-icon">
	<title>Selamat Datang!</title>

	<!------------------------------------------- CSS --------------------------------------------->
	<link href="https://fonts.googleapis.com/css2?family=Anton&family=Montserrat+Subrayada&family=Roboto+Mono&display=swap" rel="stylesheet">
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

<section class="sec-login d-flex align-items-center justify-content-center">
	<!-- <Form> -->
	<div class="form-login" id="form-login">
		<form method="post">
			<div class="form-group">
				<input type="text" name="usernameL" class="form-control no-border" placeholder="Enter Nickname" id="usernameL" required>
				<?php if(isset($userNameSalah)) : ?>
				<small class="text-danger" style="position: absolute;">username salah/tidak terdaftar</small>
				<?php endif; ?>
			</div>
			<div class="form-group" id="group-password">
				<input type="password" name="passwordL" class="form-control no-border mt-2" placeholder="Enter password" id="passwordL" required>
			<?php if(isset($passwordSalah)) : ?>
				<small class="text-danger" style="position: absolute;">password salah</small>
			<?php endif; ?>
			</div>
			<div class="form-group form-check">
				<label class="form-check-label">
					<input class="form-check-input mt-2" name="remember" type="checkbox"> Remember me
				</label>
			</div>
			<button type="submit" name="login" class="btn btn-primary w-100" id="bottom">Login</button>
		</form>
	</div>
	<!-- </Form> -->

	<!-- <footer> -->
	<footer class="footerLogin">
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
</section>
	
	<!---------------------- js ---------------------->
	<script src="https://kit.fontawesome.com/6357e7545a.js" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="../myjs.js"></script>
	</body>
</html>