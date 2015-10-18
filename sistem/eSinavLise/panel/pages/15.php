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
            		<div class="altSayfaBaslikSeviye1">Kullanıcı Yetkilendirme : </div>
                    <div class="altSayfaFormAlani">
                    		<div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Kullanıcı : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="kKullanici" name="kKullanici">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													require_once("../class/connect.php");
													$sonuc = mysql_query("SELECT * FROM kullanicilar");
													while($satir = mysql_fetch_array($sonuc)){
														echo "<option value='".$satir['id']."'>".$satir['kullaniciAdi']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Kişinin kullanıcı adını seçiniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Profil : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="profil" name="profil">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													$sonuc = mysql_query("SELECT * FROM profil");
													while($satir = mysql_fetch_array($sonuc)){
														echo "<option value='".$satir['id']."'>".$satir['profilAdi']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Profil seçimi yaparak, otomatik yetkilendirme yapabilirsiniz.</div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
									<div class="liste">
                                    		<?php
												$sonuc = mysql_query("SELECT * FROM islemler WHERE ustu=0");
											?>
                                    		<div class="altSayfaBaslikSeviye2">Yetkiler : </div>
                                    		<?php
												while($satir = mysql_fetch_array($sonuc)){
														echo "<div class='sutun'><ul>";
															echo "<li><input type='checkbox' id='mn_".$satir["id"]."'>".$satir['islem'];
														
															$result = mysql_query("SELECT * FROM islemler WHERE ustu='".$satir['id']."'");
															
															echo "<ul>";
															while($bilgi = mysql_fetch_array($result)){
																echo '<li>';
																	echo "<input type='checkbox' id='mn_".$bilgi['id']."'>".$bilgi['islem'];
																echo '</li>';	
															}
															echo '<ul>';
																
														echo '</li></ul></div>';	
													}
											?>
                                    </div>
                            </div>
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaButonAlani" style="width:845px">
                                    	<div class="btnOnay" id="btnOnayKullaniciYetkilendirme">
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