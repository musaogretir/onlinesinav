<?php
	require_once("headerActions.php");
	require_once("../class/connect.php");
	
	if ($_POST)
	{
		session_start();
		$msg = "";
		$kullanici = $_POST["kKullanici"];
		$_POST["liste"] ? $yetkiler  = trim($_POST["liste"],"-") : $yetkiler = "yetkisiz";
		
		$veri = explode('-',$yetkiler);
		for($i=0;$i<count($veri);$i++){
			for($j=0;$j<count($veri);$j++){
				if ($veri[$i]<$veri[$j]){
					$g = $veri[$i];
					$veri[$i] = $veri[$j];
					$veri[$j] = $g;
				}
			}
		}
		
		$yetkiler = implode('-',$veri);
		
		$db = mysql_query("UPDATE kullanicilar SET yetkiler = '$yetkiler' WHERE id='$kullanici'");

		if ($db){
			$msg = "Yetkilendirme tamamlandı.";	
		}else{
			$msg = "Yetkilerde değişiklik yapmadınız. <br/>".mysql_error();	
		}
		echo $msg;
	}
?>