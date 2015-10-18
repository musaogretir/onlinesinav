<?php
	require_once("headerActions.php");
	require_once("../class/connect.php");
	
	if ($_POST)
	{
		session_start();
		$msg = "";
		$bilgiler = array();
		foreach($_POST as $a=>$b){
			$x[$a] = trim($b);
		}
		
		$db = mysql_fetch_object(mysql_query("SELECT * FROM kullanicilar WHERE kullaniciAdi = '".$x['kKullanici']."'"));
		
		if (!$db->id)
		{
			if ($x["kSifre"]==$x["kSifreOnay"])
			{
				date_default_timezone_set('Europe/Istanbul');
				$y = array(
						"id"=>"DEFAULT",
						"ad"=>$x['kAd'],
						"soyad"=>$x['kSoyad'],
						"kullaniciAdi"=>$x['kKullanici'],
						"sifre"=>$x['kSifre'],
						"unvan"=>$x['kUnvan'],
						"yetkiler"=>'0',
						"ekleyen"=>$_SESSION['gecerliKullanici']['userId'],
						"eklenmeTarihi"=>date('U'),
						"bloke"=>0,
						"blokeNedeni"=>0,
						"blokeZamani"=>0
				); 
				
				$q = "INSERT INTO kullanicilar VALUES(";
				foreach($y as $data){
					$q.="'$data',";
				}
				$q = trim($q,',').')';
				
				if (mysql_query($q)){
					$msg = "<b>".$x['kKullanici']."</b> Kullanıcısı Eklendi.<br/><b>Kullanıcı Yetkilendirme</b> Ekranından yetki tanımlaması yapınız.";	
				}else{
					$msg ="Bir hata oluştu. Tekrar deneyiniz. <br/>".mysql_error();	
				}
			}else{
				$msg = "Şifreler uyuşmuyor.";
			}
		}else{
			$msg = "Bu kullanıcı adı sistemde mevcut.<br/>Başka bir kullanıcı adı seçiniz.";
		}
		echo $msg;
	}
?>