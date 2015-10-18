<?php
require_once("../class/connect.php");
require_once("headerActions.php");
	
	
	if ($_GET["sinav"]){
		
		$s = base64_decode($_GET["sinav"]);
		
		$arrayData = mysql_query("SELECT * FROM notlar WHERE sinav = '$s'");
		
		//Tablo Üst Bilgileri
		$q = mysql_fetch_object(mysql_query("SELECT dersler.dersAdi, sinavlar.sinavTarihi, sinavlar.sinavSaati, sinifseviyeleri.seviye, ogretimturu.tur, kullanicilar.ad, kullanicilar.soyad FROM sinavlar INNER JOIN ogretimturu ON ogretimturu.tur = sinavlar.ogretimTuru INNER JOIN dersler ON dersler.id = sinavlar.ders INNER JOIN kullanicilar ON kullanicilar.id = sinavlar.ogretimGorevlisi INNER JOIN sinifseviyeleri ON sinifseviyeleri.id = sinavlar.seviye WHERE sinavlar.id = '$s' "));
		
		
		$msg = '
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>SINAV DEĞERLENDİRME BİLGİLERİ</title>
				</head>				
				<body>		
				';
		$msg.= "<table border='1' style='margin:10px auto 10px auto' align='center'>";
		$msg.= "<tr height='30' style='background-color:#CFC'>
					<td colspan='2' align='right'><b>SINAV :</b></td>
					<td colspan='6'>$q->dersAdi <font color='red'>[$q->tur - $q->seviye]</font></td>
				<tr/>
				<tr height='30' style='background-color:#CFC'>
					<td colspan='2' align='right'><b>TARİH :</b></td>
					<td colspan='6'>$q->sinavTarihi $q->sinavSaati</td>
				<tr/>
				<tr height='30' style='background-color:#CFC'>
					<td colspan='2' align='right'><b>ÖĞRETİM GÖREVLİSİ :</b></td>
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
		$sn=1;		
		while($row = mysql_fetch_array($arrayData)){
			$q3 = mysql_fetch_object(mysql_query("SELECT * FROM siniflisteleri WHERE id = '".$row['ogrenci']."'"));
			$msg .= "<tr>
						<td align='center'>$sn</td>
						<td align='center'>$q3->okulNo</td>
						<td>$q3->ad</td>
						<td>$q3->soyad</td>
						<td align='center'>".$row['dogruSayisi']."</td>
						<td align='center'>".$row['yanlisSayisi']."</td>
						<td align='center'>".$row['bosSayisi']."</td>
						<td align='center'>".$row['puan']."</td>
					</tr>";
			$sn++;	   
		}
		$msg .= "<tr>
					<td colspan='8' align='center'>
						<input type='button' value='Yazdır' onclick='window.print()'/>
					</td>
				 </tr>
				";
		$msg .= "</table></body></html>";
	}
	else{
		$msg = "Eksik parametre.<br/>Sistem yöneticinize başvurunuz.";	
	}

	echo "$msg";
?>