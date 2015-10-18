<?php
	require_once("headerActions.php");
	require_once("../class/connect.php");

	if ($_POST){
		$msg = "";
		$sira = 1;
		$a = $_POST["a"];
		$array = array();
		$hidden = "";
		
		$q1 = mysql_fetch_object(mysql_query("SELECT bolum,seviye,dal FROM sinavlar WHERE id='$a'"));
		$q2 = mysql_query("SELECT * FROM siniflisteleri WHERE ogretimYili = (SELECT id FROM ogretimyili WHERE aktif=1) AND donem = (SELECT id FROM donemler WHERE aktif = 1) AND bolum = $q1->bolum AND sinifSeviyesi = $q1->seviye AND dal = $q1->dal");
		
		while($al = mysql_fetch_array($q2)){
			$veri = $al['id'].'-'.$al['okulNo'].'-'.$al['ad'].'-'.$al['soyad'];
			array_push($array,$veri);	
		}
		
		if (count($array))
		{
			shuffle($array);
			
			foreach($array as $row){
				$veri = explode("-",$row);			
				$msg .= "<div class='ogrenciBilgi_9'>
							<div class='siraNo_9'>$sira</div>
							<div class='ad_9'>".$veri[2]." ".$veri[3]."</div>
							<div class='no_9'>".$veri[1]."</div>
						 </div>
						";
				$hidden .= $veri[0]."-";
				$sira++;
			}
			
			$hidden = base64_encode(base64_encode(trim($hidden,"-")));
			$msg .= "
					 <div class='temizle'></div> 
					 <div class='altSayfaFormAlaniBilgiSatiri' align='center'>
					 <input type='hidden' value ='$hidden' name='od_9' id='od_9' />
					 <input type='button' value='Oturma Düzenini Kaydet' id='btn_Oturma_Düzeni_Kaydet_9'/>
					 </div>
					 ";
		}
		else
		{
				$msg = "Bu sınıf için öğrenci listesi yüklenmemiştir.<br/>Sistem yöneticinize başvurunuz.";
		}
	}else{
		$msg = "Bilgiler eksik.<br/>Sistem yöneticinize başvurunuz.";	
	}
	
	echo $msg;

?>