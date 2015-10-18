<?php
	require_once("class/connect.php");
	require_once("headerMain.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>e-Sınav Yönetim Paneli - Kullanıcı : </title>
<link href="css/yonetim.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/menu.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/zebra_dialog.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/jquery-ui-1.10.1.custom.css" rel="stylesheet" type="text/css" media="all" />

<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.1.custom.js"></script>
<script type="text/javascript" src="js/jquery.base64.js"></script>
<script type="text/javascript" src="js/jquery.countdown.js"></script>
<script type="text/javascript" src="js/clock.js"></script>
<script type="text/javascript" src="js/oturumSuresi.js"></script>
<script type="text/javascript" src="js/menuYonlendir.js"></script>
<script type="text/javascript" src="js/zebra_dialog.js"></script>
<script type="text/javascript" src="js/jquery.timeentry.js"></script>
<script type="text/javascript" src="js/jquery.timeentry-tr.js"></script>
<script type="text/javascript" src="js/jquery.numeric.js"></script>
<script type="text/javascript" src="js/jquery.blockUI.js"></script>
<!--Yetkilere göre yüklenecek .JS dosyaları-->
<script type="text/javascript" src="js/soruIslemleri.js"></script>
<script type="text/javascript" src="js/sinavIslemleri.js"></script>
<script type="text/javascript" src="js/kullaniciIslemleri.js"></script>
<script type="text/javascript" src="js/digerIslemler.js"></script>

<script type="text/javascript" src="js/jquery.form.js"></script>
</head>

<body>
<?php
	$ygdServer = $_SESSION["gecerliKullanici"]["ygd"];
	@$ygdAdress = $_GET["ygd"];
	
	if ($ygdServer == $ygdAdress && $ygdServer==1){
?>
<script type="text/javascript">$.Zebra_Dialog("Yetkiniz olmayan bir alana erişmeye çalıştınız.<br/>Bu girişimi tekrarlamanız halinde şifreniz bloke olacaktır.", {'type': 'error','title':'Hata'});</script>
<?php			
	}
	if ($ygdServer == $ygdAdress && $ygdServer>1){
		$zaman = date("U");
		$blokeDurumu = 1;
		$blokeNedeni = 1;	
		
		header("location: cikis.php");
		exit();
	}
?>
<div id="cerceve">
		<div id="ust">
        	<div id="banner" onclick="javascript:window.location.href='yonetimAnasayfa.php'">e-Sınav Yönetim Paneli</div>
            <div id="tarihSaat">
            		<div class="clock">
                       <div id="Date"></div>
                          <ul>
                              <li id="hours"></li>
                              <li id="point">:</li>
                              <li id="min"></li>
                              <li id="point">:</li>
                              <li id="sec"></li>
                          </ul>
                    </div>
            </div>
            <div id="kullaniciBilgisi">
            	<?php
					echo "Kullanıcı<br/>".$_SESSION["gecerliKullanici"]["userName"];
					echo "<input type='hidden' name='".md5(md5($_SESSION["gecerliKullanici"]["userName"].$_SESSION["gecerliKullanici"]["userId"]))."' value='".base64_encode(base64_encode($_SESSION["gecerliKullanici"]["charges"]))."'/>";
				?>
            </div>
            <div id="aktifYilveDonem">
            	<?php
					echo "<b>Öğretim Yılı : ".$_SESSION["gecerliKullanici"]["oy"]."</b>";
					echo "<b>Dönem : ".$_SESSION["gecerliKullanici"]["dnm"].' Dönem</b>';
				?>
            </div>
            <div id="oturumSuresi" align="center">
            		<span class="icBaslik">Oturum Süresi</span>
            		<span id="minutes"></span> :
  					<span id="seconds"></span>
            </div>
        	<div id="menuContainer">
        		<ul id="menu">
                	<?php 
						$yetkiler = explode('-',$_SESSION["gecerliKullanici"]["charges"]);
						
						if (in_array(1,$yetkiler))
						{
					?>
                    <li class="menu_right"><a href="#" class="drop" val="1">Soru İşlemleri</a>                    
                        <div class="dropdown_1column">                        
                                <div class="col_1">                                
                                    <ul class="simple">
                                        <?php if (in_array(2,$yetkiler)) {?><li><a href="#" val="2">Soru Ekle</a></li><?php }?>
                                        <?php if (in_array(3,$yetkiler)) {?><li><a href="#" val="3">Soru Listele</a></li><?php }?>
                                        <?php if (in_array(4,$yetkiler)) {?><li><a href="#" val="4">Soru Düzelt - Sil</a></li><?php }?>
                                        <?php if (in_array(5,$yetkiler)) {?><li><a href="#" val="5">Excel'den Soru Aktar</a></li><?php }?>
                                    </ul>                                       
                                </div>                              
                        </div>                       
                    </li>
                    <?php 
						}
					?>
                    <?php 
						if (in_array(6,$yetkiler))
						{
					?>
                    <li class="menu_right"><a href="#" class="drop" val="6">Sınav İşlemleri</a>                    
                        <div class="dropdown_1column">                        
                                <div class="col_1">                                
                                    <ul class="simple">
                                        <?php if (in_array(7,$yetkiler)) {?><li><a href="#" val="7">Sınav Oluştur</a></li><?php }?>
                                        <?php if (in_array(8,$yetkiler)) {?><li><a href="#" val="8">Sınav Sorularını Seç</a></li><?php }?>
                                        <?php if (in_array(9,$yetkiler)) {?><li><a href="#" val="9">Sınav Oturma Düzeni Oluştur</a></li><?php }?>
                                        <?php if (in_array(10,$yetkiler)) {?><li><a href="#" val="10">Sınav İçin Şifreleri Oluştur</a></li><?php }?>
                                        <?php if (in_array(11,$yetkiler)) {?><li><a href="#" val="11">Sınavı Değerlendir</a></li><?php }?>
                                        <?php if (in_array(12,$yetkiler)) {?><li><a href="#" val="12">Sınav Raporları</a></li><?php }?>
                                        <?php if (in_array(34,$yetkiler)) {?><li><a href="#" val="34">Sınavlarım</a></li><?php }?>
                                    </ul>                                       
                                </div>                              
                        </div>                       
                    </li>
                    <?php 
						}
					?>
                    <?php 
						if (in_array(13,$yetkiler))
						{
					?>
                    <li class="menu_right"><a href="#" class="drop" val="13">Kullanıcı İşlemleri</a>                    
                        <div class="dropdown_1column">                        
                                <div class="col_1">                                
                                    <ul class="simple">
                                        <?php if (in_array(14,$yetkiler)) {?><li><a href="#" val="14">Kullanıcı Tanımla / Güncelle / Sil</a></li><?php }?>
                                        <?php if (in_array(15,$yetkiler)) {?><li><a href="#" val="15">Kullanıcı Yetkilendirme</a></li><?php }?>
                                    </ul>                                       
                                </div>                              
                        </div>                       
                    </li>
                    <?php 
						}
					?>
                    <?php 
						if (in_array(16,$yetkiler))
						{
					?>
                    <li class="menu_right"><a href="#" class="drop" val="16">Sistem Analizi</a>                    
                        <div class="dropdown_1column">                        
                                <div class="col_1">                                
                                    <ul class="simple">
                                        <?php if (in_array(17,$yetkiler)) {?><li><a href="#" val="17">Giriş Raporları</a></li><?php }?>
                                        <?php if (in_array(18,$yetkiler)) {?><li><a href="#" val="18">Kullanıcı Hareketleri</a></li><?php }?>
                                        <?php if (in_array(19,$yetkiler)) {?><li><a href="#" val="19">Kişi İstatistikleri</a></li><?php }?>
                                        <?php if (in_array(20,$yetkiler)) {?><li><a href="#" val="20">Sınav İstatistikleri</a></li><?php }?>
                                        <?php if (in_array(21,$yetkiler)) {?><li><a href="#" val="21">Veritabanı Yedekleme</a></li><?php }?>
                                    </ul>                                       
                                </div>                              
                        </div>                       
                    </li>
                    <?php 
						}
					?>
                    <?php 
						if (in_array(22,$yetkiler))
						{
					?>
                    <li class="menu_right"><a href="#" class="drop" val="22">Diğer İşlemler</a>                    
                        <div class="dropdown_1column">                        
                                <div class="col_1">                                
                                    <ul class="simple">
                                    	<?php if (in_array(23,$yetkiler)) {?><li><a href="#" val="23">Öğretim Yılı</a></li><?php }?>
                                        <?php if (in_array(24,$yetkiler)) {?><li><a href="#" val="24">Dönem</a></li><?php }?>
                                        <?php if (in_array(25,$yetkiler)) {?><li><a href="#" val="25">Sınav Türleri</a></li><?php }?>
                                        <?php if (in_array(26,$yetkiler)) {?><li><a href="#" val="26">Soru Türleri</a></li><?php }?>
                                        <?php if (in_array(27,$yetkiler)) {?><li><a href="#" val="27">Öğretim Türleri</a></li><?php }?>
                                        <?php if (in_array(28,$yetkiler)) {?><li><a href="#" val="28">Ünvanlar</a></li><?php }?>
                                        <?php if (in_array(29,$yetkiler)) {?><li><a href="#" val="29">Sınıf Seviyeleri</a></li><?php }?>
                                        <?php if (in_array(30,$yetkiler)) {?><li><a href="#" val="30">Sınıf Listesi Yükle</a></li><?php }?>
                                        <?php if (in_array(32,$yetkiler)) {?><li><a href="#" val="33">Mevcut Sınıf Listeleri</a></li><?php }?>
                                        <?php if (in_array(31,$yetkiler)) {?><li><a href="#" val="31">Dersler</a></li><?php }?>
                                        <?php if (in_array(32,$yetkiler)) {?><li><a href="#" val="32">Bölümler</a></li><?php }?>
                                    </ul>                                       
                                </div>                              
                        </div>                       
                    </li>
                    <?php 
						}
					?>
                    <li class="menu_right" style="position:absolute;right:0px"><a href="cikis.php" val="100">Güvenli Çıkış</a></li>
				</ul>
            </div>    
        </div>
        
        <div id="icerik">
                <div id="logo"></div>
        </div>
        
</div>
</body>
</html>