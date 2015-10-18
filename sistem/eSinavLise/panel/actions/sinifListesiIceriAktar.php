<?php
	require_once("headerActions.php");
	require_once("../class/connect.php");
	require_once("../class/PHPExcel.php");
	
	if ($_FILES || $_POST["bilgi_30"])
	{
			if ($_FILES["ogrenciListesiYukle_30"]["error"] > 0)
		  	{
		  		$msg = $_FILES["ogrenciListesiYukle_30"]["error"];
		  	}
			else
		  	{
				$ext	= explode(".",$_FILES["ogrenciListesiYukle_30"]["name"]);
				$size	= count($ext)-1;
				$rName	= "../temp/".md5(date("U").$_SESSION["gecerliKullanici"]["userName"]).".".$ext[$size];$uzanti=$ext[$size];
				move_uploaded_file($_FILES["ogrenciListesiYukle_30"]["tmp_name"],$rName);
				$file	= $_FILES["ogrenciListesiYukle_30"]["name"];
			  	$type	= $_FILES["ogrenciListesiYukle_30"]["type"];
			  	$path	= $_FILES["ogrenciListesiYukle_30"]["tmp_name"];
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
			$sutunlar	= array();
			$baslangicNoktasi = 0;
			$cikis 		= false; 
			
			foreach($rowIterator as $row){
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(true); // true:sadece veri alanlarını oku; false: tüm alanları oku
				$rowIndex = $row->getRowIndex ();
				foreach ($cellIterator as $cell) { //Veri Başlangıcını bul
					if ($cell->getCalculatedValue() == "Adı Soyadı") {
						$baslangicNoktasi = $row->getRowIndex ()+1;
						array_push($sutunlar,$cell->getColumn());
					}
					if ($cell->getCalculatedValue() == "Sıra No") {
						array_push($sutunlar,$cell->getColumn());
					}
					if ($cell->getCalculatedValue() == "Okul No") {
						array_push($sutunlar,$cell->getColumn());
					}
					if ($cell->getCalculatedValue() == "Adı Soyadı") {
						array_push($sutunlar,$cell->getColumn());
					}
				}	
			}
			
			
			
			foreach($rowIterator as $row){
				if ($cikis) break;
				
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(true); // true:sadece veri alanlarını oku; false: tüm alanları oku
				if($row->getRowIndex ()< $baslangicNoktasi) continue;//Gereksiz Satırları Atla
				$rowIndex = $row->getRowIndex ();
				$array_data[$rowIndex] = @explode('','ABCDEFGHIJKLMNOPQRSTUVWYZ'); //Sütun adlarını oluştur
				 
				foreach ($cellIterator as $cell) {
					if ($cell->getCalculatedValue()=="") {$cikis=true;break;} // Liste Sonu
					if(in_array($cell->getColumn(),$sutunlar)){
						$array_data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();
					}
				}
			}
			
			unlink($rName); //Yüklenen dosyayı sil
			
			if ($_POST["bilgi_30"]) $_SESSION["listeBilgileri"] = $_POST["bilgi_30"];
			$bilgi = explode("-",$_SESSION["listeBilgileri"]);
			
			$r = mysql_fetch_object(mysql_query("SELECT * FROM bolumler WHERE id='".$bilgi[0]."'"));
			$bolumAdi = $r->bolumAdi;
			
			$r = mysql_fetch_object(mysql_query("SELECT * FROM sinifseviyeleri WHERE id='".$bilgi[1]."'"));
			$sinifSeviyesi = $r->seviye;
			
			$r = mysql_fetch_object(mysql_query("SELECT * FROM dallar WHERE id='".$bilgi[2]."'"));
			$dal = $r->dal;
			
			
			$ogrenciListesi=array();
			$row = ""; 
			
			echo "<table class='tabloListe' align='center'>";
			echo "<tr style='font-weight:bold'><td align='right'>Bölüm :</td><td colspan='2'>$bolumAdi</td></tr>";
			echo "<tr style='font-weight:bold'><td align='right'>Seviye :</td><td colspan='2'>$sinifSeviyesi</td></tr>";
			echo "<tr style='font-weight:bold'><td align='right'>Dal :</td><td colspan='2'>$dal</td></tr>";
			echo "<tr style='font-weight:bold;background-color:#000;color:#FFF'><td>S.N.</td><td>Okul No</td><td>Ad Soyad</td></tr>";
			foreach($array_data as $satir){
				if (!empty($satir)) echo "<tr>";
				foreach($satir as $hucre){
					if (!empty($satir)){
						echo "<td>$hucre</td>";
						@$row .=$hucre."-";
					}
				}
				@$row = trim($row,'-');
				array_push($ogrenciListesi,$row);
				unset($row);
				if (!empty($satir)) echo "</tr>";
			}
			echo "<tr> 
				  	<td colspan='4' align='center'>
						<input type='button' value='Listeyi Kaydet' id='btn_ogrenciListesiKaydet_30'/>
				  	</td>
				  </tr>";
			echo "</table>";
			
			$_SESSION["ogrenciListesi_30"] = $ogrenciListesi;
	}


?>