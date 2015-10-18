<?php
//Süre sınırlarını kaldır
set_time_limit(0);

/** Error reporting */
error_reporting(E_ALL);

/** Include path **/
ini_set('include_path', ini_get('include_path').';../Classes/');

/** PHPExcel */
include 'PHPExcel.php';

/** PHPExcel_Writer_Excel2007 */
include 'PHPExcel/Writer/Excel2007.php';

// Create new PHPExcel object

$objPHPExcel = new PHPExcel();

// Set properties

$objPHPExcel->getProperties()->setCreator("musaogretir.com");
$objPHPExcel->getProperties()->setLastModifiedBy("musaogretir.com");
$objPHPExcel->getProperties()->setTitle("musaogretir.com");
$objPHPExcel->getProperties()->setSubject("musaogretir.com");
$objPHPExcel->getProperties()->setDescription("musaogretir.com");

// Add some data

$objPHPExcel->setActiveSheetIndex(0);

// Rename sheet

$objPHPExcel->getActiveSheet()->setTitle('SINAV SORULARI');

require_once "../../connect.php";



//VER� TABANINDAN ALDIОIM B�LG�LER

$id = $_POST['a'];
		
$sorugetir = mysql_fetch_object(mysql_query("SELECT sinavSorulari FROM sinavlar WHERE id = '$id'"));
$sorular   = explode('-',$sorugetir->sinavSorulari);
$_SESSION['soruListesi'] = $sorular;

function siralama($v){
	$sl = explode('-',$v);
	$ey  = ''; 
	foreach($sl as $x){
		$ey .=(array_search($x,$_SESSION['soruListesi'])+1).'-';	
	}
	return trim($ey,'-');
}

//SINAVIN TAM ADI
$q = mysql_fetch_object(mysql_query("SELECT sinavlar.sinavTarihi, sinavturleri.sinavTuru, sinavlar.sinavSaati, sinifseviyeleri.seviye, dersler.dersAdi, ogretimturu.tur FROM sinavlar INNER JOIN dersler ON dersler.id = sinavlar.ders INNER JOIN ogretimturu ON ogretimturu.tur = sinavlar.ogretimTuru INNER JOIN sinifseviyeleri ON sinifseviyeleri.id = sinavlar.seviye INNER JOIN sinavturleri ON sinavlar.sinavTuru = sinavturleri.id WHERE sinavlar.id='$id'"));

$objPHPExcel->getActiveSheet()->setCellValue('A1', "Bilgisayar Programcılığı Bölümü $q->tur $q->seviye");
$objPHPExcel->getActiveSheet()->setCellValue('A2', "$q->dersAdi Dersi $q->sinavTuru Sınavı Sorularıdır.");
$objPHPExcel->getActiveSheet()->setCellValue('A3', "Tarih - Saat : $q->sinavTarihi $q->sinavSaati");

$objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle("A1:B3")->getFont()->setSize(16);
$styleArray = array(
	'font' => array(
	'bold' => true
	)
);
$objPHPExcel->getActiveSheet()->getStyle("A1:B5")->applyFromArray($styleArray);

$siraNo = 1;
$row = 4;
foreach($sorular as $soru){
	
	$q = mysql_query("SELECT * FROM testsorulari WHERE id = '$soru'");
	while($al = mysql_fetch_object($q))
	{
		try
		   {
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "SORU $siraNo)");
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, (trim($al->kod.' '.$al->soruMetni)));
				$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->applyFromArray(
					array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'CCCCCC')
						)
					)
				);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$row)->applyFromArray(
					array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'CCCCCC')
						)
					)
				);
				
				if (substr($al->secA,0,1) == '=') $al->secA = "'".$al->secA;
				if (substr($al->secB,0,1) == '=') $al->secB = "'".$al->secB;
				if (substr($al->secC,0,1) == '=') $al->secC = "'".$al->secC;
				if (substr($al->secD,0,1) == '=') $al->secD = "'".$al->secD;
				if (substr($al->secE,0,1) == '=') $al->secE = "'".$al->secE;
				
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "A ) ");
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, html_entity_decode($al->secA));	
				
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "B ) ");
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, html_entity_decode($al->secB));
				
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "C ) ");
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, html_entity_decode($al->secC));
				
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "D ) ");
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, html_entity_decode($al->secD));
				
				if ($al->secE){
					$row++;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "E ) ");
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, html_entity_decode($al->secE));
				}
		   }catch ( Exception $istisna )
		   {
			  echo $istisna->getMessage ();
			  echo $siraNo;
		   }

	}
	$row++;
	$siraNo++;
}

