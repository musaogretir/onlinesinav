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
            		<div class="altSayfaBaslikSeviye1">Sınıf Listesi Yükle : </div>
                    <div class="altSayfaFormAlani">     
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Bölüm : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="bolum_30" name="bolum_30">
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
                                    <div class="altSayfaFormAciklamaAlani">Bölümü seçiniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Sınıf Seviyesi : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="seviye_30" name="seviye_30">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													$sonuc = mysql_query("SELECT * FROM sinifseviyeleri");
													while($satir = mysql_fetch_array($sonuc)){
														echo "<option value='".$satir['id']."'>".$satir['seviye']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Sınıf seviyesini seçiniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Dal : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="dal_30" name="dal_30">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													$sonuc = mysql_query("SELECT * FROM dallar");
													while($satir = mysql_fetch_array($sonuc)){
														echo "<option value='".$satir['id']."'>".$satir['dal']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Dal seçiniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaButonAlani">
                                    	<div class="btnOnay" id="btnOnaySinifSec">
                                        	<span class="img"><img src="img/confirmation.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">Seç</a></span>
                                        </div>
                                        <div class="btnIptal">
                                        	<span class="img"><img src="img/error.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">İptal</a></span>
                                        </div>  
                                    </div>
                            </div>
                    </div>
            </div>
            <div class="altSayfaBolum" id="gizliBolum_30">
            	<form id="ogrenciListesiYukleForm" action="actions/sinifListesiIceriAktar.php" enctype="multipart/form-data" method="post">
            		<div class="altSayfaBaslikSeviye1">Excel Dosyası [2007-2010]: </div>
                    <div class="altSayfaFormAlani" id="altSayfaFormAlani_30">
                        <div class="altSayfaFormAlaniBilgiSatiri">
                            <input type="file" name="ogrenciListesiYukle_30" id="ogrenciListesiYukle_30" />
                        </div>
                        <div class="altSayfaFormAlaniBilgiSatiri">
                            <div class="progress">
                                <div class="bar"></div >
                                <div class="percent">0%</div>
                            </div>
                        </div>    
                        <div class="altSayfaButonAlani" id="altSayfaButonAlani_30">
                        	<div class="btnOnay" id="btnOnaySinifYukle">
                                        	<span class="img"><img src="img/confirmation.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:onclick:$('#ogrenciListesiYukleForm').trigger('submit');">Yükle</a></span>
                            </div>
                            <div class="btnIptal">
                                        	<span class="img"><img src="img/error.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">İptal</a></span>
                            </div>
                        </div>
                   </div> 
                </form>   
            </div>        
            <div class="temizle"></div>
    </div>
</body>
</html>