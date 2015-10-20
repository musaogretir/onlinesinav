<?php
	ob_start();
	header("Content-Type: text/html; charset=utf-8");
    ini_set("display_errors",0);
  
     $dbhost = "localhost";
    $dbuser = "...";
    $dbpass = "...";
    $dbname = "...";
    
    $baglan=mysql_connect($dbhost,$dbuser,$dbpass) or die("Geçersiz Host");
    
	 

    mysql_select_db($dbname) or die("Geçersiz Database");
    mysql_query("SET NAMES 'utf8'");  
    mysql_query("SET CHARACTER SET utf8");  
    mysql_query("SET COLLATION_CONNECTION = 'utf8_turkish_ci'"); 
?>
