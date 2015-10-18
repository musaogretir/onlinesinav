<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>E-Sınav - Musa Öğretir</title>
<link href="css/index.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/dd.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/zebra_dialog.css" rel="stylesheet" type="text/css" media="all" />

<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery.numeric.js"></script>
<script type="text/javascript" src="js/zebra_dialog.js"></script>
<script type="text/javascript" src="js/jquery.dd.js"></script>
<script type="text/javascript" src="js/giris.js"></script>
</head>

<body>
<?php
	require_once("connect.php");
?>
<div id="cerceve">
	<form id="loginForm">
		<div id="baslik">Online Sınav Sistemi Giriş Ekranı</div>
		<div class="satir">	
				<div class="soru">Öğrenci No :</div>
                <div class="cevap"><input type="text" name="ogrNo" id="ogrNo" /></div>
		</div>
        <div class="satir">	
				<div class="soru">Şifre :</div>
                <div class="cevap"><input type="password" name="sifre" id="sifre" /></div>
		</div>
        <div class="satir">
        		<div class="soru">Sınav Türü :</div>
                <div class="cevap">
                		<select name="sinTr" id="sinTr"  onchange="showValue(this.value)">
                      		<option value="0">Seçiniz</option>
                            <?php
								date_default_timezone_set('Europe/Istanbul');
								$bugun = date("d-m-Y");
								$q = mysql_query("SELECT sinavturleri.id,sinavturleri.sinavTuru FROM sinavlar INNER JOIN sinavturleri ON sinavlar.sinavTuru = sinavturleri.id WHERE sinavlar.ogretimYili = (SELECT id FROM ogretimyili WHERE aktif=1) AND sinavlar.donem = (SELECT id FROM donemler WHERE aktif = 1) AND sinavlar.sifreOlusturmaDurumu = 1 AND sinavlar.sinavDegerlendirmeDurumu = 0 AND sinavlar.sinavTarihi = '$bugun'");
								$x = array();
								while($al = mysql_fetch_object($q)){
									if (!in_array($al->id,$x))
									{
										echo "<option value='$al->id'>$al->sinavTuru</option>";	
										array_push($x,$al->id);
									}
								}
							?>
                      </select>
                </div>
        </div>
        <div class="satir">
        		<div class="soru">Bölüm :</div>
                <div class="cevap">
                		<select name="bolum" id="bolum"  onchange="showValue(this.value)">
                      		<option value="0">Seçiniz</option>
                            <?php
								$bugun = date("d-m-Y");
								$q = mysql_query("SELECT bolumler.id,bolumler.bolumAdi FROM sinavlar INNER JOIN bolumler ON sinavlar.bolum = bolumler.id WHERE sinavlar.ogretimYili = (SELECT id FROM ogretimyili WHERE aktif=1) AND sinavlar.donem = (SELECT id FROM donemler WHERE aktif = 1) AND sinavlar.sifreOlusturmaDurumu = 1 AND sinavlar.sinavDegerlendirmeDurumu = 0 AND sinavlar.sinavTarihi = '$bugun'");
								$x = array();
								while($al = mysql_fetch_object($q)){
									if (!in_array($al->id,$x))
									{
										echo "<option value='$al->id'>$al->bolumAdi</option>";	
										array_push($x,$al->id);
									}
								}
							?>
                      </select>
                </div>
        </div>
        <div class="satir">
        		<div class="soru">Sınıf :</div>
                <div class="cevap">
                		<select name="sinif" id="sinif"  onchange="showValue(this.value)">
                      		<option value="0">Seçiniz</option>
                            <?php
								$bugun = date("d-m-Y");
								$q = mysql_query("SELECT sinifseviyeleri.id,sinifseviyeleri.seviye FROM sinavlar INNER JOIN sinifseviyeleri ON sinavlar.seviye = sinifseviyeleri.id WHERE sinavlar.ogretimYili = (SELECT id FROM ogretimyili WHERE aktif=1) AND sinavlar.donem = (SELECT id FROM donemler WHERE aktif = 1) AND sinavlar.sifreOlusturmaDurumu = 1 AND sinavlar.sinavDegerlendirmeDurumu = 0 AND sinavlar.sinavTarihi = '$bugun'");
								$x = array();
								while($al = mysql_fetch_object($q)){
									if (!in_array($al->id,$x))
									{
										echo "<option value='$al->id'>$al->seviye</option>";
										array_push($x,$al->id);
									}		
								}
							?>
                      </select>
                </div>
        </div>
        <div class="satir">
        		<div class="soru">Ders :</div>
                <div class="cevap">
                		<select name="ders" id="ders"  onchange="showValue(this.value)">
                      		<option value="0">Seçiniz</option>
                            <?php
								$bugun = date("d-m-Y");
								$q = mysql_query("SELECT dersler.id,dersler.dersAdi FROM sinavlar INNER JOIN dersler ON sinavlar.ders = dersler.id WHERE sinavlar.ogretimYili = (SELECT id FROM ogretimyili WHERE aktif=1) AND sinavlar.donem = (SELECT id FROM donemler WHERE aktif = 1) AND sinavlar.sifreOlusturmaDurumu = 1 AND sinavlar.sinavDegerlendirmeDurumu = 0 AND sinavlar.sinavTarihi = '$bugun'");
								
								$x = array();
								while($al = mysql_fetch_object($q)){
									if (!in_array($al->id,$x))
									{
										echo "<option value='$al->id'>$al->dersAdi</option>";	
										array_push($x,$al->id);
									}	
								}
							?>
                      </select>
                </div>
        </div>
        <div class="satir">
        		<div class="soru">Öğretmen :</div>
                <div class="cevap">
                		<select name="ogGor" id="ogGor"  onchange="showValue(this.value)">
                                <option value="0">Seçiniz</option>
                                <?php
                                    $bugun = date("d-m-Y");
									$q = mysql_query("SELECT kullanicilar.id,kullanicilar.ad,kullanicilar.soyad FROM sinavlar INNER JOIN kullanicilar ON sinavlar.ogretmen = kullanicilar.id WHERE sinavlar.ogretimYili = (SELECT id FROM ogretimyili WHERE aktif=1) AND sinavlar.donem = (SELECT id FROM donemler WHERE aktif = 1) AND sinavlar.sifreOlusturmaDurumu = 1 AND sinavlar.sinavDegerlendirmeDurumu = 0 AND sinavlar.sinavTarihi = '$bugun'");
									$x = array();
                                    while($al = mysql_fetch_object($q)){
										if (!in_array($al->id,$x))
										{
											echo "<option value='$al->id'>".ucfirst($al->ad)." ".ucfirst($al->soyad)."</option>";	
											array_push($x,$al->id);
										}	
                                    }
                                ?>
                          </select>
                </div>
        </div>
        <div id="code">	
				<img src="class/captcha/captcha.php" width="200" height="70" />
		</div>
        <div class="satir">	
				<div class="soru">Güvenlik Kodu :</div>
                <div class="cevap"><input type="text" name="c" id="c" /></div>
		</div>
        <div class="btn">	
				<input type="button" id="s" name="s" value="Giriş Yap" />
		</div>
    </form>    
</div>

</body>
</html>