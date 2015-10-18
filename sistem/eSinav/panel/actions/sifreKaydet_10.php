<?php
require_once("../class/connect.php");
require_once("headerActions.php");
	
	
	if ($_POST){
		$h1 = explode(";",base64_decode(base64_decode($_POST["h1"]))); // öğrenci id - şifre;
		$h2 = explode("-",base64_decode(base64_decode($_POST["h2"]))); // sınav ID - başlangıç - bitiş
		
		foreach($h1 as $kisi){
			$t = explode("-",$kisi);
			if ($t[0]){
				$q = mysql_query("INSERT INTO sifreler VALUES(DEFAULT,'$h2[0]','$t[0]','$t[1]','$h2[1]','$h2[2]')");
				$q = mysql_query("UPDATE sinavlar SET sifreOlusturmaDurumu = 1 WHERE id = '$h2[0]'");	
			}
			if (!$q) break;
		}
		if ($q) $msg = "OK"; else $msg = "Bir hata oluştu.<br/>Lütfen tekrar deneyiniz.<br/><br/>".mysql_error();
	}
	else{
		$msg = "Eksik parametre.<br/>Sistem yöneticinize başvurunuz.";	
	}

	echo "$msg".base64_decode(base64_decode($_POST["h1_10"]));
?>