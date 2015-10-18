<?php
	require_once("class/connect.php");
	require_once("class/session.php");
	require_once("class/araclar.php");
	
	if ($_POST){
		session_start();
		
		$u = mysql_real_escape_string(trim($_POST["u"]));
		$p = mysql_real_escape_string(trim($_POST["p"]));
		$c = mysql_real_escape_string(trim($_POST["c"]));
		
		if ($c == $_SESSION['captcha']){
			if (strlen($u)>=5){
				if (strlen($p)>=6){
					$r = mysql_fetch_object(mysql_query("SELECT * FROM kullanicilar WHERE kullaniciAdi='$u'"));
										
					if ($r->bloke == 0){
						
						if ($r->sifre == $p){
							$Session = new Session(30); 
							
							$x1= mysql_fetch_object(mysql_query("SELECT * FROM ogretimyili WHERE aktif=1"));
							$x2= mysql_fetch_object(mysql_query("SELECT * FROM donemler WHERE aktif='1'"));
							
							
							$user 	 = array(
							  'userId' => $r->id,
							  'userName' => $u,
							  'charges' => $r->yetkiler,
							  'ygd' =>0, //Yetkisiz alanlara giriş denemesi
							  'oy' =>$x1->ogretimYili,
							  'dnm' =>$x2->donem
							);
							
							$Session->register('gecerliKullanici', $user);
							
							/*Log Bilgilerini Kaydet
							  -1 : Sisteme Giriş Yapıldı
							*/
							date_default_timezone_set('Europe/Istanbul');
							$araclar = new araclar();
							$log = array(	"id"=>"DEFAULT",
											"kullanici"=>$user['userId'],
											"girisTarihi"=>date("U"),
											"ipAdresi"=>$araclar->get_real_ip(),
											"yapilanIslem"=>-1
										);
														
							$msg = "OK";
						}else{
							$msg = "Hatalı kullanıcı adı veya şifre.";
						}
					}else{
						$msg = "Hesabınız bloke edilmiştir.<br/>Sistem yöneticisine müracaat ediniz.";
					}
					}else{
					$msg = "Şifrenizi giriniz.";
				}
				}else{
				$msg = "Kullanıcı adını giriniz.";
			}
			}else{
			$msg = "Hatalı güvenlik kodu.";
		}
		
		echo $msg;
	}
?>