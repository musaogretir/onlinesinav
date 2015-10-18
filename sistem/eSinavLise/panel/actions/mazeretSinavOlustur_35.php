<?php
	require_once("headerActions.php");
	require_once("../class/connect.php");

	$msg = '';
	
	$veri = explode(';',$_SESSION['sinavBilgileri']);
	
	$g = mysql_fetch_object(mysql_query("SELECT * FROM sinavlar WHERE id = '".$veri[0]."'"));
	
	if ($g->id){						
		
			date_default_timezone_set('Europe/Istanbul');
			$baslangic = strtotime("$veri[1] $veri[2]")-300; //Sinav başlama saatinden 5 dk önce şifre aktif
			$bitis     = $baslangic + 300 + ($g->sinavSuresi*60); //Sinav bitiminde şifre iptal
	

			$q1 = mysql_query("INSERT INTO sinavlar VALUES(
															DEFAULT,
															'$g->id',
															'$g->ogretimYili',
															'$g->donem',
															'$g->sinavTuru',
															'$g->ogretmen',
															'$g->sinavTarihi',
															'$g->sinavSaati',
															'$g->sinavSuresi',
															'$g->sinavAciklamasi',
															'$g->bolum',
															'$g->dal',
															'$g->ders',
															'$g->seviye',
															'$g->sinavSorulari',
															'1',
															'0')
								");
			
		
			foreach($_SESSION['mazeretSifreler'] as $kisi){
				$veri1 = explode('-',$kisi);
				$q2 = mysql_query("UPDATE sifreler SET sifre = '$veri1[1]', gecerlilikBaslangic = '$baslangic', gecerlilikBitis = '$bitis' WHERE 
								   sinav = '$g->id' AND ogrenci = '$veri1[0]'");
			}
			
			if ($q1){
				$msg = "Sınav oluşturuldu.";	
			}else{
				$msg = "Bir hata oluştu.<br/>Sistem yöneticinize başvurunuz.";
			}
		
	}else{
		$msg = "Bilgiler eksik.<br/>Sistem yöneticinize başvurunuz.";	
	}
	
	
	echo $msg;
?>