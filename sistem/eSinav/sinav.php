<?php
	require_once("headerSinav.php");
	require_once("connect.php");
	require_once("class/araclar.php");
	date_default_timezone_set('Europe/Istanbul');
	
	$q1 = mysql_fetch_object(mysql_query("SELECT * FROM sinavlar WHERE id='".$_SESSION['ogrenci']['sinavID']."'"));
	$baslamaZamani	= strtotime("$q1->sinavTarihi $q1->sinavSaati");
	$suan			= date("U");
	$bitisZamani	= $baslamaZamani + $q1->sinavSuresi*60;
	
	if ($suan>=$baslamaZamani && $suan<$bitisZamani){
		
		$soruID = $_SESSION['ogrenci']['sorular'][$_SESSION['ogrenci']['aktifSoruID']];
		$g = mysql_fetch_object(mysql_query("SELECT * FROM testsorulari WHERE id = '$soruID'"));
		
		$kod = '';
		if ($g->dil>0){
			require_once("geshi/geshi.php");
			$lang = mysql_fetch_object(mysql_query("SELECT * FROM programlamadilleri WHERE id = '$g->dil'"));
			$geshi = new GeSHi($g->kod, $lang->dil);
			$geshi->set_line_style('background: #F2F2F2;',true);
			$geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS);
			$geshi->enable_keyword_links(false);
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Balıkesir Üniversitesi - Edremit Meslek Yüksekokulu E-Sınav Projesi - &#169; Musa Öğretir 2013</title>
<link href="css/sinav.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/zebra_dialog.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.1.custom.js"></script>
<script type="text/javascript" src="js/zebra_dialog.js"></script>
<script type="text/javascript" src="js/jquery.base64.js"></script>
<script type="text/javascript" src="js/jquery.countdown.js"></script>
<script type="text/javascript" src="js/jquery.nicescroll.js"></script>
<script type="text/javascript" src="js/sinav.js"></script>
<style type="text/css">
<?php
	if ($g->dil>0){ echo $geshi->get_stylesheet();}
?>
</style>
</head>
<body>
	<div id="disCerceve">
			<div id="ustBaslik">
					<div id="ub1">
                    	<?php
							echo "<input type='hidden' id='sessionInfo' value='".base64_encode($_SESSION['ogrenci']['sinavID']."-".$_SESSION['ogrenci']['ogrID'])."'>";
							echo "<input type='hidden' id='pastAnswers' value='".base64_encode($_SESSION['ogrenci']['verdigiCevaplar'])."'>";
							$_SESSION['ogrenci']['sayfaYuklenmeSayisi']++;
							if ($_SESSION['ogrenci']['sayfaYuklenmeSayisi'] == 1){
								echo "<input type='hidden' id='pencereID' value='".$_SESSION['ogrenci']['pencereID']."'>";
							}else{
								echo "<input type='hidden' id='pencereID' value='hata'>";
							}
							echo "<div class='bilgiSatiri'>".$_SESSION["ogrenci"]["ogrNo"]."</div>";
						?>
                    </div>
                    <div id="ub2"></div>
                    <div id="ub3">
                    	<?php
							echo "<div class='bilgiSatiri'>".$_SESSION["ogrenci"]["ogrAd"]." ".$_SESSION['ogrenci']['ogrSoyad']."</div>";
						?>
                    </div>
                    <div id="ub4"></div>
                    <div id="ub5">
                    	<?php
							$q = mysql_fetch_object(mysql_query("SELECT * FROM sinavlar WHERE id = '".$_SESSION['ogrenci']['sinavID']."'"));
							$ss = explode("-",$q->sinavSorulari);
							echo "<div class='bilgiSatiri'>".count($ss)."</div>";
						?>
                    </div>
                    <div id="ub6"></div>
                    <div id="ub7"></div>
                    <div id="ub8"></div>
                    <div id="ub9">
                    	<?php
							echo "<div class='bilgiSatiri'>
										<div id='sinavSuresi'>
											<input type='hidden' id='examTime' value='".base64_encode($_SESSION['ogrenci']['sinavSuresi'])."' />
											<span id='hours'></span> :
											<span id='minutes'></span> :
											<span id='seconds'></span>
										</div>	
								  </div>";
						?>
                    </div>
			</div>
            <div id="ustBaslikAlt"></div>
            <div id="sol">
            		<div id="s1"></div>
                    <div id="s2">
                    	<?php
							$q = mysql_fetch_object(mysql_query("SELECT dersler.dersAdi FROM sinavlar INNER JOIN dersler ON dersler.id = sinavlar.ders WHERE sinavlar.id = '".$_SESSION["ogrenci"]["sinavID"]."'"));
							
							$a = new araclar();
							echo "<div class='bilgiSatiri'>".$a->ucfirst_tr($q->dersAdi)."</div>";
						?>
                    </div>
                    <div id="s3"></div>
                    <div id="s4">
                    	<?php
							$q = mysql_fetch_object(mysql_query("SELECT kullanicilar.ad,kullanicilar.soyad FROM sinavlar INNER JOIN kullanicilar ON kullanicilar.id = sinavlar.ogretimGorevlisi WHERE sinavlar.id = '".$_SESSION["ogrenci"]["sinavID"]."'"));
							
							$a = new araclar();
							echo "<div class='bilgiSatiri'>".$a->ucfirst_tr($q->ad)." ".$a->strtoupper_tr($q->soyad)."</div>";
						?>
                    </div>
                    <div id="s5"></div>
                    <div id="s6"></div>
                    <div id="soruAlani">
                    	<?php
							$soruID = $_SESSION['ogrenci']['sorular'][$_SESSION['ogrenci']['aktifSoruID']];
	
							$oncekiSoruIndex	= ($_SESSION['ogrenci']['aktifSoruID']-1)>=0 ? ($_SESSION['ogrenci']['aktifSoruID']-1) : 0;
							$sonrakiSoruIndex	= ($_SESSION['ogrenci']['aktifSoruID']+1)<(count($_SESSION['ogrenci']['sorular'])-1) ? ($_SESSION['ogrenci']['aktifSoruID']+1) : (count($_SESSION['ogrenci']['sorular'])-1);
							
							$g = mysql_fetch_object(mysql_query("SELECT * FROM testsorulari WHERE id = '$soruID'"));
							
							if ($g->dil>0) {$kod = $geshi->parse_code();}
							
							$soru = "
									<div class='soruTutucu'>
											<div class='soruNo'>SORU ".($_SESSION['ogrenci']['aktifSoruID']+1)." :</div>
											<div class='soruMetni'>".$kod.$g->soruMetni."</div>
											<div class='secenekTutucu'>
												<div class='secenek'>
													<div class='harf'>A)</div>
													<div class='secenek'>".$g->secA."</div>
												</div>
												<div class='secenek'>
													<div class='harf'>B)</div>
													<div class='secenek'>".$g->secB."</div>
												</div>
												<div class='secenek'>
													<div class='harf'>C)</div>
													<div class='secenek'>".$g->secC."</div>
												</div>
												<div class='secenek'>
													<div class='harf'>D)</div>
													<div class='secenek'>".$g->secD."</div>
												</div>						
									 ";
							if ($g->secE) {
								$soru .= "
											<div class='secenek'>
													<div class='harf'>D)</div>
													<div class='secenek'>".$g->secE."</div>
											</div>
										 ";
							}		 
							$soru .= "</div></div>
									  <div class='temizle'></div>	
									  <div class='butonTutucu'>
											<input type='button' value='< Önceki Soru' class='onceki' rel='".$oncekiSoruIndex."'/>
											<input type='button' value='Sonraki Soru >' class='sonraki' rel='".$sonrakiSoruIndex."'/>
									  </div>
									 ";	
							$soru .="<div class='soruNumaralari'>";
							for($i=1;$i<=count($_SESSION['ogrenci']['sorular']);$i++){
									if ($i==$_SESSION['ogrenci']['aktifSoruID']+1) $aktif = "aktif"; else $aktif ="";
									$soru .= "<div class='numara' align='center'><a class='$aktif' href='javascript:;' rel='".($i-1)."'>$i</a></div>";
							}
							$soru .="<div class='temizle'></div></div>";
							 
							
							if ($_SESSION['ogrenci']['sayfaYuklenmeSayisi']<2)
							{
								echo $soru;
							}else{
								echo "<div class='disari'>
											<p>Kullandığınız pencere sisteme ait değildir.<br/>Yeniden oturum açınız.</p>
											<a href='out.php'>Yeniden Oturum Aç</a>	
									  </div>";	
							}
							?>
	</div>
                        <div id="cevapAlani">
                        <?php
							$yaz = "<div class='secenekTutucu'>";
								for($i=1;$i<=count($_SESSION['ogrenci']['sorular']);$i++){
									$yaz.="
											<div class='satir'>
												<div class='sn'>$i</div>
												<div class='sec'><img src='img/a.png'></div>
												<div class='sec'><img src='img/b.png'></div>
												<div class='sec'><img src='img/c.png'></div>
												<div class='sec'><img src='img/d.png'></div>
										  ";
									if ($g->secE) {$yaz.="<div class='sec'><img src='img/e.png'></div>";}
									$yaz .= "<div class='temizle'></div>
											</div>";  
								}
							$yaz .= "</div>";
								
							if ($_SESSION['ogrenci']['sayfaYuklenmeSayisi']<2)
							{
								echo $yaz;
							}else{
								echo '';	
							}
						?>
                    </div>
                    <div id="s7"></div>
                    <div id="s8">
                    	<img src="img/sablon/anaarayuz_r5_c7.png" width="94" height="41" style="border:none;cursor:pointer" />
                    </div>
                    <div id="s9"></div>
                    <div id="s10">
                    	<img src="img/sablon/anaarayuz_r5_c10.png" width="74" height="41" style="border:none;cursor:pointer" />
                    </div>
                    <div id="s11"></div>
                    <div id="s12"></div>
            </div>
            <div id="sag"></div>
	</div>
