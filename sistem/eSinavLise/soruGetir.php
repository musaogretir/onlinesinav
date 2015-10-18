<?php
require_once("headerSinav.php");
require_once("connect.php");
	
if ($_POST['soruID'] != null){ //Butonlara Tıklandığında [Önceki soru - Sonraki Soru]
	
	$istenen = $_POST['soruID'];
	$pID	 = $_POST['pID'];
	
	if ($pID == $_SESSION['ogrenci']['pencereID'])
	{
		$_SESSION['ogrenci']['aktifSoruID'] = $istenen;
		
		$oncekiSoruIndex	= ($istenen-1)>=0 ? ($istenen-1) : 0;
		$sonrakiSoruIndex	= ($istenen+1)<(count($_SESSION['ogrenci']['sorular'])) ? ($istenen+1) : (count($_SESSION['ogrenci']['sorular'])-1);
		
		$g = mysql_fetch_object(mysql_query("SELECT * FROM testsorulari WHERE id = '".$_SESSION['ogrenci']['sorular'][$istenen]."'"));
		
		$soru = "
				<div class='soruTutucu'>
						<div class='soruNo'>SORU ".($_SESSION['ogrenci']['aktifSoruID']+1)." :</div>
						<div class='soruMetni'>".$g->soruMetni."</div>
						<div class='secenekTutucu'>
							<div class='secenek'>
								<div class='harf'>A)</div>
								<div class='secenek'>".$g->secA."</div>
							</div>
							<div class='secenek'>
								<div class='harf'>B)</div>
								<div class='secenek'>".$g->secB."</div>
							</div>
							<div class='secenek'>
								<div class='harf'>C)</div>
								<div class='secenek'>".$g->secC."</div>
							</div>
							<div class='secenek'>
								<div class='harf'>D)</div>
								<div class='secenek'>".$g->secD."</div>
							</div>						
				 ";
		if ($g->secE) {
			$soru .= "
						<div class='secenek'>
								<div class='harf'>D)</div>
								<div class='secenek'>".$g->secE."</div>
						</div>
					 ";
		}		 
		$soru .= "</div></div>
				  <div class='temizle'></div>
				  <div class='butonTutucu'>
						<input type='button' value='< Önceki Soru' class='onceki' rel='".$oncekiSoruIndex."'/>
						<input type='button' value='Sonraki Soru >' class='sonraki' rel='".$sonrakiSoruIndex."'/>
				  </div>
				 ";	
		$soru .="<div class='soruNumaralari'>";
		for($i=1;$i<=count($_SESSION['ogrenci']['sorular']);$i++){
				if ($i==$istenen+1) $aktif = "aktif"; else $aktif ="";
				$soru .= "<div class='numara' align='center'><a class='$aktif' href='javascript:;' rel='".($i-1)."'>$i</a></div>";
		}
		$soru .="<div class='temizle'></div></div>";
		echo $soru; 
	}
	else{
		echo "<div class='disari'>
					<p>Kullandığınız pencere sisteme ait değildir.<br/>Yeniden oturum açınız.</p>
					<a href='out.php'>Yeniden Oturum Aç</a>	
			  </div>";
	}
}
?>
	