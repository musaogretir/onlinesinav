<?php
require_once("../class/connect.php");
require_once("headerActions.php");
	
	
	if ($_POST)
	{
		session_start();
		$msg = "";
		$kullanici = $_POST["kKullanici"];
		$_POST["liste"] ? $yetkiler  = trim($_POST["liste"],"-") : $yetkiler = "yetkisiz";
		
		$db = mysql_query("UPDATE kullanicilar SET yetkiler = '$yetkiler' WHERE id='$kullanici'");

		if ($db){
			$msg = "Yetkilendirme tamamlandı.";	
		}else{
			$msg = "Yetkilerde değişiklik yapmadınız. <br/>".mysql_error();	
		}
		echo $msg;
	}
?>