//Tablo haline getir.
$styleArray = array(
       'borders' => array(
             'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000'),
             ),
       ),
);

for ($col = 'A'; $col != "C"; $col++) {
	for($h=4;$h<$row;$h++)
	{
		$objPHPExcel->getActiveSheet()->getStyle($col."$h")->applyFromArray($styleArray);
		//Sola Yasla
		$objPHPExcel->getActiveSheet()->getStyle("B$h")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	}
}


//Sütun Genişliklerini Otomatik Ayarla
for ($col = 'A'; $col != 'B'; $col++) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
}


$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(110);
//Metni Kayd�r
$objPHPExcel->getActiveSheet()->getStyle('B1:B'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);

//Sayfayı Dikey Yap ve Yazdırma Alanını Belirle
$objPageSetup = new PHPExcel_Worksheet_PageSetup();
$objPageSetup->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
$objPageSetup->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPageSetup->setPrintArea("A1:B".($row-1));
$objPageSetup->setFitToPage(true); //Ölçeklemeye izin ver
$objPageSetup->setFitToWidth(1); //Ölçekleme 1 = %100
$objPageSetup->setFitToHeight(ceil($row/65)); //Sayfa adedi
$objPageSetup->setHorizontalCentered(true); //Sayfayı yatayda ortala
$objPHPExcel->getActiveSheet()->setPageSetup($objPageSetup);

//ÖĞRENCI CEVAPLARINI SAYFALARA AT

$i=1;
$q1 = mysql_query("SELECT * FROM cevaplar WHERE sinav = '$id' ORDER BY ogrenci");

$q2 = mysql_fetch_object(mysql_query("SELECT bolumler.bolumAdi, sinifseviyeleri.seviye, ogretimturu.tur FROM sinavlar INNER JOIN bolumler ON sinavlar.bolum=bolumler.id INNER JOIN sinifseviyeleri ON sinifseviyeleri.id=sinavlar.seviye INNER JOIN ogretimturu ON sinavlar.ogretimTuru=ogretimturu.id WHERE sinavlar.ogretimYili = (SELECT id FROM ogretimyili WHERE aktif=1) AND sinavlar.donem = (SELECT id FROM donemler WHERE aktif=1) AND sinavlar.id = '$id'"));
		
