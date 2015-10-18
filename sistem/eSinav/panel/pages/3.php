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
            		<div class="altSayfaBaslikSeviye1">Soru Listele : </div>
                    <div class="altSayfaFormAlani">     
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Bölüm : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="bolum_3" name="bolum_3">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													require_once("../class/connect.php");
													$sonuc = mysql_query("SELECT * FROM bolumler");
													while($satir = mysql_fetch_array($sonuc)){
														echo "<option value='".$satir['id']."'>".$satir['bolumAdi']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Bölüm seçiniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Ders : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="ders_3" name="ders_3">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													$sonuc = mysql_query("SELECT * FROM dersler");
													while($satir = mysql_fetch_array($sonuc)){
														echo "<option value='".$satir['id']."'>".$satir['dersAdi']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Ders seçiniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Paylaşım Türü : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="paylasimTuru_3" name="paylasimTuru_3">
                                        		<option value="0">Seçiniz</option>
                                                <option value="1">Tüm sorular</option>
                                                <option value="2">Yalnızca benim eklediklerim</option>
                                                <option value="3">Yalnızca paylaşılanlar</option>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Paylaşım türünü seçiniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaButonAlani">
                                    	<div class="btnOnay" id="soruListele_3">
                                        	<span class="img"><img src="img/confirmation.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">Listele</a></span>
                                        </div>
                                        <div class="btnIptal">
                                        	<span class="img"><img src="img/error.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">İptal</a></span>
                                        </div>  
                                    </div>
                            </div>
                    </div>
                </div>
                    <div id="soruListesiGosterme_3" style="display:none">
                            <div class="altSayfaBaslikSeviye1">Soru Listesi: </div>
                            <div id="sorular_3_container"></div>
                 	</div>
            </div>
            <div class="temizle"></div>
    </div>
</body>
</html>