</body>
</html>
<?php
	}else{ //Başlama Zamanı

	$time = date("H:i:s",$baslamaZamani);
	$dizi = explode(":",$time);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Balıkesir Üniversitesi - Edremit Meslek Yüksekokulu E-Sınav Projesi - &#169; Musa Öğretir 2013</title>
<link href="css/sinav.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.1.custom.js"></script>
<script type="text/javascript" src="js/jquery.lwtCountdown-1.0.js"></script>
<script type="text/javascript">
			$(document).ready(function(e) {
				//Seçim İptal
				(function($){
					$.fn.disableSelection = function() {
						return this
								 .attr('unselectable', 'on')
								 .css('user-select', 'none')
								 .on('selectstart', false);
					};
				})(jQuery);
				$("*").disableSelection();
				$("*").bind('contextmenu', function(e){return false;}); 
				$("#disCerceve").hide().fadeIn(1500);
				$("body").css("background-color","#2e2e2e");
				$("#disCerceve").css({"background":"url(img/saat.png) no-repeat","background-position":"right top"});
				$('#countdown_dashboard').countDown({
					targetDate: {
						'day'	:<?php echo ((int)date("d"));?>,
						'month'	:<?php echo ((int)date("m"));?>,
						'year'	:<?php echo date("Y");?>,
						'hour'	:<?php echo ((int)$dizi[0]);?>,
						'min'	:<?php echo ((int)$dizi[1]);?>,
						'sec'	:<?php echo ((int)$dizi[2]);?>
					},
					onComplete: function() { window.location='sinav'}
				});  
				var int=self.setInterval(function(){setbg()},5000);
				function setbg(){
					var i = Math.round(Math.random()*10);
					var renk = ['#2e2e2e','#421010','#101c42','#1a4210','#421037'];
					$("body").animate({backgroundColor :renk[i]});	
				}     
			});
</script>
<link href="css/darkCountDown.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
	<div id="disCerceve" align="center">
                    
                <!-- Countdown dashboard start -->
                <div class='aciklama'>
                    Sınavın Başlamasına Kalan Süre :
                </div>    
                <div id="countdown_dashboard">
                    <div class="dash hours_dash">
                        <span class="dash_title">hours</span>
                        <div class="digit">0</div>
                        <div class="digit">0</div>
                    </div>
        
                    <div class="dash minutes_dash">
                        <span class="dash_title">minutes</span>
                        <div class="digit">0</div>
                        <div class="digit">0</div>
                    </div>
        
                    <div class="dash seconds_dash">
                        <span class="dash_title">seconds</span>
                        <div class="digit">0</div>
                        <div class="digit">0</div>
                    </div>
                </div>
                <!-- Countdown dashboard end -->
                
                <?php
                    $q1 = mysql_fetch_object(mysql_query("SELECT * FROM sinavlar WHERE id = '".$_SESSION['ogrenci']['sinavID']."'"));
                    $ss = explode("-",$q1->sinavSorulari);
                    $q2 = mysql_fetch_object(mysql_query("SELECT * FROM dersler WHERE id = '".$q1->ders."'"));
                    $q3 = mysql_fetch_object(mysql_query("SELECT * FROM kullanicilar WHERE id = '".$q1->ogretimGorevlisi."'"));
                    $q4 = mysql_fetch_object(mysql_query("SELECT ogretimturu.tur FROM sinavlar INNER JOIN ogretimturu ON sinavlar.ogretimTuru = ogretimturu.id WHERE sinavlar.id = '".$_SESSION['ogrenci']['sinavID']."'"));
                    $q5 = mysql_fetch_object(mysql_query("SELECT bolumler.bolumAdi FROM sinavlar INNER JOIN bolumler ON sinavlar.bolum = bolumler.id WHERE sinavlar.id = '".$_SESSION['ogrenci']['sinavID']."'"));
                    $q6 = mysql_fetch_object(mysql_query("SELECT sinifseviyeleri.seviye FROM sinavlar INNER JOIN sinifseviyeleri ON sinavlar.seviye = sinifseviyeleri.id WHERE sinavlar.id = '".$_SESSION['ogrenci']['sinavID']."'"));
                ?>
                <div class="sinavBilgileri">
                    <div class="sutun">
                        <div class="bilgi"><?php echo "<div class='soru'>DERS : </div> <div class='cevap'>$q2->dersAdi</div>";?></div>
                        <div class="bilgi"><?php echo "<div class='soru'>ÖĞRETİM GÖREVLİSİ : </div> <div class='cevap'>$q3->ad $q3->soyad</div>";?></div>
                        <div class="bilgi"><?php echo "<div class='soru'>AÇIKLAMA : </div> <div class='cevap'>$q1->sinavAciklamasi</div>";?></div>
                        <div class="bilgi"><?php echo "<div class='soru'>SINAV SÜRESİ : </div> <div class='cevap'>$q1->sinavSuresi Dakika</div>";?></div>
                        <div class="bilgi"><?php echo "<div class='soru'>SORU SAYISI : </div> <div class='cevap'>".count($ss)."</div>";?></div>
                    </div>
                    <div class="sutun">
                        <div class="bilgi"><?php echo "<div class='soru'>KULLANICI : </div> <div class='cevap'>".$_SESSION['ogrenci']['ogrAd']." ".$_SESSION['ogrenci']['ogrSoyad']."</div>";?></div>
                        <div class="bilgi"><?php echo "<div class='soru'>OKUL NO : </div> <div class='cevap'>".$_SESSION['ogrenci']['ogrNo']."</div>";?></div>
                        <div class="bilgi"><?php echo "<div class='soru'>BÖLÜM : </div> <div class='cevap'>$q5->bolumAdi</div>";?></div>
                        <div class="bilgi"><?php echo "<div class='soru'>ÖĞRETİM : </div> <div class='cevap'>$q4->tur</div>";?></div>
                        <div class="bilgi"><?php echo "<div class='soru'>SINIF : </div> <div class='cevap'>$q6->seviye</div>";?></div>
                    </div>
                    <div class="temizle"></div>
                </div>
    </div>
<?php    
}
?>
</body>
</html>

