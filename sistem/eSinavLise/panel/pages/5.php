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
            		<div class="altSayfaBaslikSeviye1">Excel'den Soru Aktar : </div>
                    <div class="altSayfaFormAlani">     
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Bölüm : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="bolum_5" name="bolum_5">
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
                            <div class="altSayfaFormAlaniBilgiSatiri" id="dersAlani_5">
                            		<div class="altSayfaFormSoruAlani">Ders : </div>
                                    <div class="altSayfaFormCevapAlani" id="da5">
                                    	
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Dersi seçiniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri" id="soruTuruAlani_5">
                            		<div class="altSayfaFormSoruAlani">Soru Türü : </div>
                                    <div class="altSayfaFormCevapAlani" id="st5">
                                    	
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Soru türünü seçiniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaButonAlani" id="btnOnaySoruYukle_5">
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
            <div class="altSayfaBolum" id="gizliBolum_5">
            	<form id="testSoruYukleForm" action="actions/testSoruIceriAktar.php" enctype="multipart/form-data" method="post">
            		<div class="altSayfaBaslikSeviye1">Excel Dosyası [2007-2010]: </div>
                    <div class="altSayfaFormAlani" id="altSayfaFormAlani_5">
                        <div class="altSayfaFormAlaniBilgiSatiri">
                            <input type="file" name="testSoruYukle_5" id="testSoruYukle_5" />
                        </div>
                        <div class="altSayfaFormAlaniBilgiSatiri">
                            <div class="progress">
                                <div class="bar"></div >
                                <div class="percent">0%</div>
                            </div>
                        </div>    
                        <div class="altSayfaButonAlani" id="altSayfaButonAlani_5">
                        	<div class="btnOnay" id="btnOnayTestSoruYukle">
                                        	<span class="img"><img src="img/confirmation.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:onclick:$('#testSoruYukleForm').trigger('submit');">Yükle</a></span>
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