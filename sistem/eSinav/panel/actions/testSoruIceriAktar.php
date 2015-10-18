<?php
	require_once("headerActions.php");
	require_once("../class/PHPExcel.php");
	
	if ($_FILES || $_POST["bilgi_5"])
	{
			$uzanti = "";
			if ($_FILES["testSoruYukle_5"]["error"] > 0)
		  	{
		  		$msg = $_FILES["testSoruYukle_5"]["error"];
		  	}
			else
		  	{
				$ext	= explode(".",$_FILES["testSoruYukle_5"]["name"]);
				$size	= count($ext)-1;
				$rName	= "../temp/".md5(date("U").$_SESSION["gecerliKullanici"]["userName"]).".".$ext[$size];$uzanti=$ext[$size];
				move_uploaded_file($_FILES["testSoruYukle_5"]["tmp_name"],$rName);
				$file	= $_FILES["testSoruYukle_5"]["name"];
			  	$type	= $_FILES["testSoruYukle_5"]["type"];
			  	$path	= $_FILES["testSoruYukle_5"]["tmp_name"];
		  	}
			
			if ($uzanti == "xlsx") {
				$objReader = new PHPExcel_Reader_Excel2007();
			}else{
				$objReader = new PHPExcel_Reader_Excel5();
			}
			$objReader->setReadDataOnly(true);
			$objPHPExcel = $objReader->load($rName);
			
			$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
			
			$array_data = array();
			foreach($rowIterator as $row){
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(true); // true:sadece veri alanlarını oku; false: tüm alanları oku
				//if($row->getRowIndex ()<25) continue;//ilk 25 satırı atla
				$rowIndex = $row->getRowIndex ();
				$array_data[$rowIndex] = array('A'=>'');
				 
				foreach ($cellIterator as $cell) {
					$array_data[$rowIndex][$cell->getColumn()] = htmlspecialchars($cell->getCalculatedValue(),ENT_QUOTES);					
				}
			}
			
			unlink($rName); //Yüklenen dosyayı sil
			
			if ($_POST["bilgi_5"]) $_SESSION["testSorularAyarlar"] = $_POST["bilgi_5"];
			$bilgi = explode("-",$_SESSION["testSorularAyarlar"]);
			
						
			
			$sorular=array();
			$kontrol = $bilgi[3];
			$sayac = 1;
			$sorumu = true;
			$secenekler = array(0=>"A",1=>"B",2=>"C",3=>"D",4=>"E");
			$harf = 0;
			
			$kaydet = "";
			
			echo "<ul class='sorularListe'><li class='baslik'>SORULAR</li>";
			foreach($array_data as $row){
				foreach($row as $cell){
					$cell = trim($cell);
					if ($sorumu){
						$kaydet = $cell . "XXX***XXX";
						echo "<ul><li class='soru'>$sayac)$cell</li>";
						$sorumu = false;
					}else{
						if ($harf<$kontrol){
							echo "<li class='secenek'><span class='harf'>$secenekler[$harf] -</span><span class='metin'>$cell</span><div class='temizle'></div></li>";
							$kaydet .= ($cell) . "XXX***XXX";	
						}
						$harf++;
					}
					if ($harf == $kontrol+1) {echo "<li class='dogruCevap'>Doğru Cevap : $cell</li>";$kaydet .= ($cell) . "XXX***XXX";}
				}
				if ($harf == $kontrol+1) {
					echo "</ul>";$harf = 0;$sayac++; $sorumu = true; array_push($sorular,trim($kaydet,"XXX***XXX"));unset($kaydet);
				}
			}
			echo "<li class='btnTestKaydet'><input type='button' value='Soruları Kaydet' id='btn_test_Sorulari_Kaydet_5'/></li></ul>";
			
			$_SESSION["testSorular_5"] = $sorular;
	}


?>