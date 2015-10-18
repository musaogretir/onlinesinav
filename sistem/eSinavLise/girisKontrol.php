<?php
	ini_set("display_errors",0);
	require_once("connect.php");
	require_once("class/session.php");
	require_once("class/araclar.php");
	
	if ($_POST){
		session_start();
		
		$ogrNo = mysql_real_escape_string(trim($_POST["ogrNo"]));
		$sifre = mysql_real_escape_string(trim($_POST["sifre"]));
		$sinTr = mysql_real_escape_string(trim($_POST["sinTr"]));
		$bolum = mysql_real_escape_string(trim($_POST["bolum"]));
		$ogTur = mysql_real_escape_string(trim($_POST["ogTur"]));
		$sinif = mysql_real_escape_string(trim($_POST["sinif"]));
		$ders  = mysql_real_escape_string(trim($_POST["ders"]));
		$ogGor = mysql_real_escape_string(trim($_POST["ogGor"]));
		$c	   = mysql_real_escape_string(trim($_POST["c"]));
		
		if ($c == $_SESSION['captcha']){
			
			$q1 = mysql_fetch_object(mysql_query("SELECT id FROM sinavlar WHERE sinavTuru = '$sinTr' AND bolum = '$bolum' AND ders = '$ders' AND ogretmen = '$ogGor' AND sinavDegerlendirmeDurumu = 0 AND seviye = '$sinif' AND ogretimYili = (SELECT id FROM ogretimyili WHERE aktif = 1) AND donem = (SELECT id FROM donemler WHERE aktif = 1)"));
	
			if ($q1->id){
					date_default_timezone_set('Europe/Istanbul');
					$simdi 	= date("U");				
					$q2 = mysql_fetch_object(mysql_query("SELECT id FROM siniflisteleri WHERE okulNo = '$ogrNo' AND ogretimYili = (SELECT id FROM ogretimyili WHERE aktif = 1) AND donem = (SELECT id FROM donemler WHERE aktif = 1)"));
					$q3 = mysql_num_rows(mysql_query("SELECT * FROM sifreler WHERE sinav = '$q1->id' AND sifre = '$sifre' AND ogrenci = '$q2->id' AND ".($simdi + 300).">gecerlilikBaslangic AND $simdi < gecerlilikBitis")); //5dk öncesinde girişe izin ver. {+300 sn}
					
					if ($q3){
							$q1 = mysql_fetch_object(mysql_query("SELECT * FROM sinavlar WHERE sinavTuru = '$sinTr' AND bolum = '$bolum' AND ders = '$ders' AND ogretmen = '$ogGor' AND seviye = '$sinif' AND sinavDegerlendirmeDurumu = 0  AND ogretimYili = (SELECT id FROM ogretimyili WHERE aktif = 1) AND donem = (SELECT id FROM donemler WHERE aktif = 1)"));
					
							$q2 = mysql_fetch_object(mysql_query("SELECT dersAdi FROM dersler WHERE id = '$ders'"));
					
							$q3 = mysql_fetch_object(mysql_query("SELECT * FROM siniflisteleri WHERE okulNo = '$ogrNo' AND ogretimYili = (SELECT id FROM ogretimyili WHERE aktif = 1) AND donem = (SELECT id FROM donemler WHERE aktif = 1)"));
					
							$q4 = mysql_num_rows(mysql_query("SELECT * FROM cevaplar WHERE sinav = '$q1->id' AND ogrenci = '$q3->id' AND oturumAcmaSayisi > 0"));
							
							$kalanSure		= 0;
							$aktifSoruID 	= 0;
							
							if ($q4>0){//Daha önce giriş yapmış ise
									$q5 = mysql_fetch_object(mysql_query("SELECT * FROM cevaplar WHERE sinav = '$q1->id' AND ogrenci = '$q3->id' AND oturumAcmaSayisi > 0"));
									date_default_timezone_set('Europe/Istanbul');
									$sinavZamani	= strtotime("$q1->sinavTarihi $q1->sinavSaati");
									$fark			= $q5->sonGirisZamani - $sinavZamani;
									$u 				= mysql_fetch_object(mysql_query("SELECT kalansure FROM kalansure WHERE sinav = '$q1->id' AND ogrenci = '$q3->id'"));
									
									if ((($u->kalansure*60)+date("U"))>($sinavZamani + $q1->sinavSuresi*60)){//Zaman kayıplarını tespit et
										$u->kalansure = (int)((($sinavZamani+($q1->sinavSuresi*60))-date("U"))/60+1);
									}
									
									if ($u->kalansure>0){
										date_default_timezone_set('Europe/Istanbul');
										$sg = date("U");
										$g = mysql_query("UPDATE cevaplar SET oturumAcmaSayisi = oturumAcmaSayisi + 1, sonGirisZamani = '$sg' WHERE sinav = '$q1->id' AND ogrenci = '$q3->id'");
										
										$ilkBosSoru = explode("-",$q5->ogrenciCevaplari);
										$kaldigiYer = array_search("X",$ilkBosSoru);
										$sorular	= explode("-",$q5->soruSiralamasi);
										$answers	= $q5->ogrenciCevaplari;
										
										$ogrenci = array(
										  'sinavID'				=> $q1->id,
										  'sinavBaslamaZamani'	=> strtotime("$q1->sinavTarihi $q1->sinavSaati"),
										  'sinavSuresi'			=> $u->kalansure,
										  'sorular'				=> $sorular,
										  'dersAdi'				=> $q2->dersAdi,
										  'ogrNo' 				=> $ogrNo,
										  'ogrID' 				=> $q3->id,
										  'ogrAd' 				=> $q3->ad,
										  'ogrSoyad' 			=> $q3->soyad,
										  'pencereID'			=> md5(date("U").$ogrNo.rand(1,999999)),
										  'aktifSoruID'			=> $kaldigiYer,
										  'verdigiCevaplar'		=> $answers
										);
										
										$Session = new Session($u->kalansure); //Kalan süre kadar zaman tanımla
										$Session->register('ogrenci', $ogrenci);							
										$msg = "OK";
										
									}else{
										$msg = "Sınav bitmiştir.";	
									}
									
							}else{ //Daha önce sisteme giriş yapmamışsa.
									date_default_timezone_set('Europe/Istanbul');
									$sinavZamani	= strtotime("$q1->sinavTarihi $q1->sinavSaati");
									$fark			= date("U") - $sinavZamani;
								
									if ($fark < ($q1->sinavSuresi*60)){
							
										$q5			= mysql_fetch_object(mysql_query("SELECT * FROM sinavlar WHERE id = '$q1->id' "));
										$temp 		= explode("-",$q5->sinavSorulari);
										shuffle($temp);shuffle($temp);
										$sorular	= implode("-",$temp);
										$cevaplar	= "";
										
										for($i=0;$i<count($temp);$i++){
											$cevaplar.="X-";
										}
										$cevaplar = trim($cevaplar,"-");
										
										$k = mysql_query("INSERT INTO cevaplar VALUES (DEFAULT,'$q3->id','$q1->id','$sorular','$cevaplar','1',".date("U").")");						
										$k = mysql_query("INSERT INTO kalansure VALUES (DEFAULT,'$q1->id','$q3->id','$q1->sinavSuresi')");						
										
										$kalanSure		= $q1->sinavSuresi;
										$aktifSoruID 	= 0;
										
										$Session = new Session($q1->sinavSuresi); //Sınav süresi kadar zaman tanımla
										$ogrenci = array(
												  'sinavID'				=> $q1->id,
												  'sinavBaslamaZamani'	=> strtotime("$q1->sinavTarihi $q1->sinavSaati"),
												  'sinavSuresi'			=> $kalanSure,
												  'sorular'				=> $temp,
												  'dersAdi'				=> $q2->dersAdi,
												  'ogrNo' 				=> $ogrNo,
												  'ogrID' 				=> $q3->id,
												  'ogrAd' 				=> $q3->ad,
												  'ogrSoyad' 			=> $q3->soyad,
												  'pencereID'			=> md5(date("U").$ogrNo.rand(1,999999)),
												  'sayfaYuklenmeSayisi'	=> 0,
												  'aktifSoruID'			=> $aktifSoruID
												);
										$Session->register('ogrenci', $ogrenci);
										
										$msg = "OK";
									}else{
										$msg = "Sınavın süresi geçmiştir.Dersin sorumlusu öğretim görevlisine müracaat ediniz.";	
									}
							}
					}else{
						$msg = "Kullanıcı adı veya şifre yanlış<br/><font style='color:red'>veya</font><br/>Şifrenin geçerliliği sona ermiştir.";	
				}	
			}else{
				$msg = "Tanımlı sınav bulunmamaktadır.";	
			}
			
		}else{
			$msg = "Hatalı güvenlik kodu.";
		}
		echo $msg;
	}
?>