<?php
	require_once("../class/connect.php");
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
            		<div class="altSayfaBaslikSeviye1">Soru Ekle : </div>
                    <div class="altSayfaFormAlani">
                    <form id="soruEkleForm_2">
                    		<div class="altSayfaFormAlaniBilgiSatiri">
                                <div class="altSayfaFormSoruAlani">Bölüm : </div>
                                <div class="altSayfaFormCevapAlani">
                                    <select id="bolum_2" name="bolum_2">
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
                            
                            <div class="altSayfaFormAlaniBilgiSatiri" id="dersAlani_2">
                            		<div class="altSayfaFormSoruAlani">Ders : </div>
                                    <div class="altSayfaFormCevapAlani" id="da2">
                                    	
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Dersi seçiniz.</div>
                            </div>
                    		<div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Soru Şekli : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="soruSekli" name="soruSekli">
                                        		<option value="0">Seçiniz</option>
                                         		<option value="1">Kod</option>
                                                <option value="2">Görsel</option>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Soru şeklini seçiniz.</div>
                            </div>
                    		<div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Soru Türü : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="soruTuru" name="soruTuru">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													$sonuc =  mysql_query("SELECT * FROM soruturleri");
													while($satir = mysql_fetch_array($sonuc)){
														echo "<option value='".$satir['id']."'>".$satir['soruTuru']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Soru türünü seçiniz.</div>
                            </div>      
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaButonAlani">
                                    	<div class="btnOnay" id="btnOnaySoruEkle_2">
                                        	<span class="img"><img src="img/confirmation.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">Tamam</a></span>
                                        </div>
                                        <div class="btnIptal">
                                        	<span class="img"><img src="img/error.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">İptal</a></span>
                                        </div>  
                                    </div>
                            </div>
                    </form>         
                    </div>
            </div>
            
            <div class="altSayfaBolum" id="gizliBolum_2">
            		<div class="altSayfaBaslikSeviye1">Soru Girişi: </div>
                    <div class="altSayfaFormAlani" id="altSayfaFormAlani_2">
                   </div>  
            </div>
            <div class="temizle"></div>
    </div>
</body>
</html>