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
            		<div class="altSayfaBaslikSeviye1">Sınavlarım : </div>
                    <div class="altSayfaFormAlani">  
                    		<div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Aktif Dönem : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="aktifDonem_34" name="aktifDonem_34">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													require_once("../class/connect.php");
													$q1 = mysql_fetch_object(mysql_query("SELECT * FROM ogretimyili WHERE aktif = 1"));
													echo "<option value='$q1->id'>$q1->ogretimYili Öğretim Yılı $q2->donem.Dönem</option>";
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Aktif dönemi seçiniz.</div>
                            </div>   
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaButonAlani">
                                    	<div class="btnOnay" id="btnOnaySinavlarim_34">
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
                    	<div id="sinavListesi_34" style="display:none">
                                <div class="altSayfaBaslikSeviye1">
                                    <?php
                                        echo "$q1->ogretimYili Öğretim Yılı $q2->donem.Dönem Sınavlarım";
                                    ?>
                                </div>
                                
                                <div class="altSayfaFormAlani34">

                                </div>
                        </div>
                    </div>    
            </div>
            <div class="temizle"></div>
    </div>
    <div class="secilenSoruSayisi"></div>
</body>
</html>