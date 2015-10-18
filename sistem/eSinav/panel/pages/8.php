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
            		<form id="sinavSorusuSecimFormu_8">
            		<div class="altSayfaBaslikSeviye1">Sınav Sorusu Seçimi : </div>
                    <div class="altSayfaFormAlani">  
                    		<div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Sınav Türü: </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="sinavTuru_8" name="sinavTuru_8">
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
                            <div class="altSayfaFormAlaniBilgiSatiri" id="gizliBolum_8">
                            		<div class="altSayfaFormSoruAlani">Sınav : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Sınavı seçiniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri" id="gizliBolum_8_1">
                            		<div class="altSayfaFormSoruAlani">Soru Türü : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Soru türünü seçiniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaButonAlani">
                                    	<div class="btnOnay" id="btnOnaySinavSecimi_8">
                                        	<span class="img"><img src="img/confirmation.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">Tamam</a></span>
                                        </div>
                                        <div class="btnIptal">
                                        	<span class="img"><img src="img/error.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">İptal</a></span>
                                        </div>  
                                    </div>
                            </div>
                    </div>
                    </form>
                    <div id="soruListesi_8">
                        <div class="altSayfaBaslikSeviye1">...Dersi Soru Listesi: </div>
                                
                                <div class="altSayfaFormAlaniBilgiSatiri">
                                        <div class="altSayfaButonAlani">
                                            <div class="btnOnay">
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
            </div>
            <div class="temizle"></div>
    </div>
    <div class="secilenSoruSayisi"></div>
</body>
</html>