<?php
	require_once("headerActions.php");
	require_once("../class/connect.php");
	
	if ($_GET){
		$id = base64_decode(base64_decode($_GET['sinav']));
		
		$sorugetir = mysql_fetch_object(mysql_query("SELECT * FROM sinavlar WHERE id = '$id'"));
		$sorular   = explode("-",$sorugetir->sinavSorulari);
		
		$_SESSION['soruListesi'] = $sorular;
		
		function siralama($v){
			$sl = explode('-',$v);
			$ey  = ''; 
			foreach($sl as $x){
				$ey .=(array_search($x,$_SESSION['soruListesi'])+1).'-';	
			}
			return trim($ey,'-');
		}
		
		$sayac = 1;
		$goster = " <div class='raporTabloContainer'>
		 			<table class='cevapTablosu' align='center'>
						   <tr>
							<td colspan='2' align='center'><h2>SORULAR</h2></td>
						   </tr>
				  ";
		foreach($sorular as $soru){
				$soruBilgileri = mysql_fetch_object(mysql_query("SELECT * FROM testsorulari WHERE id = '$soru'"));
				$goster.=" <tr style='background-color:#ccc'>
							<td align='center'><b>Soru $sayac :</b></td><td align='justify' width='500'>$soruBilgileri->soruMetni</td>
						   </tr>
						   <tr>
							<td align='center'>A)</td><td align='justify'>$soruBilgileri->secA</td>
						   </tr>
						   <tr>
							<td align='center'>B)</td><td align='justify'>$soruBilgileri->secB</td>
						   </tr>
						   <tr>
							<td align='center'>C)</td><td align='justify'>$soruBilgileri->secC</td>
						   </tr>
						   <tr>
							<td align='center'>D)</td><td align='justify'>$soruBilgileri->secD</td>
						   </tr>
						   ";
				if ($soruBilgileri->secE){
					$goster.="
							<tr>
								<td align='center'>E)</td><td align='justify'>$soruBilgileri->secE</td>
						    </tr>
							";
				}
				$goster.="
							<tr>
								<td align='right'><b>Doğru Cevap :</b></td><td align='justify'>$soruBilgileri->dogruCevap</td>
						    </tr>
							";
			$sayac++;	
		}
		$goster.="</table></div>";
		
		
		$q1 = mysql_query("SELECT * FROM cevaplar WHERE sinav = '$id'");
		
		echo '
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<link href="../css/yonetim.css" rel="stylesheet" type="text/css" media="all" />
				<title>SINAV RAPORLARI</title>
				</head>				
				<body>';
		
		echo '<div style="margin:auto;width:650px;">
				'.$goster.'
			  </div>';
		echo '			
				<div style="margin:auto;width:450px;">
			 ';
		
		while($al = mysql_fetch_object($q1)){
			$yaz = "<div class='raporTabloContainer'>
					<table class='cevapTablosu' align='center' width='500'>";
			$q2 = mysql_fetch_object(mysql_query("SELECT bolumler.bolumAdi, sinifseviyeleri.seviye, dallar.dal FROM sinavlar INNER JOIN bolumler ON sinavlar.bolum=bolumler.id INNER JOIN sinifseviyeleri ON sinifseviyeleri.id=sinavlar.seviye INNER JOIN dallar ON sinavlar.dal=dallar.id WHERE sinavlar.ogretimYili = (SELECT id FROM ogretimyili WHERE aktif=1) AND sinavlar.donem = (SELECT id FROM donemler WHERE aktif=1)"));
			$q3 = mysql_fetch_object(mysql_query("SELECT ad,soyad,okulNo FROM siniflisteleri WHERE id ='$al->ogrenci'"));
			$yaz.=" <tr>
						<td align='right'><b>Bölüm, Sınıf, Dal :</b></td><td colspan='2'>$q2->bolumAdi $q2->seviye $q2->dal</td>
					</tr>
					<tr>
						<td align='right'><b>Adı, Soyadı :</b></td><td colspan='2'>$q3->ad $q3->soyad</td>
					</tr>
					<tr>
						<td align='right'><b>Okul No :</b></td><td colspan='2'>$q3->okulNo</td>
					</tr>
					<tr>
						<td align='right'><b>Soru Sıralaması :</b></td><td colspan='2' width='300'>".siralama($al->soruSiralamasi)."</td>
					</tr>	
					<tr>
						<td colspan='3'><b>Öğrenci Cevapları :</b></td>
					</tr>
					";
			$ss = explode("-",$al->soruSiralamasi);
			$c  = explode("-",$al->ogrenciCevaplari);
			$say=0;
			$ds =0;
			$bs =0;
			$ys =0;
			foreach($c as $index=>$cvp){				
				$q4 = mysql_fetch_object(mysql_query("SELECT dogruCevap FROM testsorulari WHERE id = '$ss[$index]'"));
				if ($cvp =='X') {$cevap = "Boş";$bs++;} else $cevap = $cvp;
				if ($cevap != "Boş"){
					if ($q4->dogruCevap == $cevap) {$durum = '+';$ds++;} else {$durum = '-';$ys++;}
				}
				else
				{
					$durum = '-';	
				}
				
				$yaz.="<tr>
							<td align='center'>".($index+1)."</td>
							<td align='center'>$cevap</td>
							<td align='center'>$durum</td>
					   </tr>";		   
			}
			$soruSayisi = $ds + $ys + $bs;
			$puan  = (100 / $soruSayisi) * $ds;
			$yaz.="<tr>
						<td align='right'><b>Doğru Sayısı :</b></td><td colspan='2'>$ds</td>
				   </tr>
				   <tr>
						<td align='right'><b>Yanlış Sayısı :</b></td><td colspan='2'>$ys</td>
				   </tr>
				   <tr>
						<td align='right'><b>Boş Sayısı :</b></td><td colspan='2'>$bs</td>
				   </tr>
				   <tr>
						<td align='right'><b>PUAN :</b></td><td colspan='2'>$puan</td>
				   </tr>
				   </table>
				   </div>
				   ";
			echo $yaz;
		}
		echo "<div class='temizle'></div>
			  <div align='center'>
			  		<input type='button' value='Yazdır' onclick='window.print();'/>
			  </div>
			  </div>
			  </body></html>
			 ";
		
		unset($_SESSION['soruListesi']);
	}else{
		$msg = "Eksik parametre.<br/>Sistem yöneticinize başvurunuz.";	
	}
?>