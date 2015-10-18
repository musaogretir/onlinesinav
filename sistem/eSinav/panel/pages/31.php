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
            		<div class="altSayfaBaslikSeviye1">Ders Ekle : </div>
                    <div class="altSayfaFormAlani">
                    		<div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaFormSoruAlani">Bölüm : </div>
                                    <div class="altSayfaFormCevapAlani">
                                    	<select id="bolum_31" name="bolum_31">
                                        		<option value="0">Seçiniz</option>
                                                <?php
													$sonuc =  mysql_query("SELECT * FROM bolumler");
													while($satir = mysql_fetch_array($sonuc)){
														echo "<option value='".$satir['id']."'>".$satir['bolumAdi']."</option>";	
													}
												?>
                                        </select>
                                    </div>
                                    <div class="altSayfaFormAciklamaAlani">Bölümü seçiniz.</div>
                            </div>      
                            <div class="altSayfaFormAlaniBilgiSatiri">
                            		<div class="altSayfaButonAlani">
                                    	<div class="btnOnay" id="btnOnayDersKaydet_31">
                                        	<span class="img"><img src="img/confirmation.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">Kaydet</a></span>
                                        </div>
                                        <div class="btnIptal">
                                        	<span class="img"><img src="img/error.png" width="32" height="32" /></span>
                                            <span class="text"><a href="javascript:;">İptal</a></span>
                                        </div>  
                                    </div>
                            </div> 
                    </div>
                    <div class="altSayfaBaslikSeviye1">Bölümlere Göre Ders Listeleri : </div>
                    <div class="listeBolum_33">
                            <?php
								$sonuc =  mysql_query("SELECT * FROM bolumler");								
								while($row = mysql_fetch_array($sonuc)){
									
							?>
                            
                                        <div class="listeBolumBaslik_33">
                                            <?php echo $row['bolumAdi']; ?>
                                        </div>
                                        	<?php
												$s = mysql_num_rows(mysql_query("SELECT * FROM dersler WHERE bolum = ".$row['id']));
												if ($s>0){
											?>
                                                    <div class="listeBolumIcerik_33">
                                                    
                                                        <table class="tablo_33">
                                                        <tr style='font-weight:bold;background-color:#000;color:#FFF'>
                                                            <td align="center">Sıra No</td>
                                                            <td align="center">Bölüm</td>
                                                            <td align="center">Ders Adı</td>
                                                        </tr>
                                                        <?php
                                                            $i=1;
                                                            
                                                            $q = mysql_query("SELECT * FROM dersler WHERE bolum = ".$row['id']);
                                                            while($p=mysql_fetch_array($q)){
                                                                echo "<tr>
                                                                        <td align='center'>$i</td>
                                                                        <td>".$row['bolumAdi']."</td>
                                                                        <td>".$p['dersAdi']."</td>
                                                                     </tr>";
                                                                $i++;	
                                                            }
                                                        ?>
                                                        </table>
                                                    </div>
                            				<?php
												}
											?>
                            <?php
								}
							?>
                         </div> 
            </div>
            <div class="temizle"></div>
    </div>
</body>
</html>