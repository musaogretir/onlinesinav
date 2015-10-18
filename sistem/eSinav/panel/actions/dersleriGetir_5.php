<?php
require_once("../class/connect.php");
require_once("headerActions.php");
	
	
	if ($_POST)
	{
		session_start();
		$msg = "";
		
		$bolum = $_POST["a"];
		
		$msg = '<select id="dersler_5" name="dersler_5">
                  <option value="0">Seçiniz</option>';
                                                
		$sonuc = mysql_query("SELECT * FROM dersler WHERE bolum='$bolum'");
		while($satir = mysql_fetch_array($sonuc)){
			$msg .= "<option value='".$satir['id']."'>".$satir['dersAdi']."</option>";	
		}
		
		$msg.="</select>";
		unset($_POST);
		
		echo $msg;
	}
?>