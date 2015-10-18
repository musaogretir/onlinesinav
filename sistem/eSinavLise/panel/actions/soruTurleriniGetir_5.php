<?php
	require_once("headerActions.php");
	require_once("../class/connect.php");
	
	if ($_POST)
	{
		session_start();
		$msg = "";
		
		$msg = '<select id="soruTuru_5" name="soruTuru_5">
                  <option value="0">Seçiniz</option>';
                                                
		$sonuc = mysql_query("SELECT * FROM soruturleri");
		while($satir = mysql_fetch_array($sonuc)){
			$msg .= "<option value='".$satir['id']."'>".$satir['soruTuru']."</option>";	
		}
		
		$msg.="</select>";
		unset($_POST);
		
		echo $msg;
	}
?>