<?php
	require_once("headerSinav.php");
	require_once("connect.php");
	
	if ($_POST){
		$a = $_POST["a"];
		$b = $_POST["b"];
		$c = $_POST["c"];	
		
		$u = mysql_query("UPDATE kalansure SET kalansure ='$a' WHERE sinav = '$b' AND ogrenci= '$c' ");
	}
?>