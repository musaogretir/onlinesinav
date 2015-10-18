<?php
	require_once("headerSinav.php");
	require_once("connect.php");

	if ($_POST){
		$a = $_POST["a"];	//Sınav
		$b = $_POST["b"];	//Öğrenci
		
		$u = mysql_query("UPDATE kalansure SET kalansure ='0' WHERE sinav = '$a' AND ogrenci= '$b' ");
		echo "OK";
	}
?>