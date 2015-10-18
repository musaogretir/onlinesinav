<?php
	require_once("headerPage.php");
	require_once("../class/connect.php");
	$buSayfa	= basename(__FILE__,".php");
	$yetkiler	= explode("-",$_SESSION["gecerliKullanici"]["charges"]);
	if (!in_array($buSayfa,$yetkiler)) {
		$_SESSION["gecerliKullanici"]["ygd"]++;
		header("location: ../yonetimAnasayfa.php?ygd=".$_SESSION["gecerliKullanici"]["ygd"]);
		exit();	
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
	<div id="altSayfaContainer">
    		<div class="altSayfaBolum">
            		<div class="altSayfaBaslikSeviye1">Kullanıcı Bilgileri : </div>
                    <div class="altSayfaFormAlani">
                    <form id="kullaniciTanimlaForm">
                    		<div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Ünvan : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="kUnvan" name="kUnvan">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													$sonuc =  mysql_query("SELECT * FROM unvanlar");
													while($satir = mysql_fetch_array($sonuc)){
														echo "<option value='".$satir['id']."'>".$satir['unvan']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Kişinin ünvanını seçiniz.</div>
                            </div>
                    		<div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Ad : </div>
                                    <div class="altSayfaFormCevapAlani"><input type="text" id="kAd" name="kAd" maxlength="25"/></div>
                                    <div class="altSayfaFormAciklamaAlani">Kişinin adını giriniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Soyad : </div>
                                    <div class="altSayfaFormCevapAlani"><input type="text" id="kSoyad" name="kSoyad" maxlength="25"/></div>
                                    <div class="altSayfaFormAciklamaAlani">Kişinin soyadını giriniz.</div>
                            </div> 
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Kullanıcı Adı : </div>
                                    <div class="altSayfaFormCevapAlani"><input type="text" id="kKullanici" name="kKullanici" maxlength="20"/></div>
                                    <div class="altSayfaFormAciklamaAlani">Boşluk ve özel karakter içermeyen bir kullanıcı adı giriniz.</div>
                            </div> 
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Şifre : </div>
                                    <div class="altSayfaFormCevapAlani"><input type="password" id="kSifre" name="kSifre" /></div>
                                    <div class="altSayfaFormAciklamaAlani">En az 6 karakterli bir şifre giriniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Şifre (Onay) : </div>
                                    <div class="altSayfaFormCevapAlani"><input type="password" id="kSifreOnay" name="kSifreOnay" /></div>
                                    <div class="altSayfaFormAciklamaAlani">Şifreyi tekrar giriniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaButonAlani">
                                    	<div class="btnOnay" id="btnOnayKullaniciEkle">
                                        	<span class="img"><img src="img/confirmation.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">Ekle</a></span>
                                        </div>
                                        <div class="btnIptal">
                                        	<span class="img"><img src="img/error.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">İptal</a></span>
                                        </div>  
                                    </div>
                            </div>                         
                    </div>
                    </form>
                    <div class="altSayfaBaslikSeviye1">Kullanıcı Sil : </div>
                    <div class="altSayfaFormAlani">
                    		<div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Kullanıcı : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="silinecekKullanici" name="silinecekKullanici">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													$sonuc =  mysql_query("SELECT * FROM kullanicilar");
													while($satir = mysql_fetch_array($sonuc)){
														echo "<option value='".$satir['id']."'>".$satir['ad']." ".$satir['soyad']." - ".$satir['kullaniciAdi']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Silinecek kullanıcıyı seçiniz.</div>
                            </div>      
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaButonAlani">
                                    	<div class="btnOnay" id="btnOnayKullaniciSil">
                                        	<span class="img"><img src="img/confirmation.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">Sil</a></span>
                                        </div>
                                        <div class="btnIptal">
                                        	<span class="img"><img src="img/error.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">İptal</a></span>
                                        </div>  
                                    </div>
                            </div> 
                    </div>
            </div>
            <div class="temizle"></div>
    </div>
</body>
</html>