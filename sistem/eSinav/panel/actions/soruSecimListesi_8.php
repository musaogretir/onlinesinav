<?php
require_once("../class/connect.php");
require_once("headerActions.php");
	
	
	$msg = "";
	if ($_POST)
	{
		$sinavTuru	= $_POST["sinavTuru_8"];
		$sinav		= $_POST["sinav_8"];
		$soruTuru	= $_POST["soruTuru_8"];
		$secenekSay	= $_POST["secenekSayisi"];
		
		if ($soruTuru == 1){ //Test ise
			if ($secenekSay == 4){
				$q1 = mysql_fetch_object(mysql_query("SELECT ders FROM sinavlar WHERE id = '$sinav' ")); //Dersi öğren
				$q2 = mysql_query("SELECT * FROM testsorulari WHERE ders = '$q1->ders' AND secE = '' AND ekleyen = '".$_SESSION["gecerliKullanici"]["userId"]."'"); //Derse ait soruları al
				
				$sayac = 1;
				$msg = "<ul class='sorularListe' onselectstart='return false;' ondragstart='return false;'><li class='baslik'>SORULAR</li>";		
				while ($al = mysql_fetch_object($q2) ){
						
						$hl = mysql_fetch_object(mysql_query("SELECT * FROM testsorulari WHERE id = '$al->id'"));
						$kod = '';
						if ($hl->dil>0){
							require_once("../geshi/geshi.php");
							$lang = mysql_fetch_object(mysql_query("SELECT * FROM programlamadilleri WHERE id = '$hl->dil'"));
							$geshi = new GeSHi($hl->kod, $lang->dil);
							$geshi->set_line_style('background-color: #F2F2F2',true);
							$geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS);
							$geshi->enable_keyword_links(false);
							echo "<style type='text/css'>$geshi->get_stylesheet()</style>";
							$kod = $geshi->parse_code();
						}
						
						$msg .= "<ul val='$al->id'><li class='soru'>$sayac)$kod $al->soruMetni</li>";
						$msg .= "<li class='secenek'><span class='harf'>A -</span><span class='metin'>$al->secA</span><div class='temizle'></div></li>";
						$msg .= "<li class='secenek'><span class='harf'>B -</span><span class='metin'>$al->secB</span><div class='temizle'></div></li>";
						$msg .= "<li class='secenek'><span class='harf'>C -</span><span class='metin'>$al->secC</span><div class='temizle'></div></li>";
						$msg .= "<li class='secenek'><span class='harf'>D -</span><span class='metin'>$al->secD</span><div class='temizle'></div></li>";
						$msg .= "<li class='dogruCevap'>Doğru Cevap : $al->dogruCevap</li>";
						$msg .= "</ul>";
						$sayac++;
				}
				
				$msg .= "<li class='btnTestKaydet'><input type='button' value='Soru Seçimini Kaydet' id='btn_test_Sorulari_Sec_8'/></li></ul>";
				
				
			}
			if ($secenekSay == 5){
				$q1 = mysql_fetch_object(mysql_query("SELECT ders FROM sinavlar WHERE id = '$sinav' ")); //Dersi öğren
				$q2 = mysql_query("SELECT * FROM testsorulari WHERE ders = '$q1->ders' AND secE <> '' AND ekleyen = '".$_SESSION["gecerliKullanici"]["userId"]."'"); //Derse ait soruları al
				
				$sayac = 1;
				$msg = "<ul class='sorularListe' onselectstart='return false;' ondragstart='return false;'><li class='baslik'>SORULAR</li>";		
				while ($al = mysql_fetch_object($q2) ){
						
						$hl = mysql_fetch_object(mysql_query("SELECT * FROM testsorulari WHERE id = '$al->id'"));
						$kod = '';
						if ($hl->dil>0){
							require_once("../geshi/geshi.php");
							$lang = mysql_fetch_object(mysql_query("SELECT * FROM programlamadilleri WHERE id = '$hl->dil'"));
							$geshi = new GeSHi($hl->kod, $lang->dil);
							$geshi->set_line_style('background-color: #F2F2F2',true);
							$geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS);
							$geshi->enable_keyword_links(false);
							echo "<style type='text/css'>$geshi->get_stylesheet()</style>";
							$kod = $geshi->parse_code();
						}
					
					
						$msg .= "<ul val='$al->id'><li class='soru'>$sayac)$kod $al->soruMetni</li>";
						$msg .= "<li class='secenek'><span class='harf'>A -</span><span class='metin'>$al->secA</span><div class='temizle'></div></li>";
						$msg .= "<li class='secenek'><span class='harf'>B -</span><span class='metin'>$al->secB</span><div class='temizle'></div></li>";
						$msg .= "<li class='secenek'><span class='harf'>C -</span><span class='metin'>$al->secC</span><div class='temizle'></div></li>";
						$msg .= "<li class='secenek'><span class='harf'>D -</span><span class='metin'>$al->secD</span><div class='temizle'></div></li>";
						$msg .= "<li class='secenek'><span class='harf'>E -</span><span class='metin'>$al->secE</span><div class='temizle'></div></li>";
						$msg .= "<li class='dogruCevap'>Doğru Cevap : $al->dogruCevap</li>";
						$msg .= "</ul>";
						$sayac++;
				}
				
				$msg .= "<li class='btnTestKaydet'><input type='button' value='Soru Seçimini Kaydet' id='btn_test_Sorulari_Sec_8'/></li></ul>";
			}
		}
	}
	else
	{
		$msg = "Bilgiler eksik.<br/>Sistemi yöneticisine başvurunuz.";	
	}
	
	echo $msg;
		
?>