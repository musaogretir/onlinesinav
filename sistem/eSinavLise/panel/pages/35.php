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
            		<form id="sinavSorusuSecimFormu_8">
            		<div class="altSayfaBaslikSeviye1">Geçmiş Sınavlarınız : </div>
                    <div class="altSayfaFormAlani">  
                    		<div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Sınav : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="sinav_35" name="sinav_35">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													require_once("../class/connect.php");
													
													$q = mysql_query("SELECT sinavlar.id, sinavlar.sinavTarihi, sinavlar.sinavSaati, dallar.dal, sinifseviyeleri.seviye, dersler.dersAdi FROM sinavlar INNER JOIN dallar ON sinavlar.dal = dallar.id INNER JOIN sinifseviyeleri ON sinavlar.seviye = sinifseviyeleri.id INNER JOIN dersler ON sinavlar.ders = dersler.id WHERE ogretimYili = (SELECT id FROM ogretimyili WHERE aktif = 1 ) AND donem='".$_SESSION['gecerliKullanici']['dnm']."' AND ogretmen = '".$_SESSION['gecerliKullanici']['userId']."' AND sinavDegerlendirmeDurumu = 1 ORDER BY sinavlar.id DESC");
													
													while($al = mysql_fetch_object($q)){
														echo "<optgroup label='$al->sinavTarihi  - $al->sinavSaati - $al->dal Dalı $al->seviye'>
																	<option value='$al->id'>$al->dersAdi</option>
																</optgroup>";
													}
													
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Sınavı seçiniz.</div>
                            </div>   
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaButonAlani">
                                    	<div class="btnOnay" id="btnOnay_35">
                                        	<span class="img"><img src="img/confirmation.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">Bul</a></span>
                                        </div>
                                        <div class="btnIptal">
                                        	<span class="img"><img src="img/error.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">İptal</a></span>
                                        </div>  
                                    </div>
                            </div>
                    </div>
                    </form>
                    	<div id="sinavListesi_35" style="display:none">
                                <div class="altSayfaBaslikSeviye1">
                                    <?php
                                        echo "$q1->ogretimYili Öğretim Yılı $q2->donem.Dönem Sınavlarım";
                                    ?>
                                </div>
                                
                                <div class="altSayfaFormAlani35">

                                </div>
                        </div>
                    </div>    
            </div>
            <div class="temizle"></div>
    </div>
    <div class="secilenSoruSayisi"></div>
</body>
</html>