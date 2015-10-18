<?php
require_once("../class/connect.php");
require_once("headerActions.php");
	
	
	if ($_POST){
		date_default_timezone_set('Europe/Istanbul');
		
		$id = base64_decode($_POST['a']);
		
		$q1 = mysql_fetch_object(mysql_query("SELECT * FROM sinavlar WHERE id = '$id'"));
		$t  = date("U"); 
		
		foreach($_SESSION['notBilgisi'] as $index=>$kisi){
			$v = explode("-",$kisi);
			$ekle = mysql_query("INSERT INTO notlar VALUES(DEFAULT,'$id','$q1->ogretimGorevlisi','$index','$v[0]','$v[1]','$v[2]','$v[3]','$t')");
			if (!$ekle) break; 
		}
		
		unset($_SESSION['notBilgisi']);
		
		if ($ekle) {
			$g = mysql_query("UPDATE sinavlar SET sinavDegerlendirmeDurumu = '1' WHERE id = '$id'");
			$msg = "OK"; 
		}else{
			$msg = "Bir hata oluştu.<br/>Lütfen tekrar deneyiniz.<br/><br/>".mysql_error();
		}
	}
	else{
		$msg = "Eksik parametre.<br/>Sistem yöneticinize başvurunuz.";	
	}
	echo $msg;
?>