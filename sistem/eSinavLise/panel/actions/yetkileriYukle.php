<?php
	require_once("headerActions.php");
	require_once("../class/connect.php");
	
	if ($_POST)
	{
		session_start();
		$msg = "";
		$kullanici = trim($_POST["kKullanici"]);
			
		$r = mysql_fetch_object(mysql_query("SELECT * FROM kullanicilar WHERE id = '$kullanici'"));
		
		if (strlen($r->yetkiler) && $r->yetkiler!="yetkisiz"){
			$msg = $r->yetkiler;	
		}		
		echo $msg;
	}
?>