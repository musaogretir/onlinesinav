<?php
require_once("../class/connect.php");
require_once("headerActions.php");
	
	
	if ($_POST)
	{
		$msg	= "";
		$a		= mysql_real_escape_string(trim($_POST["a"]));
		
		if ($a){
			$g = mysql_query("UPDATE ogretimyili SET aktif = 0");
			$g = mysql_query("UPDATE ogretimyili SET aktif = 1 WHERE id='$a'");
			$g = mysql_fetch_object(mysql_query("SELECT * FROM ogretimyili WHERE id='$a'"));
			
			$msg = $g->ogretimYili." Öğretim yılı aktif yapıldı.";
		}else{
			$msg = "Seçim yapınız.";	
		}
		echo $msg;
	}
	
?>