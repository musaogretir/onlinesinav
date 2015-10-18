<?php
require_once("../class/connect.php");
require_once("headerActions.php");
	
	
	if ($_POST)
	{
		session_start();
		$msg = "";
		
		$bolum			= $_POST['bolum_2'];
		$ders			= $_POST['dersler_2'];
		$soruSekli 		= $_POST['soruSekli'];
		$soruTuru  		= $_POST['soruTuru'];
		$secenekSayisi  = $_POST['secenekSayisi'];
		
		if ($soruSekli == 1){ //Kod
				if ($soruTuru == 1){ //Test
						if ($secenekSayisi == 4){
							
							$diller = '<select id="pDil">
											<option value="0">Seçiniz</option>
									  ';
							
							$q = mysql_query("SELECT * FROM programlamadilleri");
							
							while($al = mysql_fetch_object($q)){
								$diller .= '<option value="'.$al->id.'">'.$al->dil.'</option>';	
							}
							
							$diller .= '</select>';
							
							$msg .= '
										<div class="altSayfaFormAlaniBilgiSatiri">
                            			<div class="altSayfaFormSoruAlani">Programlama Dili : </div>
										<div class="altSayfaFormCevapAlani">
									'.
										$diller
									.'		
										</div>
										<div class="altSayfaFormAciklamaAlani">Programlama dilini seçiniz.</div>
										</div>
									';
							
							$msg .= '
										<div class="altSayfaFormAlaniBilgiSatiri" style="height:150px">
                            			<div class="altSayfaFormSoruAlani" style="height:140px">Kod : </div>
										<div class="altSayfaFormCevapAlani" style="height:140px">
												<textarea id="code" style="height:140px"></textarea>
										</div>
										<div class="altSayfaFormAciklamaAlani" style="height:140px">Kodları giriniz.</div>
										</div>
										
										<div class="altSayfaFormAlaniBilgiSatiri">
                            			<div class="altSayfaFormSoruAlani">Soru Metni : </div>
										<div class="altSayfaFormCevapAlani">
												<input type="text" id="soruMetni_2">
										</div>
										<div class="altSayfaFormAciklamaAlani">Soru metnini giriniz.</div>
										</div>
										
										<div class="altSayfaFormAlaniBilgiSatiri" style="height:150px">
                            			<div class="altSayfaFormSoruAlani" style="height:140px">Seçenekler : </div>
										<div class="altSayfaFormCevapAlani" style="height:140px">
												<input type="text" id="secA">
												<input type="text" id="secB">
												<input type="text" id="secC">
												<input type="text" id="secD">
										</div>
										<div class="altSayfaFormAciklamaAlani" style="height:140px">Seçenekleri giriniz.</div>
										</div>
										
										<div class="altSayfaFormAlaniBilgiSatiri">
                            			<div class="altSayfaFormSoruAlani">Doğru Cevap : </div>
										<div class="altSayfaFormCevapAlani">
												<select id="dogruCevap_2">
														<option value="0">Seçiniz</option>
														<option value="A">A</option>
														<option value="B">B</option>
														<option value="C">C</option>
														<option value="D">D</option>
												</select>
										</div>
										<div class="altSayfaFormAciklamaAlani">Doğru cevabı seçiniz.</div>
										</div>
										<input id="soruBilgisi_2" type="hidden" value="'.$bolum.'-'.$ders.'-'.$secenekSayisi.'" />
										<div class="altSayfaFormAlaniBilgiSatiri">
												<div class="altSayfaButonAlani">
													<div class="btnOnay" id="btnOnaySoruKaydet_2">
														<span class="img"><img src="img/confirmation.png" width="32" height="32" /></span>
														<span class="text"><a href="javascript:;">Kaydet</a></span>
													</div>
													<div class="btnIptal" id="temizle_2">
														<span class="img"><img src="img/error.png" width="32" height="32" /></span>
														<span class="text"><a href="javascript:;">Temizle</a></span>
													</div>  
												</div>
										</div>
									';
									
									
						}
						
						if ($secenekSayisi == 5){
							
						}
				}
		}
		
		
		if ($soruSekli == 2){ //Görsel
				if ($soruTuru == 1){ //Test
						if ($secenekSayisi == 4){
							
						}
						
						if ($secenekSayisi == 5){
							
						}
				}			
		}		
		
		echo $msg;
	}
?>