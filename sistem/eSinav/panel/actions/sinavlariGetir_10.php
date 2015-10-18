<?php
require_once("../class/connect.php");
require_once("headerActions.php");
	

	if ($_POST)
	{
		session_start();
		$msg = "";
		@$g = $_POST["a"];
		
		if ($g)
		{
			$msg = '<select id="sinav_10" name="sinav_10">
                  <option value="0">Seçiniz</option>';
				  
			$q1 = mysql_query("SELECT * FROM sinavlar WHERE ogretimYili = (SELECT id FROM ogretimyili WHERE aktif = 1 ) AND donem='".$_SESSION["gecerliKullanici"]["dnm"]."' AND ogretimGorevlisi = '".$_SESSION["gecerliKullanici"]["userId"]."' AND sinavTuru='$g' AND sinavSorulari <>'' AND sinavDegerlendirmeDurumu = 0 AND sifreOlusturmaDurumu = 0");
			
			while($al = mysql_fetch_object($q1)){
					$q2 = mysql_fetch_object(mysql_query("SELECT dersAdi FROM dersler WHERE id = '$al->ders' "));
					$msg .= "<optgroup label='$al->sinavTarihi - $al->sinavSaati - $al->ogretimTuru Öğretim $al->seviye. Sınıf'><option value='$al->id'>$q2->dersAdi</option></optgroup>";	
			}
			$msg.="</select>";
		}
		else
		{
			$msg = "Sınav türünü seçiniz.";	
		}
		
		unset($_POST);
		echo $msg;
	}
?>