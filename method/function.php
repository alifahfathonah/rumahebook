<?php
	$conn = mysqli_connect("localhost","root","","db_rumahebook");
	
	// --------------------
	// 		get data
	// --------------------
	function tampil($query){
		global $conn;

		$result = mysqli_query($conn,$query);
		$temporaryArray = [];

		while($row = mysqli_fetch_assoc($result))
		{
			$temporaryArray[] = $row;
		}
		return $temporaryArray;
	}

	// --------------------
	// 		delete
	// --------------------
	function delete($xx,$table,$colom){
		global $conn;

		$xx    = $xx;
		$table = $table;
		$colom = $colom;

		mysqli_query($conn,"DELETE FROM $table WHERE $colom='$xx'");

		return mysqli_affected_rows($conn);
	}

	// --------------------
	// 	KRITIK & SARAN
	// --------------------
	function sendKritik($post){
		global $conn;

		$namaKritik  = htmlspecialchars(stripslashes($post["namaKritik"]));
		$pesanKritik = htmlspecialchars(stripslashes($post["pesanKritik"]));
		$tglKritik   = htmlspecialchars(stripslashes($post["tglKritik"]));
		
		$query       = "INSERT INTO kritik VALUES('0','$namaKritik','$pesanKritik','$tglKritik')";
		mysqli_query($conn,$query);

		return mysqli_affected_rows($conn);
	}

	// --------------------
	// 	  tambah admin
	// --------------------
	function daftaradmin($post){
		global $conn;

		$adminname = htmlspecialchars(strtolower(stripslashes($post["adminname"])));
		$password  = mysqli_real_escape_string($conn,htmlspecialchars($post["password"]));
		$retype    = mysqli_real_escape_string($conn,htmlspecialchars($post["retype"]));

		$result    = mysqli_query($conn,"SELECT adminname FROM admin WHERE adminname='$adminname'");
		if(mysqli_fetch_assoc($result))
		{
			return 'sama';
		}

		if($password != $retype)
		{
			return 'salah';
		}

		$password = password_hash($password, PASSWORD_DEFAULT);

		mysqli_query($conn,"INSERT INTO admin VALUES('0','$adminname','$password','gambardefault.jpg')");

		return mysqli_affected_rows($conn);
	}

	// --------------------
	//  	edit admin
	// --------------------
	function editadmin($post){
		global $conn;

		$idadmin        = $post["idadmin"];
		$passwordLama = $post["passwordLama"];
		$fotolama      = $post["fotolama"];
		
		if($_FILES["fotoadmin"]["error"] === 4)
		{
			$fotoadmin = $fotolama;
		}
		else
		{
			$fotoadmin = uploadFotoAdmin();
			if($fotoadmin === 'bukanfoto')
			{
				return 'bukanfoto';
			}
			if($fotoadmin === 'oversize')
			{
				return 'oversize';
			}
		}

		$adminlama     = tampil("SELECT * FROM admin WHERE id ='$idadmin'")[0];
		if($post["adminnameBaru"] === $adminlama["adminname"] && $post["passwordBaru"] === $adminlama["pasword"] && $fotoadmin === $adminlama["adminfoto"])
		{
			return 'nothingupload';
		}

		$adminnameBaru = htmlspecialchars(strtolower(stripslashes($post["adminnameBaru"])));
		$passwordBaru  = mysqli_real_escape_string($conn,htmlspecialchars($post["passwordBaru"]));

		$adminlain     = tampil("SELECT * FROM admin WHERE id !='$idadmin'");
		foreach ($adminlain as $adminX) {
			if($adminnameBaru === $adminX['adminname']){
				return 'sama';
			}
		}

		if($passwordBaru == $passwordLama){
			$passwordBaru = $passwordLama;
		}
		else{
			$passwordBaru = password_hash($passwordBaru, PASSWORD_DEFAULT);;
		}

		mysqli_query($conn, "UPDATE admin SET adminname='$adminnameBaru', pasword='$passwordBaru', adminfoto='$fotoadmin' WHERE id='$idadmin'");

		return mysqli_affected_rows($conn);
	}
	
	// --------------------
	// 	upload foto admin 
	// --------------------
	function uploadFotoAdmin(){
		$namafoto    = $_FILES['fotoadmin']['name'];
		$ukuranfoto  = $_FILES['fotoadmin']['size'];
		$error       = $_FILES['fotoadmin']['error'];
		$tempat_foto = $_FILES['fotoadmin']['tmp_name'];

		if($error === 4)
		{
			return false;
		}

		if($ukuranfoto > 1000000)
		{
			return 'oversize';
		}

		$ekstensivalid = ['jpg','png','jpeg'];
		$ekstensifoto  = explode('.', $namafoto);
		$ekstensifoto  = strtolower(end($ekstensifoto));

		if(!in_array($ekstensifoto, $ekstensivalid))
		{
			return 'bukanfoto';
		}

		$namafoto = uniqid();
		$namafoto .= '.';
		$namafoto .= $ekstensifoto;

		move_uploaded_file($tempat_foto, '../asset/imgAdmin/'.$namafoto);
		return $namafoto;
	}

	// --------------------
	// 	tambah ebook
	// --------------------
	function upload($post){
		global $conn;

		$uploader = mysqli_real_escape_string($conn,htmlspecialchars($post["uploader"]));
		$judulbuku= mysqli_real_escape_string($conn,htmlspecialchars($post["judulbuku"]));
		$penulis  = mysqli_real_escape_string($conn,htmlspecialchars($post["penulis"]));
		$penerbit = mysqli_real_escape_string($conn,htmlspecialchars($post["penerbit"]));
		$tglterbit= mysqli_real_escape_string($conn,htmlspecialchars($post["tglterbit"]));
		$kategori = mysqli_real_escape_string($conn,htmlspecialchars($post["kategori"]));
		$sinopsis = mysqli_real_escape_string($conn,htmlspecialchars($post["sinopsis"]));

		$fotobuku = uploadFotoBuku();
		if($fotobuku === 'oversize')
		{
			return 'oversize';
		}
		if($fotobuku === 'bukanfoto')
		{
			return 'bukanfoto';
		}

		$fileebook = uploadFileEbook();
		if($fileebook === 'bukuoversize')
		{
			return 'bukuoversize';
		}
		if($fileebook === 'bukanebook')
		{
			return 'bukanebook';
		}

		$query = "INSERT INTO ebook VALUES('$uploader','$judulbuku','$penulis','$penerbit','$tglterbit','$fotobuku','$fileebook','$kategori','$sinopsis','0')";
		mysqli_query($conn,$query);

		return mysqli_affected_rows($conn);
	}

	// --------------------
	//  edit ebook
	// --------------------
	function editebook($post){
		global $conn;
		
		$idbuku = $post["idbuku"];

		$ebookLama = tampil("SELECT * FROM ebook WHERE id='$idbuku'")[0];
		$uploader  = $ebookLama['uploader'];
		$fileebook = $ebookLama['fileebook'];

		$judulbukuBaru = mysqli_real_escape_string($conn,htmlspecialchars($post["judulbukuBaru"]));
		$penulisBaru   = mysqli_real_escape_string($conn,htmlspecialchars($post["penulisBaru"]));
		$penerbitBaru  = mysqli_real_escape_string($conn,htmlspecialchars($post["penerbitBaru"]));
		$tglterbitBaru = mysqli_real_escape_string($conn,htmlspecialchars($post["tglterbitBaru"]));
		$sinopsisBaru  = mysqli_real_escape_string($conn,htmlspecialchars($post["sinopsisBaru"]));
		if(isset($post['kategoriBaru'])){
			$kategoriBaru  = mysqli_real_escape_string($conn,htmlspecialchars($post["kategoriBaru"]));
		}else{
			$kategoriBaru  = mysqli_real_escape_string($conn,htmlspecialchars($post["kategoriLama"]));
		}
		$fotolama      = $post["fotolama"];

		if($_FILES["fotobuku"]["error"] === 4)
		{
			$fotobukuBaru = $fotolama;
		}
		else
		{
			$fotobukuBaru = uploadFotoBuku();
			if($fotobukuBaru === 'bukanfoto')
			{
				return 'bukanfoto';
			}
			if($fotobukuBaru === 'oversize')
			{
				return 'oversize';
			}
		}

		mysqli_query($conn, "UPDATE ebook SET uploader='$uploader', judulbuku='$judulbukuBaru', penulis='$penulisBaru', penerbit='$penerbitBaru', tglterbit='$tglterbitBaru', fotobuku='$fotobukuBaru', fileebook='$fileebook', kategori='$kategoriBaru', sinopsis='$sinopsisBaru' WHERE id='$idbuku'");

		return mysqli_affected_rows($conn);
	}

	// --------------------
	// 	upload foto ebook
	// --------------------
	function uploadFotoBuku(){
		$namaFotoBuku   = $_FILES["fotobuku"]["name"];
		$ukuranFotoBuku = $_FILES["fotobuku"]["size"];
		$error          = $_FILES["fotobuku"]["error"];
		$tmpFotoBuku    = $_FILES["fotobuku"]["tmp_name"]; 

		if($error === 4)
		{
			return false;
		}

		$ekstensivalid    = ['jpg','png','jpeg'];
		$ekstensiFotoBuku = explode('.', $namaFotoBuku);
		$ekstensiFotoBuku = strtolower(end($ekstensiFotoBuku));

		if(!in_array($ekstensiFotoBuku, $ekstensivalid))
		{
			return 'bukanfoto';
		}

		if($ukuranFotoBuku > 1000000)
		{
			return 'oversize';
		}

		if(uploadFileEbook() == 'bukanebook')
		{
			return false;
		}

		$namaFotoBuku  = uniqid();
		$namaFotoBuku .= '.';
		$namaFotoBuku .= $ekstensiFotoBuku;

		move_uploaded_file($tmpFotoBuku, '../asset/imgEbook/'.$namaFotoBuku);

		return $namaFotoBuku;
	}

	// --------------------
	// 	upload file ebook
	// --------------------
	function uploadFileEbook(){
		$namaFileEbook   = $_FILES["fileebook"]["name"];
		$ukuranFileEbook = $_FILES["fileebook"]["size"];
		$error          = $_FILES["fileebook"]["error"];
		$tmpFileEbook    = $_FILES["fileebook"]["tmp_name"]; 

		if($error === 4)
		{
			return false;
		}

		if($ukuranFileEbook > 100000000)
		{
			return 'bukuoversize';
		}

		$ekstensivalid    = ['pdf','docx','doc'];
		$ekstensiFileEbook = explode('.', $namaFileEbook);
		$ekstensiFileEbook = strtolower(end($ekstensiFileEbook));

		if(!in_array($ekstensiFileEbook, $ekstensivalid))
		{
			return 'bukanebook';
		}

		move_uploaded_file($tmpFileEbook, '../asset/fileEbook/'.$namaFileEbook);

		return $namaFileEbook;
	}
?>