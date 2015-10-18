<?php
	require_once("headerActions.php");
	require_once("../class/connect.php");

	if ($_POST){
		$a = $_POST['a'];
		$msg = "";
		
		$q1 = mysql_query("SELECT bolumler.bolumAdi,dallar.dal,dersler.dersAdi,sinavlar.sinavTarihi,sinavlar.sinavSaati FROM sinavlar INNER JOIN bolumler ON bolumler.id = sinavlar.bolum INNER JOIN dallar ON dallar.id = sinavlar.dal INNER JOIN dersler ON dersler.id = sinavlar.ders WHERE sinavlar.ogretimYili = '$a' AND sinavlar.donem = (SELECT id FROM donemler WHERE aktif=1) AND sinavlar.ogretmen ='".$_SESSION['gecerliKullanici']['userId']."'");
		
		$sn=1;
		$yaz = "<div id='sinavlarim_34_container'>
					<div class='baslik_34'>
						<div style='width:20px'>S.N.</div>
						<div style='width:450px'>Bölüm - Dal - Ders</div>
						<div style='width:150px'>Sınav Tarihi</div>
						<div style='width:420px'>İşlemler</div>
					</tr>
			    ";
		while($al = mysql_fetch_object($q1)){
			$yaz.="<div class='satir_34'>
						<div style='width:20px'>$sn</div>
						<div style='width:450px'>$al->bolumAdi - $al->dal - $al->dersAdi</div>
						<div style='width:150px'>$al->sinavTarihi $al->sinavSaati</div>
						<div style='width:420px'>
							<a href='javascript:;'>Sınav Bilgileri</a>
							<a href='javascript:;'>Oturma Düzeni yazdır</a>
							<a href='javascript:;'>Şifre yazdır</a>
							<a href='javascript:;'>Değerlendirme Sonuçları</a>
						</div>
						<div class='temizle'></div>
				   </div>";
			
			$sn++;
		}
		$yaz.="</div>";
		echo $yaz;
		
	}else{
		$msg = "Bilgiler eksik.<br/>Sistem yöneticinize başvurunuz.";	
	}
	
	echo $msg;

?>