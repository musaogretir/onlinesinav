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
            		<div class="altSayfaBaslikSeviye1">Şifre Oluştur : </div>
                    <div class="altSayfaFormAlani">   
                    <form id="form_10" > 
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Sınav Türü : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="sinavTuru_10" name="sinavTuru_10">
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
                            <div class="altSayfaFormAlaniBilgiSatiri" id="gizliBolum_10">
                            		<div class="altSayfaFormSoruAlani">Sınav : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Sınavı seçiniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaButonAlani">
                                    	<div class="btnOnay" id="btnOnaySifreOlustur_10">
                                        	<span class="img"><img src="img/confirmation.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">Oluştur</a></span>
                                        </div>
                                        <div class="btnIptal">
                                        	<span class="img"><img src="img/error.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">İptal</a></span>
                                        </div>  
                                    </div>
                            </div>
                    </form>        
                    </div>
                    <div id="sifreListe_10" style="display:none">
                        <div class="altSayfaBaslikSeviye1">Şifre Listesi : </div>
                        <div id="sifreListe_10_container"></div>
                    </div>
            </div>
            <div class="temizle"></div>
    </div>
</body>
</html>