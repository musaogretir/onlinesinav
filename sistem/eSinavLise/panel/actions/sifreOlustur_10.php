<?php
	require_once("headerActions.php");
	require_once("../class/connect.php");

	if ($_POST){
		$a = trim($_POST["a"]);
			
		$q1 = mysql_fetch_object(mysql_query("SELECT bolum,seviye,dal FROM sinavlar WHERE id='$a'"));
		$q2 = "SELECT * FROM siniflisteleri WHERE ogretimYili = (SELECT id FROM ogretimyili WHERE aktif=1) AND donem = (SELECT id FROM donemler WHERE aktif = 1) AND bolum = '$q1->bolum' AND sinifSeviyesi = '$q1->seviye' AND dal = '$q1->dal'";
		$q3 = mysql_num_rows(mysql_query("SELECT * FROM sifreler WHERE sinav = '$a'"));
		$q4 = mysql_fetch_object(mysql_query("SELECT * FROM sinavlar WHERE id = '$a'"));
		
		date_default_timezone_set('Europe/Istanbul');
		$baslangic = strtotime("$q4->sinavTarihi $q4->sinavSaati"); //Sinav başlama saatinde şifre aktif
		$bitis     = $baslangic + ($q4->sinavSuresi*60); //Sinav bitiminde şifre iptal
				
		if (mysql_num_rows(mysql_query($q2))>0){ //Sınıf listesi girilmiş ise
			
			if (!$q3){
				$q5 = mysql_fetch_object(mysql_query("SELECT bolum,seviye,dal FROM sinavlar WHERE id='$a'"));
				$q6 = mysql_query("SELECT * FROM siniflisteleri WHERE ogretimYili = (SELECT id FROM ogretimyili WHERE aktif=1) AND donem = (SELECT id FROM donemler WHERE aktif = 1) AND bolum = '$q1->bolum' AND sinifSeviyesi = '$q5->seviye' AND dal = '$q5->dal'");
				
				while($al = mysql_fetch_object($q6)){ //Sınıf listesini getir
					$yeniSifre = mt_rand(100000,999999);
					$insertData = $al->id."-".$yeniSifre;
					$hidden1   .= $insertData.";"; 
					$insertArray[] = $insertData;
				}
				$hidden1 = base64_encode(base64_encode(trim($hidden1,"-")));
				$hidden2 = base64_encode(base64_encode($a."-".$baslangic."-".$bitis));
				//Şifreleri Tablo Haline Getir
				$q7 = mysql_fetch_object(mysql_query("SELECT dersler.dersAdi,sinavlar.sinavTarihi,sinavlar.sinavSaati,sinifseviyeleri.seviye,dallar.dal,kullanicilar.ad,kullanicilar.soyad FROM sinavlar INNER JOIN dersler ON dersler.id = sinavlar.ders INNER JOIN kullanicilar ON kullanicilar.id=sinavlar.ogretmen INNER JOIN dallar ON sinavlar.dal = dallar.id INNER JOIN sinifseviyeleri ON sinifseviyeleri.id=sinavlar.seviye WHERE sinavlar.id = '$a' "));
				$sn=1;
				$msg = "<table border='1' style='margin:10px auto 10px auto'>";
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
				foreach($insertArray as $row){
					$v  = explode("-",$row);
					$o1 = mysql_fetch_object(mysql_query("SELECT * FROM siniflisteleri WHERE id = '".$v[0]."'"));
					$msg.="<tr height='30' style='background-color:#FFF'>
						   		<td width='50' align='center'>$sn</td>
								<td width='150'>".$o1->okulNo."</td>
								<td width='150'>".$o1->ad."</td>
								<td width='150'>".$o1->soyad."</td>
								<td width='150' align='center'><b>".$v[1]."</b></td>
						   </tr>";
					$sn++;	   
				}
				$msg .= "<tr>
							<td colspan='5' align='center'>
								<input type='button' value='Şifreleri Kaydet & Yazdır' id='btn_sifre_Kaydet_10'/>
							</td>
						 </tr>
						";
				$msg .= "</table>";
				$msg .= "<input type='hidden' name='h1_10' id='h1_10' value='$hidden1'/>
						 <input type='hidden' name='h2_10' id='h2_10' value='$hidden2'/>
						";
			}else{
				
				$arrayData = mysql_query("SELECT * FROM sifreler WHERE sinav = '$a'");
		
				//Tablo Üst Bilgileri
				$q7 = mysql_fetch_object(mysql_query("SELECT dersler.dersAdi, sinavlar.sinavTarihi, sinavlar.sinavSaati, sinavlar.seviye, dallar.dal, kullanicilar.ad, kullanicilar.soyad FROM sinavlar INNER JOIN dersler ON dersler.id = sinavlar.ders INNER JOIN kullanicilar ON kullanicilar.id = sinavlar.ogretmen INNER JOIN dallar ON sinavlar.dal = dallar.dal WHERE sinavlar.id = '$a' "));
				
				$msg = "<div class='uyariContainer'>
							<div>Bu sınav için daha önce şifre oluşturulmuştur.</div>
						</div>";
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
								<td width='150'>".$o1->okulNo."</td>
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
				$msg .= "</table>";
			
			}
		}else{	
			$msg = "<div class='uyariContainer'>
						<div>Bu sınıf için sınıf listesi yüklenmemiştir.<br/>Sistem yöneticinize başvurunuz.</div>
					</div>";
		}
		
	}else{
		$msg = "Bilgiler eksik.<br/>Sistem yöneticinize başvurunuz.";	
	}
	
	echo $msg;
	
?>