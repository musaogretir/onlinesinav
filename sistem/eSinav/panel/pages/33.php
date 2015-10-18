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
                    <div class="altSayfaBaslikSeviye1">Mevcut Sınıf Listeleri [ <?php echo $_SESSION["gecerliKullanici"]["oy"];?> Öğretim Yılı ]: </div>
                    	<div class="listeBolum_33">
                            <?php
								$r =  mysql_query("SELECT * FROM bolumler");
								while($row = mysql_fetch_array($r)){
							?>
                            
                            	<div class="listeBolumBaslik_33">
                                	<?php echo $row['bolumAdi']; ?>
                                </div>
                                <div class="listeBolumIcerik_33">
                                	<table class="tablo_33">
                                    <tr style='font-weight:bold;background-color:#000;color:#FFF'>
                                    	<td align="center">Sıra No</td>
                                        <td align="center">Sınıf</td>
                                        <td align="center">Öğrenci Sayısı</td>
                                    </tr>
									<?php
										$i=1;
										for($x=1;$x<=2;$x++){
											for($y=1;$y<=2;$y++){
												$q = mysql_num_rows(mysql_query("SELECT * FROM siniflisteleri WHERE bolum = ".$row['id']." AND ogretimYili = (SELECT id FROM ogretimyili WHERE aktif = 1) AND donem = (SELECT id FROM donemler WHERE aktif = 1) AND sinifSeviyesi = $x AND ogretimTuru = $y"));
												if ($q>0) $class = "green"; else $class = "red";
												echo "<tr class='$class'>
															<td align='center'>$i</td>
															<td>$x.Sınıf $y.Öğretim</td>
															<td>$q Öğrenci</td>
													  </tr>";
												$i++;	  
											}
										}
										
									?>
                                    </table>
                                </div>
                            
                            <?php
								}
							?>
                         </div>   
                    </div>
            </div>
            <div class="temizle"></div>
    </div>
</body>
</html>