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
                    <div class="altSayfaBaslikSeviye1">Dönem Listesi: </div>
                            <div class="altSayfaFormAlani">
                                    <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Liste : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="donemListesi" name="donemListesi">
                                                <?php
													$sonuc =  mysql_query("SELECT * FROM donemler");
													while($satir = mysql_fetch_array($sonuc)){
														if ($satir['aktif']==1)
														echo "<option value='".$satir['id']."' selected='selected'>".$satir['donem']."</option>";	
														else
														echo "<option value='".$satir['id']."'>".$satir['donem']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Aktif dönemi seçiniz.</div>
                            </div> 
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaButonAlani">
                                    	<div class="btnOnay">
                                        	<span class="img"><img src="img/confirmation.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">Onayla</a></span>
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