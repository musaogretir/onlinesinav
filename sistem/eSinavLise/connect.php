﻿<?php
	ob_start();
    ini_set("display_errors",0);
  
    $dbhost = "localhost";
    $dbuser = "musaogre_es2";
    $dbpass = "$)zNl463qf!$";
    $dbname = "musaogre_esinavLise";
    
    $baglan=mysql_connect($dbhost,$dbuser,$dbpass) or die("Geçersiz Host");
    
	 

    mysql_select_db($dbname) or die("Geçersiz Database");
    mysql_query("SET NAMES 'utf8'");  
    mysql_query("SET CHARACTER SET utf8");  
    mysql_query("SET COLLATION_CONNECTION = 'utf8_turkish_ci'"); 
?>
