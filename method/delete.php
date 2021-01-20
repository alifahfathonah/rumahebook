<?php 
	require 'function.php';
	global $conn;

	// -------------------
	// cek session
	// -------------------
	session_start();
	if(!isset($_SESSION["admin"])){
		header("location:login.php");
		exit;
	}

	// -------------------
	// 		delete
	// -------------------
	$xx    = $_GET["xx"];
	$table = $_GET["table"];
	$colom = $_GET["colom"];
	if(delete($xx,$table,$colom) > 0){
		echo "
			<script>
				document.location.href = '';
			</script>
		";
		header("location:../crud/?xx=".$table);
		exit;
	}
	else{
		echo "
			<script>
				alert('gagal terhapus');
			</script>
		";
		echo $xx, $table, $colom;
		echo mysqli_error($conn);
	}
?>