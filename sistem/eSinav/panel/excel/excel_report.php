<?php
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

$objPHPExcel->getProperties()->setCreator("Denizli MEM");
$objPHPExcel->getProperties()->setLastModifiedBy("Denizli MEM");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Denizli MEM");

// Add some data

$objPHPExcel->setActiveSheetIndex(0);

// Rename sheet

$objPHPExcel->getActiveSheet()->setTitle('RAPOR');

//Aktif Dönemi bul
require_once "../connect.php";

$veri = $_POST["alan"];

//Seçilen alanları oluştur
$d1 = array(1=>"ID",2=>"DÖNEM",3=>"T.C.KİMLİK NO",4=>"AD",5=>"SOYAD",6=>"KADROSUNUN BULUNDUĞU OKUL",7=>"DOKTORA",8=>"YÜKSEK LİSANS",9=>"HİZMET PUANI",10=>"BRANŞ",11=>"BELGE TARİHİ ve KURS NO",12=>"İLÇE",13=>"1.TERCİH",14=>"2.TERCİH",15=>"3.TERCİH",16=>"TERCİH DIŞI OKUL",17=>"CEP TELEFONU",18=>"E-POSTA",19=>"BAŞVURU TARİHİ");

$d2 = array(1=>"id",2=>"donem",3=>"tc",4=>"ad",5=>"soyad",6=>"kbo",7=>"dr",8=>"yl",9=>"hp",10=>"br",11=>"btkn",12=>"ilce",13=>"t1",14=>"t2",15=>"t3",16=>"tdo",17=>"ct",18=>"ep",19=>"skt");

for($i=0;$i<=18;$i++)
{
	if (!$veri)         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, 1, $d1[$i+1]); else {
	if ($d1[$veri[$i]]) $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, 1, $d1[$veri[$i]]);
	if ($d1[$veri[$i]]) $istenenler .=$d2[$veri[$i]].",";	
	}
}

$istenenler = trim($istenenler,",");

if (!$veri) {$istenenler = "*";}

//Veritabanından bilgileri çek
$s1 = mysql_fetch_object(mysql_query("SELECT id FROM donemler WHERE aktif='1'"));
$s2 = mysql_query("SELECT $istenenler FROM basvurular WHERE donem='".$s1->id."'");

$row = 2;
while($row_data = mysql_fetch_assoc($s2)) {
    $col = 0;
    foreach($row_data as $key=>$value) {
		if ($key=="kbo" || $key=="t1" || $key=="t2" || $key=="t3") 
		{
			$ogren = mysql_fetch_object(mysql_query("SELECT okul_adi FROM okullar WHERE sira_no='$value'"));
			$value = $ogren->okul_adi;	
		}
		
		if ($key=="dr" || $key =="yl") 
		{
			if ($value == 1) $value = "Var"; else $value="Yok";
		}
		
		if ($key=="br") 
		{
			$ogren = mysql_fetch_object(mysql_query("SELECT brans_adi FROM branslar WHERE brans_kodu='$value'"));
			$value = $ogren->brans_adi;	
		}
		
		if ($key=="ilce") 
		{
			$ogren = mysql_fetch_object(mysql_query("SELECT ilce_adi FROM ilceler WHERE ilce_kodu='$value'"));
			$value = $ogren->ilce_adi;	
		}
		
		if ($key=="tdo") 
		{
			if ($value == 1) $value = "Evet"; else $value="Hayır";
		}
		
		if ($key=="skt") $value = date("d/m/Y h:i:s");
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
        $col++;
    }
    $row++;
}


// Save Excel 2007 file
$raporAdi = "rapor.xlsx";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save($raporAdi);


?>
