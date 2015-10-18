<?php
	require_once("headerActions.php");
	require_once("../class/connect.php");
	
	if ($_POST)
	{
		session_start();
		$msg = "";
		
		$bolum    = $_POST["a"];
		$dalAdi   = $_POST["b"];
		
		if ($bolum && $dalAdi){

			$q = mysql_num_rows(mysql_query("SELECT * FROM dallar WHERE bolum = '$bolum' AND dal = '$dalAdi'"));
			
			if (!$q){
				$q = mysql_query("INSERT INTO dallar VALUES(DEFAULT,'$bolum','$dalAdi')");
				if ($q){
					$msg = "Dal eklendi.";	
				}else{
					$msg = "Bir hata oluştu.<br/>Sistem yöneticinize başvurunuz.";
				}
			}else{
				$msg = "Bu bölüm için $dalAdi dalı daha önce eklenmiştir.";	
			}
		}else{
			$msg = "Bilgiler eksik.<br/>Sistem yöneticinize başvurunuz.";	
		}
		
		
		echo $msg;
	}
?>