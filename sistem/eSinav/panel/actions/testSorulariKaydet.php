<?php
require_once("../class/connect.php");
require_once("headerActions.php");
	
	
	if (isset($_SESSION["testSorular_5"]) && $_POST["bilgi_5"]){
		$a = explode("-",$_POST["bilgi_5"]);
		
		date_default_timezone_set('Europe/Istanbul');
		$insertData = array(
							"id"=>"DEFAULT",
							"tur"=>$a[2],
							"bolum"=>$a[0],
							"ders"=>$a[1],
							"kod"=>'',
							"dil"=>0,
							"soruMetni"=>"",
							"soruGorseli"=>"",
							"secA"=>"",
							"secB"=>"",
							"secC"=>"",
							"secD"=>"",
							"secE"=>"",
							"dogruCevap"=>"",
							"ekleyen"=>$_SESSION["gecerliKullanici"]["userId"],
							"eklenmeTarihi"=>date("U"),
							"paylasimDurumu"=>0
						);
		
		
		$sayac = 0;
		foreach($_SESSION["testSorular_5"] as $row){ //Soruları veritabanına kaydet
			$temp = explode("XXX***XXX",$row);
			if (count($temp) == 6) //4 Seçenekli sorular
			{
				if (isset($temp[0]) && isset($temp[1]) && isset($temp[2]) && isset($temp[3]) && isset($temp[4]) && isset($temp[5])){
					$insertData["soruMetni"]	= mysql_real_escape_string(trim($temp[0]));	
					$insertData["secA"]			= mysql_real_escape_string(trim($temp[1]));
					$insertData["secB"]			= mysql_real_escape_string(trim($temp[2]));
					$insertData["secC"]			= mysql_real_escape_string(trim($temp[3]));
					$insertData["secD"]			= mysql_real_escape_string(trim($temp[4]));
					$insertData["dogruCevap"]	= mysql_real_escape_string(trim($temp[5]));
					
					$ekle = "INSERT INTO testsorulari VALUES(";
					foreach($insertData as $data){
							$ekle.="'$data',";
					}
					$ekle = trim($ekle,',').")";
					if (mysql_query($ekle)) $sayac++;
				}
			}
			
			if (count($temp) == 7) //5 Seçenekli sorular
			{
				if (isset($temp[0]) && isset($temp[1]) && isset($temp[2]) && isset($temp[3]) && isset($temp[4]) && isset($temp[5]) && isset($temp[6]))		{
					$insertData["soruMetni"]	= (trim($temp[0]));	
					$insertData["secA"]			= (trim($temp[1]));
					$insertData["secB"]			= (trim($temp[2]));
					$insertData["secC"]			= (trim($temp[3]));
					$insertData["secD"]			= (trim($temp[4]));
					$insertData["secE"]			= (trim($temp[5]));
					$insertData["dogruCevap"]	= (trim($temp[6]));
					
					$ekle = "INSERT INTO testsorulari VALUES(";
					foreach($insertData as $data){
							$ekle.="'$data',";
					}
					$ekle = trim($ekle,',').")";
					if (mysql_query($ekle)) $sayac++;
				}
			}
		}
		
		
		$msg = "<b><u>Kayıt Bilgileri:</u></b><br/><br/>";
		$msg .= "$sayac Adet soru eklendi.<br/>";
		
		unset($_SESSION["testSorular_5"]); //Listeyi temizle.
	}
	else{
		$msg = "Eksik parametre.<br/>Sistem yöneticinize başvurunuz.";	
	}

	echo "$msg";
?>