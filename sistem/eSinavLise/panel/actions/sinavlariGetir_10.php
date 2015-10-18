<?php
	require_once("headerActions.php");
	require_once("../class/connect.php");

	if ($_POST)
	{
		session_start();
		$msg = "";
		@$g = $_POST["a"];
		
		if ($g)
		{
			$msg = '<select id="sinav_10" name="sinav_10">
                  <option value="0">Seçiniz</option>';
				  
			$q1 = mysql_query("SELECT * FROM sinavlar WHERE ogretimYili = (SELECT id FROM ogretimyili WHERE aktif = 1 ) AND donem='".$_SESSION["gecerliKullanici"]["dnm"]."' AND ogretmen = '".$_SESSION["gecerliKullanici"]["userId"]."' AND sinavTuru='$g' AND sinavSorulari <>'' AND sinavDegerlendirmeDurumu = 0 AND sifreOlusturmaDurumu = 0 ORDER BY id ASC");
			
			$sayac = 1;
			while($al = mysql_fetch_object($q1)){
				$q2 = mysql_fetch_object(mysql_query("SELECT dersAdi FROM dersler WHERE id = '$al->ders' "));
				$q3 = mysql_fetch_object(mysql_query("SELECT dal FROM dallar WHERE id = '$al->dal' "));
				$q4 = mysql_fetch_object(mysql_query("SELECT seviye FROM sinifseviyeleri WHERE id = '$al->seviye' "));
				$msg .= "<optgroup label='$al->sinavTarihi  - $al->sinavSaati - $q3->dal Dalı $q4->seviye'>
							<option value='$al->id'>$q2->dersAdi [$sayac.Sınav]</option>
						</optgroup>";	
				$sayac++;
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