<?php
	require_once("headerActions.php");
	require_once("../class/connect.php");

	if ($_POST)
	{
		session_start();

		$sinavaGirmesiGerekenler 	= array();
		$sinavaGirenler				= array();
		
		@$a = $_POST["a"];
		
		
		if ($a>0){
			//Sınava Girmesi Gerekenler
			$q1 = mysql_query("SELECT id FROM siniflisteleri WHERE ogretimYili = (SELECT id FROM ogretimyili WHERE aktif = 1) AND donem = (SELECT id FROM donemler WHERE aktif = 1) AND bolum = (SELECT bolum FROM sinavlar WHERE id = '$a') AND dal = (SELECT dal FROM sinavlar WHERE id = '$a') AND sinifSeviyesi = (SELECT seviye FROM sinavlar WHERE id = '$a') ");
			
			while($al = mysql_fetch_object($q1)){
				array_push($sinavaGirmesiGerekenler,$al->id);	
			}
			
			//Sınava Girenler
			$q2 = mysql_query("SELECT ogrenci FROM cevaplar WHERE sinav = '$a' ");
			while($al = mysql_fetch_object($q2)){
				array_push($sinavaGirenler,$al->ogrenci);	
			}
			
			
			$fark = array_diff($sinavaGirmesiGerekenler,$sinavaGirenler);
			
			if (count($fark)>0){
				$yaz = "<table class='tablo_33' align='center'>
							<tr style='font-weight:bold;background-color:#000;color:#FFF'>
								<td colspan='4' align='center'>SINAVA GİRMEYENLER</td>
							</tr>
							<tr style='font-weight:bold;background-color:#000;color:#FFF'>
									<td>S.N.</td>
									<td>Okul No</td>
									<td>Ad</td>
									<td>Soyad</td>
							</tr>
						";
				$say = 1;
				$liste = implode('-',$fark);		
				foreach($fark as $kisi){
					$ogren = mysql_fetch_object(mysql_query("SELECT * FROM siniflisteleri WHERE id = '$kisi'"));
					$yaz .= "
								<tr>
									<td>$say</td>
									<td>$ogren->okulNo</td>
									<td>$ogren->ad</td>
									<td>$ogren->soyad</td>
								</tr>
							";
					$say++;		
				}
				$yaz .= "
							<tr style='background-color:#014164'>
								<td colspan='2' align='right' style='color:#FFF;font-weight:800'>Yeni Sınav Tarihi :</td>
								<td colspan='2'><input type='text' id='sinavTarihi_7' style='width: 300px; padding: 3px; margin-left: 5px;'/></td>
							</tr>
							<tr style='background-color:#014164'>
								<td colspan='2' align='right' style='color:#FFF;font-weight:800'>Yeni Sınav Saati :</td>
								<td colspan='2'><input type='text' id='sinavSaati_7' style='width: 300px; padding: 3px; margin-left: 5px;'/></td>
							</tr>
							<tr>
								<td colspan='4' align='center'>
									<input type='hidden' value='$a' id='sinav_35' />
									<input type='hidden' value='$liste' id='liste_35' />
									<input type='button' value='Yeni Şifre Tanımla' id='btn_yeniSifreTanimla_35'/>
								</td>
							</tr>
						</table>";
			}else{
				$yaz = 'Bu sınava sınıf listesindeki bütün öğrenciler girmiştir.';
			}
		}else{
			$yaz = 'Bu sınav sistemde bulunmamaktadır.';	
		}
		
		unset($_POST);
		echo $yaz;
	}
?>