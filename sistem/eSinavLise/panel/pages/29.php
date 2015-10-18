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
            		<div class="altSayfaBaslikSeviye1">Sınıf Seviyesi Ekle : </div>
                    <div class="altSayfaFormAlani">     
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Sınıf Seviyesi : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<input type="text" id="seviye" name="seviye"  />
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Sınıf seviyesini giriniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaButonAlani">
                                    	<div class="btnOnay">
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
                    <div class="altSayfaBaslikSeviye1">Mevcut Sınıf Seviyesi Listesi: </div>
                            <div class="altSayfaFormAlani">
                                    <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Liste : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="soruTuru" name="soruTuru">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													require_once("../class/connect.php");
													$sonuc = mysql_query("SELECT * FROM sinifseviyeleri");
													while($satir = mysql_fetch_array($sonuc)){
														echo "<option value='".$satir['id']."'>".$satir['seviye']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Silinecek sınıf seviyesini seçiniz.</div>
                            </div> 
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaButonAlani">
                                    	<div class="btnOnay">
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