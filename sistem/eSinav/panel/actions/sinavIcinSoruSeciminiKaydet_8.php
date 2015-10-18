<?php
require_once("../class/connect.php");
require_once("headerActions.php");
	
	
	if ($_POST){
		$a = $_POST["a"];
		$b = $_POST["b"];
		
		$q = mysql_query("UPDATE sinavlar SET sinavSorulari = '$a' WHERE id = '$b' ");
		
		if ($q) $msg = "Sorular kaydedildi.<br/><font style='color:red'>Oturma düzeni oluşturma</font> ekranına yöneldiriliyorsunuz."; else $msg = "Bir hata oluştu.<br/>Lütfen tekrar deneyiniz.";
	}
	else{
		$msg = "Eksik parametre.<br/>Sistem yöneticinize başvurunuz.";	
	}

	echo "$msg";
?>