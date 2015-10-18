<?php
	require_once("headerActions.php");
	require_once("../class/connect.php");

	if ($_POST){
		$msg = '';
		$yeniSifre = array();
		
		$a = trim($_POST["a"]);
		$b = explode('-',trim($_POST["b"]));
		$c = trim($_POST["c"]);
		$d = trim($_POST["d"]);
		
		$ogren = mysql_fetch_object(mysql_query("SELECT * FROM sinavlar WHERE id = '$a'"));
			
		date_default_timezone_set('Europe/Istanbul');
		$baslangic = strtotime("$c $d"); //Sinav başlama saatinde şifre aktif
		$bitis     = $baslangic + ($ogren->sinavSuresi*60); //Sinav bitiminde şifre iptal
				
		foreach($b as $kisi){
			$yeniSifre[] = $kisi.'-'.mt_rand(100000,999999);
		}
		
		$_SESSION['mazeretSifreler'] = $yeniSifre;
		$_SESSION['sinavBilgileri']  = $a.';'.$c.';'.$d; //Sınav - Sınav Tarihi - Sınav Saati
		
		//Şifreleri Tablo Haline Getir
		$q7 = mysql_fetch_object(mysql_query("SELECT dersler.dersAdi, sinavlar.sinavTarihi, sinavlar.sinavSaati, sinifseviyeleri.seviye, dallar.dal, kullanicilar.ad, kullanicilar.soyad FROM sinavlar INNER JOIN dersler ON dersler.id = sinavlar.ders INNER JOIN kullanicilar ON kullanicilar.id=sinavlar.ogretmen INNER JOIN dallar ON sinavlar.dal = dallar.id INNER JOIN sinifseviyeleri ON sinifseviyeleri.id=sinavlar.seviye WHERE sinavlar.id = '$a' "));
		$sn=1;
		$msg = "<table border='1' style='margin:10px auto 10px auto'>";
		$msg.= "<tr height='30' style='background-color:#CFC'>
					<td colspan='2' align='right'><b>SINAV :</b></td>
					<td colspan='3'>$q7->dersAdi <font color='red'>[$q7->dal - $q7->seviye]</font><font color='navy'><b> Mazeret</b></font></td>
				<tr/>
				<tr height='30' style='background-color:#CFC'>
					<td colspan='2' align='right'><b>TARİH :</b></td>
					<td colspan='3'>$c $d</td>
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
				
		foreach($yeniSifre as $row){
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
								<input type='button' value='Şifreleri Kaydet & Yazdır' id='btn_sifre_Kaydet_35'/>
							</td>
						 </tr>
						";
				$msg .= "</table>";
		
	}else{
		$msg = "Bilgiler eksik.<br/>Sistem yöneticinize başvurunuz.";	
	}
	
	echo $msg;
	
?>