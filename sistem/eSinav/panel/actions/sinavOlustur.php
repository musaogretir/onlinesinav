<?php
require_once("../class/connect.php");
require_once("headerActions.php");
	
	
	if ($_POST)
	{
		session_start();
		$msg = "";
		
		$ogretimYili		= trim($_POST["ogretimYili_7"]);
		$donem		  		= trim($_POST["donem_7"]);
		$sinavTuru			= trim($_POST["sinavTuru_7"]);
		$ogretimGorevlisi	= trim($_POST["ogretimGorevlisi_7"]);
		$sinavTarihi		= trim($_POST["sinavTarihi_7"]);
		$sinavSaati			= trim($_POST["sinavSaati_7"]); 
		$sinavSuresi		= trim($_POST["sinavSuresi_7"]); 
		$sinavAciklamasi	= trim($_POST["sinavAciklamasi_7"]);
		$bolum				= trim($_POST["bolum_7"]);
		$ders				= trim($_POST["dersler_7"]);
		$seviye				= trim($_POST["seviye_7"]);
		$ogretimTuru		= trim($_POST["ogretimTuru_7"]);
		
		if ($ogretimYili && $donem && $sinavTuru && $ogretimGorevlisi && $sinavTarihi && $sinavSaati && $sinavSuresi && $sinavAciklamasi && $bolum && $ders && $seviye && $ogretimTuru){
			
			$q = mysql_num_rows(mysql_query("SELECT * FROM sinavlar WHERE ogretimYili = '$ogretimYili' AND sinavTuru = '$sinavTuru' AND ogretimGorevlisi = '$ogretimGorevlisi' AND bolum = '$bolum' AND ders = '$ders' AND seviye = '$seviye' AND ogretimTuru = '$ogretimTuru'"));
			
			if (!$q){
				$q = mysql_query("INSERT INTO sinavlar VALUES(DEFAULT, '$ogretimYili', '$donem', '$sinavTuru', '$ogretimGorevlisi', '$sinavTarihi', '$sinavSaati', '$sinavSuresi', '$sinavAciklamasi', '$bolum', '$ders', '$seviye', '$ogretimTuru', '', '', '')");
				if ($q){
					$msg = "Sınav oluşturuldu.<br/><font color='red'>Soruları seçme ekranına yönlendiriliyorsunuz.</font>";	
				}else{
					$msg = "Bir hata oluştu.<br/>Sistem yöneticinize başvurunuz.";
				}
			}else{
				$msg = "Bu sınav daha önce eklenmiştir.<br/>Bilgilerinizi kontrol ediniz.";	
			}
		}else{
			$msg = "Bilgiler eksik.<br/>Sistem yöneticinize başvurunuz.";	
		}
		
		
		echo $msg;
	}
?>