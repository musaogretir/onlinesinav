<?php
	require_once("headerSinav.php");
	require_once("connect.php");

	if ($_POST){
		$a = $_POST["a"];	//Sınav
		$b = $_POST["b"];	//Öğrenci
		$c = $_POST["c"];	//Cevaplar
		
		$v = mysql_query("UPDATE cevaplar SET ogrenciCevaplari = '$c' WHERE sinav = '$a' AND ogrenci= '$b' ");
		
		if ($v) echo "Cevaplarınız kaydedildi."; else echo "Bir hata oluştu. Tekrar deneyiniz.".mysql_error();
	}
?>