<?php
	require '../method/function.php';
	session_start();

	// ----------------------------
	// 		Waktu&Tanggal
	// ----------------------------
	$getWaktu = getWaktu();

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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<style>
		body{
			background-image     : url(../asset/imgBground/<?= $getWaktu['bgBesar']; ?>);
			background-size      : cover;
			background-repeat    : no-repeat;
			background-attachment: fixed;
		}
		footer{
			display: flex;
			align-items: center;
			justify-content: space-between;
		}
		/*///////////////////////////////////////////////////////////////////////////////////////////////*/
		@media(max-width: 720px){
			body{
				background-image     : url(../asset/imgBground/<?= $getWaktu['bgKecil']; ?>);
				background-size      : cover;
				background-repeat    : no-repeat;
				background-attachment: fixed;
			}
			footer{
				flex-direction: column;
			}
			footer span{
				margin-bottom: 5px;
			}
		}
	</style>
</head>
<body>

	<!-- main content -->
	<div class="position-relative container-fluid p-0 vh-100 d-flex justify-content-center align-items-center">
		
		<!-- <Form> -->
		<div class="container-fluid row px-0 d-flex justify-content-center">

			<div class="col-sm-6 col-md-5 col-lg-4 col-xl-3"> <!-- " default px-3 " -->

				<div class="p-4 rounded-lg" style="background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 4px );-webkit-backdrop-filter: blur( 4px );">
					<h2 class="font-weight-bolder text-center" style="color: rgba(0,0,0,0.7);">Login</h1>
					<form method="post" class="mt-4">
						<div class="form-group">
							<input type="text" name="usernameL" class="form-control" placeholder="Enter Nickname" id="usernameL" required autocomplete="off">
							<?php if(isset($userNameSalah)) : ?>
								<small style="color: red; position: absolute; letter-spacing: 1px">username salah/tidak terdaftar</small>
							<?php endif; ?>
						</div>
						<div class="form-group" id="group-password">
							<input type="password" name="passwordL" class="form-control mt-4" placeholder="Enter password" id="passwordL" required>
							<?php if(isset($passwordSalah)) : ?>
								<small style="color: red; position: absolute; letter-spacing: 1px">password salah</small>
							<?php endif; ?>
						</div>
						<div class="form-check mt-4">
							<label class="form-check-label">
								<input class="form-check-input" name="remember" type="checkbox"> Remember me
							</label>
						</div>
						<button type="submit" name="login" class="btn btn-primary w-100 mt-4" style="letter-spacing: 2px" id="bottom">Login</button>
					</form>
				</div>

			</div>

		</div><!-- </Form> -->				


	</div><!-- main content -->
	
	<!-- <footer> -->
	<footer class="fixed-bottom px-2" style="background: linear-gradient(to bottom, rgba(255, 255, 255, 0.0) 10%, black 98%);"><!-- " default pb-2 " -->
		<span class="text-light">Made With <img src="../asset/imgBground/love.svg" width="30px" style="transform: translateY(-2px);"> by <a href="https://www.instagram.com/el.koro_/" target="_blank" style="text-decoration: none;"><i class="fas fa-at"></i>Bagaskoro</a>
		</span>
		<span class="text-light"><img src="../asset/imgBground/pin.svg" width="30px" style="transform: translateY(-4px);"> South Tangerang, Indonesia</span>
	</footer>
	<!-- </footer> -->

	<!---------------------- js ---------------------->
	</body>
</html>