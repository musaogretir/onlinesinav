<?php
	require_once("headerSinav.php");
	require_once("connect.php");
	require_once("class/araclar.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Balıkesir Üniversitesi - Edremit Meslek Yüksekokulu E-Sınav Projesi - &#169; Musa Öğretir 2013</title>
<link href="css/cikis.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/cikis.js"></script>
</head>

<body>

	<div id="disCerceve">
		<div id="ustBaslik">
        	<?php 
					echo "<div id='b1'>".$_SESSION["ogrenci"]["ogrNo"]."</div>";
					$q = mysql_fetch_object(mysql_query("SELECT dersler.dersAdi FROM sinavlar INNER JOIN dersler ON dersler.id = sinavlar.ders WHERE sinavlar.id = '".$_SESSION["ogrenci"]["sinavID"]."'"));
					$a = new araclar();
					echo "<div id='b2'>".$_SESSION["ogrenci"]["ogrAd"]." ".$_SESSION['ogrenci']['ogrSoyad']." - ".$a->ucfirst_tr($q->dersAdi)."</div>";
					
			?>
        </div>
		<div id="orta">
        	<div id="msg">
            	SINAVINIZ BİTTİ,
                TEŞEKKÜRLER.
            </div>
            <div id="btn">
            	<img src="img/cikis/cikis.png" width="171" height="46" style="border:none" />
            </div>
        </div>
	</div>
</body>
</html>
