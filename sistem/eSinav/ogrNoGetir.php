<?php
	require_once('connect.php');
	
	$data = mysql_real_escape_string($_POST['data']);
	$sql  = mysql_query("SELECT * FROM siniflisteleri WHERE ogretimYili = (SELECT id FROM ogretimyili WHERE aktif = 1) AND donem = (SELECT id FROM donemler WHERE aktif = 1) AND okulNo LIKE '$data%' LIMIT 0,9");
	
	$yaz = "<ul class='autocomplete'>";
	while($al = mysql_fetch_object($sql)){
			$yaz .="<li>
						<label>$al->okulNo</label> - $al->ad $al->soyad
					</li>";
	}
	$yaz.= "</ul>";
	
	echo $yaz;
?>