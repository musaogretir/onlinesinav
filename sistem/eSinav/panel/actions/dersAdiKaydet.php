<?php
require_once("../class/connect.php");
require_once("headerActions.php");
	
	
	if ($_POST)
	{
		session_start();
		$msg = "";
		
		$bolumAdi = $_POST["a"];
		$dersAdi  = $_POST["b"];
		
		if ($bolumAdi && $dersAdi){

			$q = mysql_num_rows(mysql_query("SELECT * FROM dersler WHERE bolum = '$bolumAdi' AND dersAdi = '$dersAdi'"));
			
			if (!$q){
				$q = mysql_query("INSERT INTO dersler VALUES(DEFAULT,'$bolumAdi','$dersAdi')");
				if ($q){
					$msg = "Ders eklendi.";	
				}else{
					$msg = "Bir hata oluştu.<br/>Sistem yöneticinize başvurunuz.";
				}
			}else{
				$msg = "Bu bölüm için $dersAdi dersi daha önce eklenmiştir.";	
			}
		}else{
			$msg = "Bilgiler eksik.<br/>Sistem yöneticinize başvurunuz.";	
		}
		
		
		echo $msg;
	}
?>