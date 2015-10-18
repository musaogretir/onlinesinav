<?php
	require_once("headerPage.php");
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
            	<form id="sinavOlusturForm_7">
            		<div class="altSayfaBaslikSeviye1">Sınav Bilgileri : </div>
                    <div class="altSayfaFormAlani">
                    		<div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Öğretim Yılı : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="ogretimYili_7" name="ogretimYili_7">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													require_once("../class/connect.php");
													$sonuc =  mysql_query("SELECT * FROM ogretimyili WHERE aktif=1");
													while($satir = mysql_fetch_array($sonuc)){
														echo "<option value='".$satir['id']."'>".$satir['ogretimYili']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Öğretim yılını seçiniz.</div>
                            </div>
                    		<div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Dönem : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="donem_7" name="donem_7">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													$sonuc =  mysql_query("SELECT * FROM donemler WHERE aktif=1");
													while($satir = mysql_fetch_array($sonuc)){
														echo "<option value='".$satir['id']."'>".$satir['donem']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Dönemi seçiniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Sınav Türü : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="sinavTuru_7" name="sinavTuru_7">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													$sonuc =  mysql_query("SELECT * FROM sinavturleri");
													while($satir = mysql_fetch_array($sonuc)){
														echo "<option value='".$satir['id']."'>".$satir['sinavTuru']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Sınav türünü seçiniz.</div>
                            </div> 
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Öğretim Görevlisi : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="ogretimGorevlisi_7" name="ogretimGorevlisi_7">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													$sonuc =  mysql_query("SELECT * FROM kullanicilar WHERE id='".$_SESSION["gecerliKullanici"]["userId"]."'");
													while($satir = mysql_fetch_array($sonuc)){
														echo "<option value='".$satir['id']."'>".$satir['ad']." ".$satir['soyad']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Öğretim görevlisini seçiniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Sınav Tarihi : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<input type="text" id="sinavTarihi_7" name="sinavTarihi_7"  />
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Sınav tarihini seçiniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Sınav Saati : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<input type="text" id="sinavSaati_7" name="sinavSaati_7" />
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Sınav saatini giriniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Sınav Süresi : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<input type="text" id="sinavSuresi_7" name="sinavSuresi_7" />
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Sınav süresini dakika olarak giriniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Sınav Açıklaması : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<textarea id="sinavAciklamasi_7" name="sinavAciklamasi_7">Başarılar dilerim.</textarea>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Sınavla ilgili açıklamanızı giriniz.</div>
                            </div>  
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Bölüm : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="bolum_7" name="bolum_7">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													$sonuc =  mysql_query("SELECT * FROM bolumler");
													while($satir = mysql_fetch_array($sonuc)){
														echo "<option value='".$satir['id']."'>".$satir['bolumAdi']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Bölümü seçiniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri" id="gizliBolum_7">
                            		<div class="altSayfaFormSoruAlani">Ders : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Sınav yapılacak dersi seçiniz.</div>
                            </div> 
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Seviye : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="seviye_7" name="seviye_7">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													$sonuc =  mysql_query("SELECT * FROM sinifseviyeleri");
													while($satir = mysql_fetch_array($sonuc)){
														echo "<option value='".$satir['id']."'>".$satir['seviye']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Sınıf seviyesini seçiniz.</div>
                            </div> 
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Öğretim Türü : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="ogretimTuru_7" name="ogretimTuru_7">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													$sonuc =  mysql_query("SELECT * FROM ogretimturu");
													while($satir = mysql_fetch_array($sonuc)){
														echo "<option value='".$satir['id']."'>".$satir['tur']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Öğretim türünü seçiniz.</div>
                            </div> 
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaButonAlani">
                                    	<div class="btnOnay" id="btnOnaySinavOlustur_7">
                                        	<span class="img"><img src="img/confirmation.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">Oluştur</a></span>
                                        </div>
                                        <div class="btnIptal">
                                        	<span class="img"><img src="img/error.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">İptal</a></span>
                                        </div>  
                                    </div>
                            </div>                         
                    </div>
                </form>
            </div>
            <div class="temizle"></div>
    </div>
</body>
</html>