<?php
require_once("../class/connect.php");
require_once("headerActions.php");
	
	
	if ($_POST)
	{
		$a = mysql_real_escape_string($_POST['a']);
		$b = mysql_real_escape_string($_POST['b']);
		$c = mysql_real_escape_string($_POST['c']);
		$d = mysql_real_escape_string($_POST['d']);
		$e = mysql_real_escape_string($_POST['e']);
		$f = mysql_real_escape_string($_POST['f']);
		$g = mysql_real_escape_string($_POST['g']);
		$h = mysql_real_escape_string($_POST['h']);
		$i = explode('-',$_POST['i']);
		
		if ($i[2] == 4){ //4 Seçenek ise
			
			$sql = "INSERT INTO testsorulari VALUES(
						DEFAULT,
						1,
						'$i[0]',
						'$i[1]',
						'$b',
						'$a',
						'$c',
						'',
						'$d',
						'$e',
						'$f',
						'$g',
						'',
						'$h',
						'".$_SESSION["gecerliKullanici"]["userId"]."',
						'".date('U')."',
						'0'
					)";
			
			if (mysql_query($sql)){
				echo "Soru eklendi.";	
			}else{
				echo "Hata.<br/>".mysql_error();	
			}
					
		}
	}
	
?>