<?php
	require_once("headerActions.php");
	require_once("../class/connect.php");
	
	if (isset($_SESSION["ogrenciListesi_30"]) && $_POST["bilgi_30"]){
		$a = explode("-",$_POST["bilgi_30"]);
		
		
		$r1 = mysql_fetch_object(mysql_query("SELECT * FROM ogretimyili WHERE aktif=1"));
		$r2 = mysql_fetch_object(mysql_query("SELECT * FROM donemler WHERE aktif=1"));
		
		date_default_timezone_set('Europe/Istanbul');
		$insertData = array(
							"id"=>"DEFAULT",
							"ogretimYili"=>$r1->id,
							"donem"=>$r2->id,
							"bolum"=>$a[0],
							"dal"=>$a[2],
							"sinifSeviyesi"=>$a[1],
							"okulNo"=>"",
							"ad"=>"",
							"soyad"=>"",
							"ekleyen"=>$_SESSION['gecerliKullanici']['userId'],
							"eklenmeTarihi"=>date('U')
						);
		
		
		function adSoyadAyir($isim){
			$u = strlen($isim)-1;
			$k = 0;
			for($i=$u;$i>=0;$i--){
				if (substr($isim,$i,1) == " "){ $k=$i;break;}
			}
			return array("ad"=>substr($isim,0,$k),"soyad"=>substr($isim,$k,($u-$k+1)));
		}
		
		$sayac = 0;
		foreach($_SESSION['ogrenciListesi_30'] as $row){ //Listeyi veritabanına kaydet
			$temp = explode("-",$row);
			if (isset($temp[0]) && isset($temp[1]) && isset($temp[2])){	
				$insertData['okulNo']		= trim($temp[1]);
				$d 							= adSoyadAyir(trim($temp[2]));
				$insertData['ad']			= $d['ad'];
				$insertData['soyad']		= $d['soyad'];
				
				$ekle = "INSERT INTO siniflisteleri VALUES(";
				foreach($insertData as $data){
					$ekle .="'$data',";
				}
				$ekle = trim($ekle,',').')';
				if (mysql_query($ekle)) $sayac++;
			}
		}
		
		
		$msg = "<b><u>Kayıt Bilgileri:</u></b><br/><br/>";
		$msg .= "$sayac Adet öğrenci eklendi.<br/>";
		
		unset($_SESSION["ogrenciListesi_30"]); //Listeyi temizle.
	}
	else{
		$msg = "Eksik parametre.<br/>Sistem yöneticinize başvurunuz.";	
	}

	echo "$msg";
?>