while($al = mysql_fetch_object($q1)){
	$row=6;
	
	$q3 = mysql_fetch_object(mysql_query("SELECT ad,soyad,okulNo FROM siniflisteleri WHERE id ='$al->ogrenci'"));
	
	try
	{
		$objPHPExcel->createSheet($i);
		$objPHPExcel->setActiveSheetIndex($i);
		$objPHPExcel->getActiveSheet()->setTitle("OGR $i");
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Bölüm, Sınıf, Öğretim :");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, "$q2->bolumAdi $q2->seviye $q2->tur");
		$objPHPExcel->getActiveSheet()->mergeCells('B1:C1');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Adı, Soyadı :");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "$q3->ad $q3->soyad");
		$objPHPExcel->getActiveSheet()->mergeCells('B2:C2');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "Okul No :");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "$q3->okulNo");
		$objPHPExcel->getActiveSheet()->getStyle("B3")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
		$objPHPExcel->getActiveSheet()->getStyle("B3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->mergeCells('B3:C3');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "Soru Sıralaması :");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 4, siralama($al->soruSiralamasi));
		$objPHPExcel->getActiveSheet()->mergeCells('B4:C4');
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 5, "Öğrenci Cevapları :");
		$objPHPExcel->getActiveSheet()->mergeCells('A5:C5');
		
		$ss = explode("-",$al->soruSiralamasi);
		$c  = explode("-",$al->ogrenciCevaplari);
		$say=0;
		$ds =0;
		$bs =0;
		$ys =0;
		foreach($c as $index=>$cvp){
			$q4 = mysql_fetch_object(mysql_query("SELECT dogruCevap FROM testsorulari WHERE id = '$ss[$index]'"));
			if ($cvp =='X') {$cevap = "Boş";$bs++;} else $cevap = $cvp;
			if ($cevap != "Boş"){
				if ($q4->dogruCevap == $cevap) {$durum = 'Doğru';$ds++;} else {$durum = 'Yanlış';$ys++;}
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, ($index+1));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, ($cevap));
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, ($durum));
			$row++;   
		}
		$soruSayisi = $ds + $ys + $bs;
		$puan  = (100 / $soruSayisi) * $ds;
		
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "Doğru Sayısı :");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $ds);
		$objPHPExcel->getActiveSheet()->mergeCells("B$row:C$row");
		$row++;
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "Yanlış Sayısı :");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $ys);
		$objPHPExcel->getActiveSheet()->mergeCells("B$row:C$row");
		$row++;
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "Boş Sayısı :");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $bs);
		$objPHPExcel->getActiveSheet()->mergeCells("B$row:C$row");
		$row++;
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "PUAN :");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, ceil($puan));
		$objPHPExcel->getActiveSheet()->mergeCells("B$row:C$row");
			
		//Tablo haline getir.
		$styleArray = array(
			   'borders' => array(
					 'outline' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000'),
					 ),
			   ),
		);
		
		for ($col = 'A'; $col != "D"; $col++) {
			for($h=1;$h<=$row;$h++)
			{
				$objPHPExcel->getActiveSheet()->getStyle($col."$h")->applyFromArray($styleArray);
				//Sa�a Yasla
				$objPHPExcel->getActiveSheet()->getStyle("A$h")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				if ($h>5){
					//Ortala
					$objPHPExcel->getActiveSheet()->getStyle("A$h")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle("B$h")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyle("C$h")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				}
			}
		}
		//Sütun Genişliklerini Otomatik Ayarla
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getStyle("A5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		
		//Sayfayı Dikey Yap ve Yazdırma Alanını Belirle
		$objPageSetup = new PHPExcel_Worksheet_PageSetup();
		$objPageSetup->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
		$objPageSetup->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
		$objPageSetup->setPrintArea("A1:C".($row));
		$objPageSetup->setFitToPage(true); //Ölçeklemeye izin ver
		$objPageSetup->setFitToWidth(1); //Ölçekleme 1 = %100
		$objPageSetup->setFitToHeight(ceil($row/65)); //Sayfa adedi
		$objPageSetup->setHorizontalCentered(true); //Sayfayı yatayda ortala
		$objPHPExcel->getActiveSheet()->setPageSetup($objPageSetup);
	}catch(Exception $istisna){
		echo $istisna->getMessage();	
	}
	
	$i++;
}



$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
$raporAdi = "rapor.xlsx";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save($raporAdi);

if (file_exists($raporAdi)){
	echo '
			<div class="altSayfaButonAlani" style="margin-left:450px">
				<div class="btnOnay" style="width:180px">
					<span class="img"><img src="img/confirmation.png" width="32" height="32" /></span>
					<span class="text"><a href="excel/'.$raporAdi.'">Raporu Kaydet</a></span>
				</div>
			</div>
			';
}
?>
