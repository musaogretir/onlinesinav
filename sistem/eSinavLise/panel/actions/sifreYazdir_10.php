<?php
	require_once("headerActions.php");
	require_once("../class/connect.php");
	
	if ($_GET["sinav"]){
		
		$s = base64_decode(base64_decode($_GET["sinav"]));
		
		$arrayData = mysql_query("SELECT * FROM sifreler WHERE sinav = '$s'");
		
		//Tablo Üst Bilgileri
		$q7 = @mysql_fetch_object(mysql_query("SELECT dersler.dersAdi,sinavlar.sinavTarihi,sinavlar.sinavSaati,sinifseviyeleri.seviye,dallar.dal,kullanicilar.ad,kullanicilar.soyad FROM sinavlar INNER JOIN dersler ON dersler.id = sinavlar.ders INNER JOIN kullanicilar ON kullanicilar.id=sinavlar.ogretmen INNER JOIN dallar ON sinavlar.dal = dallar.id INNER JOIN sinifseviyeleri ON sinifseviyeleri.id = sinavlar.seviye WHERE sinavlar.id = '$s' "));
		
		
		$msg = '
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>SINAV ŞİFRE BİLGİLERİ</title>
				</head>				
				<body>		
				';
		$msg.= "<table border='1' style='margin:10px auto 10px auto'>";
		$msg.= "<tr height='30' style='background-color:#CFC'>
					<td colspan='2' align='right'><b>SINAV :</b></td>
					<td colspan='3'>$q7->dersAdi <font color='red'>[$q7->dal - $q7->seviye]</font></td>
				<tr/>
				<tr height='30' style='background-color:#CFC'>
					<td colspan='2' align='right'><b>TARİH :</b></td>
					<td colspan='3'>$q7->sinavTarihi $q7->sinavSaati</td>
				<tr/>
				<tr height='30' style='background-color:#CFC'>
					<td colspan='2' align='right'><b>ÖĞRETMEN :</b></td>
					<td colspan='3'>$q7->ad $q7->soyad</td>
				<tr/>
				<tr height='30' style='background-color:#CFC'>
						<td width='50' align='center'><b>S.N.</b></td>
						<td width='150' align='center'><b>OKUL NO</b></td>
						<td width='150' align='center'><b>AD</b></td>
						<td width='150' align='center'><b>SOYAD</b></td>
						<td width='150' align='center'><b>ŞİFRE</b></td>
				   </tr>
				";
		$sn=1;		
		while($row = mysql_fetch_array($arrayData)){
			$o1 = mysql_fetch_object(mysql_query("SELECT * FROM siniflisteleri WHERE id = '".$row['ogrenci']."'"));
			$msg.="<tr height='30' style='background-color:#FFF'>
						<td width='50' align='center'>$sn</td>
						<td width='150' align='center'>".$o1->okulNo."</td>
						<td width='150'>".$o1->ad."</td>
						<td width='150'>".$o1->soyad."</td>
						<td width='150' align='center'><b>".$row['sifre']."</b></td>
				   </tr>";
			$sn++;	   
		}
		$msg .= "<tr>
					<td colspan='5' align='center'>
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