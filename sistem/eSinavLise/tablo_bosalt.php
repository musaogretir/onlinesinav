<?php
	require_once("connect.php");
	$s1 = "TRUNCATE TABLE cevaplar";
	$s2 = "TRUNCATE TABLE kalansure";
	$s3 = "TRUNCATE TABLE oturmaduzeni";
	$s4 = "TRUNCATE TABLE sifreler";
	$s5 = "TRUNCATE TABLE sinavlar";
	mysql_query($s1);
	mysql_query($s2);
	mysql_query($s3);
	mysql_query($s4);
	mysql_query($s5);
?>