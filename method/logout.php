<?php
	require '../method/function.php';
	session_start();
	
	// -------------------
	// delete session
	// -------------------
	session_unset();
	session_destroy();
	$_SESSION["login"] = [];
	$_SESSION["admin"] = [];
	
	// -------------------
	// delete cookie
	// -------------------
	setcookie('id','',time()-1);
	setcookie('cookiename','',time()-1);
	setcookie('nameId','',time()-1);
	setcookie('idadmin','',time()-1);
	setcookie('cookieadmin','',time()-1);
	setcookie('nameIdAdmin','',time()-1);
	
	// -------------------
	// change location
	// -------------------
	header('location:../login/');
	exit;
?>