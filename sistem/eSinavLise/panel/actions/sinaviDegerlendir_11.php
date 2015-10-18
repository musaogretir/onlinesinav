<?php
	require_once("headerActions.php");
	require_once("../class/connect.php");
	
	if ($_POST){
		$id = $_POST['a'];
		
		$q1 = mysql_query("SELECT * FROM cevaplar WHERE sinav = '$id'");
		$s  = array();
		$t  = array();
		
		while($al = mysql_fetch_object($q1)){
			$s[$al->ogrenci] 		= $al->ogrenciCevaplari;
			$t[$al->ogrenci] 		= $al->soruSiralamasi;
		}
				
		$q2 = mysql_fetch_object(mysql_query("SELECT sinavSorulari FROM sinavlar WHERE id = '$id'"));
		
		$soruListesi = explode("-",$q2->sinavSorulari);
		$dogruCevaplar = array();
		
		foreach($soruListesi as $soru){
			$temp = mysql_fetch_object(mysql_query("SELECT * FROM testsorulari WHERE id = '".$soru."'"));
			$dogruCevaplar[$temp->id] = $temp->dogruCevap;
		}
		
		//Cevap Kontrol Aşaması
		$sayac				= 1;
		$dogruSayisi		= 0;
		$yanlisSayisi		= 0;
		$bosSayisi			= 0;
		$puan				= 0;
		$toplamSoruSayisi	= count($dogruCevaplar);
		$herBirSorununPuani	= (100 / $toplamSoruSayisi); 
		
		$q = mysql_fetch_object(mysql_query("SELECT sinavlar.id, sinavlar.sinavTarihi, sinavlar.sinavSaati, sinifseviyeleri.seviye, dersler.dersAdi, kullanicilar.ad, kullanicilar.soyad,dallar.dal FROM sinavlar INNER JOIN dersler ON dersler.id = sinavlar.ders INNER JOIN sinifseviyeleri ON sinifseviyeleri.id = sinavlar.seviye INNER JOIN kullanicilar ON kullanicilar.id = sinavlar.ogretmen INNER JOIN dallar ON dallar.id=sinavlar.dal WHERE ogretmen = '".$_SESSION['gecerliKullanici']['userId']."' AND sinavDegerlendirmeDurumu = 0 AND donem = (SELECT id FROM donemler WHERE aktif = 1) AND ogretimYili = (SELECT id FROM ogretimyili WHERE aktif = 1)"));
		
		$msg = "<table border='1' style='margin:10px auto 10px auto'>";
		$msg.= "<tr height='30' style='background-color:#CFC'>
					<td colspan='2' align='right'><b>SINAV :</b></td>
					<td colspan='6'>$q->dersAdi <font color='red'>[$q->dal - $q->seviye]</font></td>
				<tr/>
				<tr height='30' style='background-color:#CFC'>
					<td colspan='2' align='right'><b>TARİH :</b></td>
					<td colspan='6'>$q->sinavTarihi $q->sinavSaati</td>
				<tr/>
				<tr height='30' style='background-color:#CFC'>
					<td colspan='2' align='right'><b>ÖĞRETMEN :</b></td>
					<td colspan='6'>$q->ad $q->soyad</td>
				<tr/>
				<tr height='30' style='background-color:#CFC'>
						<td width='50' align='center'><b>S.N.</b></td>
						<td width='150' align='center'><b>OKUL NO</b></td>
						<td width='150' align='center'><b>AD</b></td>
						<td width='150' align='center'><b>SOYAD</b></td>
						<td width='100' align='center'><b>DOĞRU S.</b></td>
						<td width='100' align='center'><b>YANLIŞ S.</b></td>
						<td width='100' align='center'><b>BOŞ S.</b></td>
						<td width='100' align='center'><b>PUAN</b></td>
				   </tr>
				";
		
		foreach($s as $index=>$kisi){
			$temp = explode("-",$kisi);
			$temp2 = explode("-",$t[$index]);			
			foreach($temp as $siraNo=>$cevap){
				
				if ($cevap == $dogruCevaplar[$temp2[$siraNo]]) {
					$dogruSayisi++;
				}else{
					if ($cevap == 'X') {
						$bosSayisi++;
					}else{
						$yanlisSayisi++;	
					}
				}				
			}
			
			$puan = $herBirSorununPuani * $dogruSayisi;
			
			$_SESSION['notBilgisi'][$index] = $dogruSayisi."-".$yanlisSayisi."-".$bosSayisi."-".$puan;
			
			$q3 = mysql_fetch_object(mysql_query("SELECT * FROM siniflisteleri WHERE id = '$index' AND ogretimYili = (SELECT id FROM ogretimyili WHERE aktif = 1) AND donem = (SELECT id FROM donemler WHERE aktif = 1)"));
			$msg .= "<tr>
						<td align='center'>$sayac</td>
						<td align='center'>$q3->okulNo</td>
						<td>$q3->ad</td>
						<td>$q3->soyad</td>
						<td align='center'>$dogruSayisi</td>
						<td align='center'>$yanlisSayisi</td>
						<td align='center'>$bosSayisi</td>
						<td align='center'>$puan</td>
					</tr>";
			$sayac++;
			$dogruSayisi	= 0;
			$yanlisSayisi	= 0;
			$bosSayisi		= 0;	
			$puan			= 0;
		}
		$msg .= "<tr>
					<td colspan='8' align='center'>
						<input type='hidden' id='snv_11' value='".base64_encode($id)."'  />
						<input type='button' value='Kaydet & Yazdır' id='btn_Sinav_Degerlendirmesi_Kaydet_11'/>
					</td>
				 </tr>
				";
		$msg.= "</table>";
		echo $msg;
	}
	else{
		$msg = "Eksik parametre.<br/>Sistem yöneticinize başvurunuz.";	
	}
?>