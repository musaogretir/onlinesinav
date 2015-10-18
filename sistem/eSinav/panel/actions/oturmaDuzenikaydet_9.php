<?php
require_once("../class/connect.php");
require_once("headerActions.php");
	

	if ($_POST){
		$msg = "";
		
		$a = trim($_POST["a"]);
		$b = base64_decode(base64_decode(trim($_POST["b"])));
		
		$q = mysql_query("INSERT INTO oturmaduzeni VALUES(DEFAULT,'$a','$b')");
		
		if ($q) $msg = "OK"; else $q = "Bir hata oluştu.<br/>Lütfen tekrar deneyiniz.";
		
	}else{
		$msg = "Bilgiler eksik.<br/>Sistem yöneticinize başvurunuz.";	
	}
	
	echo $msg;

?>