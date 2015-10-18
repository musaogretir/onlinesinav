

$(document).delegate("#sinavTarihi_7","focus",function(){
	$(function() {
		$( "#sinavTarihi_7" ).datepicker({
		  showWeek: true,
		  firstDay: 1,
		  dateFormat: 'dd-mm-yy' 
		});
	});
});

$(document).delegate("#sinavSaati_7","focus",function(){
	$('#sinavSaati_7').timeEntry($.timeEntry.regional['tr']).css({"width":"300px","padding":"3px","margin-left":"5px"}); 
});

$(document).delegate("#sinavSuresi_7","keydown",function(e){
	$(this).numeric({ negative : false , decimal : false});
});


//Sınav Oluştur Menüsü Sınav Oluştur Butonu
$(document).delegate("#btnOnaySinavOlustur_7","click",function(e) {
		var msg = "";
		
		if ($("#ogretimYili_7 option:selected").val()==0) {
			msg = "Öğretim yılını seçiniz.";
		}else{
			if ($("#donem_7 option:selected").val()==0) {
				msg = "Dönemi seçiniz.";
			}else{
				if ($("#sinavTuru_7 option:selected").val()==0) {
					msg = "Sınav türünü seçiniz.";
				}else{
					if ($("#ogretimGorevlisi_7 option:selected").val()==0){
						msg = "Öğretim görevlisini seçiniz.";	
					}else{
						if (!$("#sinavTarihi_7").val()){
							msg = "Sınav tarihini giriniz.";
						}else{
							if (!$("#sinavSaati_7").val()){
								msg = "Sınav saatini giriniz.";
							}else{
								if (!$("#sinavSuresi_7").val()){
									msg = "Sınav süresini giriniz.";
								}else{
									if (!$("#sinavAciklamasi_7").val()){
										msg = "Sınav açıklamasını giriniz.";
									}else{
										if ($("#bolum_7 option:selected").val()==0){
											msg = "Bölümü seçiniz.";
										}else{
											if ($("#dersler_7 option:selected").val()==0){
												msg = "Dersi seçiniz.";
											}else{
												if ($("#seviye_7 option:selected").val()==0){
													msg = "Sınıf seviyesini seçiniz.";
												}else{
													if ($("#ogretimTuru_7 option:selected").val()==0){
														msg = "Öğretim türünü seçiniz.";
													}	
												}
											}
										}
									}	
								}
							}
						}
					}
				}
			}
		}
		
		if (!msg){
				var $this = $(this);
				$this.fadeOut(500).after("<div class='bekleyiniz' align='center'><span><img src='img/loader.gif'></span><span>İşleminiz Gerçekleştiriliyor. Lütfen Bekleyiniz...</span></div>");
				$.ajax({
								type	: 'POST',
								data	: $("#sinavOlusturForm_7").serialize(),
								url		: 'actions/sinavOlustur.php',
								cache	: 'false',
								success	: function(a){
											
											if (($.trim(a)).indexOf("Sınav oluşturuldu")>=0)		
											{
												$.Zebra_Dialog(a, {
													'type'		:'information',
													'title'		:'Bilgi',
													'buttons'	:['Tamam'],
													'onClose'	:function(caption) {
														if (caption == 'Tamam'){
															$.ajax({
																	type	: 'POST',
																	url		: 'pages/8.php',
																	data	: '',
																	success	: function(a){
																		$("div#icerik").html(a).hide().fadeIn(800);	
																	}
															});
														}
													}
												});
											}else{
												$.Zebra_Dialog(a, {'type': 'error','title':'Hata'});
												$this.fadeIn(500);
												$(".bekleyiniz").remove();
											}
								},
								error	:function(x,e){
										if(x.status==0){
											msg='Bağlantı kurulamadı!<br/> İnternet bağlantınızı kontrol edin.';
										}else if(x.status==404){
											msg='İstenen URL bulunamadı.';
										}else if(x.status==500){
											msg='Sunucu hatası.';
										}else if(e=='parsererror'){
											msg='Hata.<br/>JSON isteği gerçekleştirilemedi.';
										}else if(e=='timeout'){
											msg='İstek zaman aşımı.';
										}else {
											msg='Hata.<br/>'+x.responseText;
										}
										$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});
										$this.fadeIn(500);
										$(".bekleyiniz").remove();
								}
				});	
		}else{
			$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});return false;	
		}
});

$(document).delegate("#bolum_7","change",function(){
	var v = $(this).val();
	if (v>0){
		$.blockUI({ message: "<div class='bekleyiniz' align='center'><span><img src='img/loader.gif'></span><span>İşleminiz Gerçekleştiriliyor. Lütfen Bekleyiniz...</span></div>" });
		$.post('actions/dersleriGetir_7.php',{a:v},function(data){$("#gizliBolum_7 .altSayfaFormCevapAlani").html(data);$('#gizliBolum_7').slideDown(500);$.unblockUI();});	
	}
});

//Sınav Sorularını Seç Sınav Türü Onchange
$(document).delegate("#sinavTuru_8","change",function(){
	$.blockUI({ message: "<div class='bekleyiniz' align='center'><span><img src='img/loader.gif'></span><span>İşleminiz Gerçekleştiriliyor. Lütfen Bekleyiniz...</span></div>" });
	var v = $(this).val();
	if (v>0){
		$.post('actions/sinavlariGetir_8.php',{a:v},function(data){$("#gizliBolum_8 .altSayfaFormCevapAlani").html(data);$('#gizliBolum_8').slideDown(500);$.unblockUI();});	
	}
});


//Sınav Sorularını Seç Sınav Onchange
$(document).delegate("#sinav_8","change",function(){
	var v = $(this).val();
	if (v>0){
		$.post('actions/soruTurleriniGetir_8.php',{a:v},function(data){$("#gizliBolum_8_1 .altSayfaFormCevapAlani").html(data);$('#gizliBolum_8_1').slideDown(500);});	
	}
});


//Sınav Sorularını Seç Sınav Türü Seç
$(document).delegate("#btnOnaySinavSecimi_8","click",function(){
		var msg = "";
		
		if ($("#sinavTuru_8 option:selected").val()==0) {
			msg = "Sınav türünü seçiniz.";
		}else{
			if ($("#sinav_8 option:selected").val()==0) {
				msg = "Sınavı seçiniz.";
			}else{
				if ($("#soruTuru_8 option:selected").val()==0) {
					msg = "Soru türünü seçiniz.";
				}else{
					if ($("#soruTuru_8 option:selected").val()==1) {
						if ($("#secenekSayisi option:selected").val()==0) msg = "Seçenek sayısını seçiniz.";
					}	
				}
			}
		}
		
		if (!msg){
				$("#soruListesi_8").slideDown(500).html("<div class='bekleyiniz' align='center'><span><img src='img/loader.gif'></span><span>İşleminiz Gerçekleştiriliyor. Lütfen Bekleyiniz...</span></div>");
				$.ajax({
								type	: 'POST',
								data	: $("#sinavSorusuSecimFormu_8").serialize(),
								url		: 'actions/soruSecimListesi_8.php',
								cache	: 'false',
								success	: function(a){
										$("#soruListesi_8").html(a);
										if (a.indexOf("sorularListe",0)>-1){//Seçilen türde soru varsa
											$("#sinavSorusuSecimFormu_8 *").prop("disabled",true);											
											$(".altSayfaButonAlani").parent("div").slideUp(200).remove();	
										}else{
											msg = "Sistemde seçtiğiniz türde soru bulunmamaktadır.<br/>Soru işlemleri ekranından bu türde soru eklemelisiniz.";
											$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});
										}
								},
								error	:function(x,e){
										if(x.status==0){
											msg='Bağlantı kurulamadı!<br/> İnternet bağlantınızı kontrol edin.';
										}else if(x.status==404){
											msg='İstenen URL bulunamadı.';
										}else if(x.status==500){
											msg='Sunucu hatası.';
										}else if(e=='parsererror'){
											msg='Hata.<br/>JSON isteği gerçekleştirilemedi.';
										}else if(e=='timeout'){
											msg='İstek zaman aşımı.';
										}else {
											msg='Hata.<br/>'+x.responseText;
										}
										$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});
								}
				});
		}else{
			$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});return false;
		}
});

//Soru seç - İşaretle
var toplamSecilenSoruSayisi = 0,soruID=[];
$(".secilenSoruSayisi").html(0);
$(document).delegate("#soruListesi_8 ul[val]","dblclick",function(){
	var durum = $(this).hasClass("sec"), nesne = $(this);
	if (!durum){
		nesne.addClass("sec");
		toplamSecilenSoruSayisi++;
		soruID.push(nesne.attr("val"));
	}else{
		nesne.removeClass("sec");
		toplamSecilenSoruSayisi--;
		soruID.splice(soruID.indexOf(nesne.attr("val")),1);
	}
	$(".secilenSoruSayisi").html(toplamSecilenSoruSayisi).fadeIn(500,function(){
		$(this).hide().fadeIn(1000);
	});
});

//Seçilen Soruları Gönder
$(document).delegate("#btn_test_Sorulari_Sec_8","click",function(){
	if (soruID.length>0)
	{
			soruID.sort(function(a,b){return a - b});//Soruları sırala
			msg = soruID.length + " Adet soru seçtiniz.<br/><b>Onaylıyor musunuz ?</b>";
			$.Zebra_Dialog(msg, {
				'type':     'question',
				'title':    'Dikkat',
				'buttons':  ['Evet', 'Hayır'],
				'onClose':  function(caption) {
					if (caption == 'Evet'){
							$.ajax({
								type	: 'POST',
								data	: 'a='+soruID.join("-")+"&b="+$("#sinav_8 option:selected").val(),
								url		: 'actions/sinavIcinSoruSeciminiKaydet_8.php',
								cache	: 'false',
								success	: function(a){
									$.Zebra_Dialog(a, {
										'type':     'question',
										'title':    'Dikkat',
										'buttons':  ['Tamam'],
										'onClose':  function(caption) {
											if (caption == 'Tamam'){
												$.ajax({
														type	: 'POST',
														url		: 'pages/9.php',
														data	: '',
														success	: function(a){
															$("div#icerik").html(a).hide().fadeIn(800);	
														}
												});	
											}
										}
									});
								},
								error	:function(x,e){
										if(x.status==0){
											msg='Bağlantı kurulamadı!<br/> İnternet bağlantınızı kontrol edin.';
										}else if(x.status==404){
											msg='İstenen URL bulunamadı.';
										}else if(x.status==500){
											msg='Sunucu hatası.';
										}else if(e=='parsererror'){
											msg='Hata.<br/>JSON isteği gerçekleştirilemedi.';
										}else if(e=='timeout'){
											msg='İstek zaman aşımı.';
										}else {
											msg='Hata.<br/>'+x.responseText;
										}
										$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});
								}
							});	
					}
				}
			});
	}else{
		msg = "Hiç soru seçmediniz.";
		$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});
	}
});

//Oturma Düzeni Oluştur Sınav Türü Onchange
$(document).delegate("#sinavTuru_9","change",function(){
	$.blockUI({ message: "<div class='bekleyiniz' align='center'><span><img src='img/loader.gif'></span><span>İşleminiz Gerçekleştiriliyor. Lütfen Bekleyiniz...</span></div>" });
	var v = $(this).val();
	if (v>0){
		$.post('actions/sinavlariGetir_9.php',{a:v},function(data){$("#gizliBolum_9 .altSayfaFormCevapAlani").html(data);$('#gizliBolum_9').slideDown(500);$.unblockUI();});	
	}
});

//Oturma Düzeni Oluştur Oluştur Butonu Click Olayı
$(document).delegate("#btnOnayOturmaDuzeniOlustur_9","click",function(){
	var msg = "";
	if ($("#sinavTuru_9 option:selected").val()==0){
			msg = "Sınav türünü seçiniz.";
	}else{
			var v = $("#sinav_9 option:selected").val();
			if (v>0){
				$.post('actions/oturmaDuzeniOlustur_9.php',{a:v},function(data){
					if (data.indexOf("ogrenciBilgi_9",0)>-1){
						$("#form_9 *").prop("disabled",true);											
						$(".altSayfaButonAlani").parent("div").slideUp(200).remove();
						$("#oturmaDuzeniListe_9 div:eq(1)").html(data);
						$("#oturmaDuzeniListe_9").slideDown(500);
					}else{
						$.Zebra_Dialog(data, {'type': 'error','title':'Hata'});
					}
				});	
			}else{
				msg = "Sınav seçimi yapınız.";
			}
	}
	if  (msg) {$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});return false;}
});
	
//Oturma Düzeni Oluştur Kaydet Butonu Click Olayı
$(document).delegate("#btn_Oturma_Düzeni_Kaydet_9","click",function(){	
				$(this).parent("div").before("<div class='bekleyiniz' align='center'><span><img src='img/loader.gif'></span><span>İşleminiz Gerçekleştiriliyor. Lütfen Bekleyiniz...</span></div>");
				$.ajax({
								type	: 'POST',
								data	: "a="+$("#sinav_9 option:selected").val()+"&b="+$("#od_9").val(),
								url		: 'actions/oturmaDuzenikaydet_9.php',
								cache	: 'false',
								success	: function(a){
										if ($.trim(a) == "OK"){
												msg = "Oturma düzeni kaydedildi.<br/><font color='red'>Şifre oluşturma ekranına yönlendiriliyorsunuz.</font>";
												$.Zebra_Dialog(msg, {
													'type'		:'information',
													'title'		:'Bilgi',
													'buttons'	:['Tamam'],
													'onClose'	:function(caption) {
														if (caption == 'Tamam'){
															$.ajax({
																	type	: 'POST',
																	url		: 'pages/10.php',
																	data	: '',
																	success	: function(a){
																		$("div#icerik").html(a).hide().fadeIn(500);	
																	}
															});
														}
													}
												});
										}else{
											$.Zebra_Dialog(a, {'type': 'error','title':'Hata'});
											$("div.bekleyiniz").remove();
										}
								},
								error	:function(x,e){
										if(x.status==0){
											msg='Bağlantı kurulamadı!<br/> İnternet bağlantınızı kontrol edin.';
										}else if(x.status==404){
											msg='İstenen URL bulunamadı.';
										}else if(x.status==500){
											msg='Sunucu hatası.';
										}else if(e=='parsererror'){
											msg='Hata.<br/>JSON isteği gerçekleştirilemedi.';
										}else if(e=='timeout'){
											msg='İstek zaman aşımı.';
										}else {
											msg='Hata.<br/>'+x.responseText;
										}
										$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});
								}
				});
});
	
	
//Şifre Oluştur Sınav Türü Onchange
$(document).delegate("#sinavTuru_10","change",function(){
	$.blockUI({ message: "<div class='bekleyiniz' align='center'><span><img src='img/loader.gif'></span><span>İşleminiz Gerçekleştiriliyor. Lütfen Bekleyiniz...</span></div>" });
	var v = $(this).val();
	if (v>0){
		$.post('actions/sinavlariGetir_10.php',{a:v},function(data){$("#gizliBolum_10 .altSayfaFormCevapAlani").html(data);$('#gizliBolum_10').slideDown(500);$.unblockUI();});	
	}
});	

//Şifre Oluştur Oluştur Click
$(document).delegate("#btnOnaySifreOlustur_10","click",function(){
	var msg = "";
	if ($("#sinavTuru_10 option:selected").val()==0){
			msg = "Sınav türünü seçiniz.";
	}else{
			var v = $("#sinav_10 option:selected").val();
			if (v>0){
				$.post('actions/sifreOlustur_10.php',{a:v},function(data){
					//if (data){
						$("#sifreListe_10_container").html(data);
						$("#sifreListe_10").slideDown(500);
					/*}else{
						$.Zebra_Dialog(data, {'type': 'error','title':'Hata'});
					}*/
				});	
			}else{
				msg = "Sınav seçimi yapınız.";
			}
	}
	if  (msg) {$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});return false;}
});

//Şifre Oluştur Şifreleri Kaydet Click
$(document).delegate("#btn_sifre_Kaydet_10","click",function(){
	var h1 = $("#h1_10").val(), h2 = $("#h2_10").val();	
	
	$(this).fadeOut(200).after("<div class='bekleyiniz' align='center'><span><img src='img/loader.gif'></span><span>İşleminiz Gerçekleştiriliyor. Lütfen Bekleyiniz...</span></div>");
				$.ajax({
						type	: 'POST',
						data	: "h1="+h1+"&h2="+h2,
						url		: 'actions/sifreKaydet_10.php',
						cache	: 'false',
						success	: function(a){
								if ($.trim(a) == "OK"){
										msg = "Şifreler kaydedildi.<br/><font color='red'>Şifre yazdırma ekranına yönlendiriliyorsunuz.</font>";																					
										$.ajax({
												type	: 'POST',
												url		: 'pages/10.php',
												data	: '',
												success	: function(a){
													$("div#icerik").html(a).hide().fadeIn(500);	
												}
										});
										$.Zebra_Dialog(msg, {
											'type'		:'information',
											'title'		:'Bilgi',
											'buttons'	:['Tamam'],
											'onClose'	:function(caption) {
												if (caption == 'Tamam'){
													
													var page = ($.base64.decode($.base64.decode(h2))).split('-');
													window.open('actions/sifreYazdir_10.php?sinav='+$.base64.encode($.base64.encode(page[0])),'sy');
												}
											}
										});
								}else{
									$.Zebra_Dialog(a, {'type': 'error','title':'Hata'});
									$("div.bekleyiniz").remove();
								}
						},
						error	:function(x,e){
								if(x.status==0){
									msg='Bağlantı kurulamadı!<br/> İnternet bağlantınızı kontrol edin.';
								}else if(x.status==404){
									msg='İstenen URL bulunamadı.';
								}else if(x.status==500){
									msg='Sunucu hatası.';
								}else if(e=='parsererror'){
									msg='Hata.<br/>JSON isteği gerçekleştirilemedi.';
								}else if(e=='timeout'){
									msg='İstek zaman aşımı.';
								}else {
									msg='Hata.<br/>'+x.responseText;
								}
								$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});
						}
		});
	
});

//Sınav Değerlendir
$(document).delegate("#btnOnaySinaviDegerlendir_11","click",function(){
	if ($("#sinav_11 option:selected").val()>0){
		$("#sinavDegerlendirmeListesi_11_container").html("<div class='bekleyiniz' align='center'><span><img src='img/loader.gif'></span><span>İşleminiz Gerçekleştiriliyor. Lütfen Bekleyiniz...</span></div>");
		$("#sinavDegerlendirmeListesi_11").fadeIn(100);
		$.ajax({
				type	: 'POST',
				data	: 'a='+$("#sinav_11 option:selected").val(),
				url		: 'actions/sinaviDegerlendir_11.php',
				cache	: 'false',
				success	: function(a){
					$("#sinavDegerlendirmeListesi_11_container").html(a).hide().fadeIn(500);
				},
				error	:function(x,e){
						if(x.status==0){
							msg='Bağlantı kurulamadı!<br/> İnternet bağlantınızı kontrol edin.';
						}else if(x.status==404){
							msg='İstenen URL bulunamadı.';
						}else if(x.status==500){
							msg='Sunucu hatası.';
						}else if(e=='parsererror'){
							msg='Hata.<br/>JSON isteği gerçekleştirilemedi.';
						}else if(e=='timeout'){
							msg='İstek zaman aşımı.';
						}else {
							msg='Hata.<br/>'+x.responseText;
						}
						$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});
				}
			});
	}else{
		$.Zebra_Dialog("Değerlendirilecek sınavı seçiniz.", {'type': 'error','title':'Hata'});	
		return false;
	}
});

//Değerlendirme Sonucunu Kaydet

$(document).delegate("#btn_Sinav_Degerlendirmesi_Kaydet_11","click",function(){
	var btn = $(this);
	btn.fadeOut(100).after("<div class='bekleyiniz' align='center'><span><img src='img/loader.gif'></span><span>İşleminiz Gerçekleştiriliyor. Lütfen Bekleyiniz...</span></div>");	
	$.ajax({
				type	: 'POST',
				data	: 'a='+$("#snv_11").val(),
				url		: 'actions/sinaviDegerlendirmeSonuclariniKaydet_11.php',
				cache	: 'false',
				success	: function(a){
					if ($.trim(a) == 'OK') {
						$(".bekleyeniz").remove();
						window.open('actions/sinavDegerlendirmeYazdir_11.php?sinav='+$("#snv_11").val(),'sy');	
					} else {
						$.Zebra_Dialog(a, {'type': 'error','title':'Hata'});
					}
				},
				error	:function(x,e){
						if(x.status==0){
							msg='Bağlantı kurulamadı!<br/> İnternet bağlantınızı kontrol edin.';
						}else if(x.status==404){
							msg='İstenen URL bulunamadı.';
						}else if(x.status==500){
							msg='Sunucu hatası.';
						}else if(e=='parsererror'){
							msg='Hata.<br/>JSON isteği gerçekleştirilemedi.';
						}else if(e=='timeout'){
							msg='İstek zaman aşımı.';
						}else {
							msg='Hata.<br/>'+x.responseText;
						}
						$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});
				}
			});
});


//Sınav Raporları
$(document).delegate("#btnOnaySinavRaporlari_12","click",function(){
	if ($("#sinav_12 option:selected").val()>0){
		$("#sinavRaporlari_12_container").html("<div class='bekleyiniz' align='center'><span><img src='img/loader.gif'></span><span>İşleminiz Gerçekleştiriliyor. Lütfen Bekleyiniz...</span></div>");
		$("#sinavRaporListesi_12").fadeIn(100);
		$.ajax({
				type	: 'POST',
				data	: 'a='+$("#sinav_12 option:selected").val(),
				url		: 'actions/sinavRaporlari_12.php',
				cache	: 'false',
				success	: function(a){
					$("#sinavRaporlari_12_container").html(a).hide().fadeIn(500);
				},
				error	:function(x,e){
						if(x.status==0){
							msg='Bağlantı kurulamadı!<br/> İnternet bağlantınızı kontrol edin.';
						}else if(x.status==404){
							msg='İstenen URL bulunamadı.';
						}else if(x.status==500){
							msg='Sunucu hatası.';
						}else if(e=='parsererror'){
							msg='Hata.<br/>JSON isteği gerçekleştirilemedi.';
						}else if(e=='timeout'){
							msg='İstek zaman aşımı.';
						}else {
							msg='Hata.<br/>'+x.responseText;
						}
						$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});
				}
		});
	}else{
		$.Zebra_Dialog("Raporlanacak sınavı seçiniz.", {'type': 'error','title':'Hata'});	
		return false;
	}
});

$(document).delegate("#yazdirBtn_12","click",function(){
	window.open('actions/sinavRaporlariYazdir_12.php?sinav='+$(this).attr('rel'),'sr');
});


$(document).delegate("#btnOnaySinavlarim_34","click",function(e){
	if ($("#aktifDonem_34 option:selected").val()>0){
		$.ajax({
				type	: 'POST',
				data	: 'a='+$("#aktifDonem_34 option:selected").val(),
				url		: 'actions/sinavlarim_34.php',
				cache	: 'false',
				success	: function(a){
					$("#sinavListesi_34>.altSayfaFormAlani34").html(a);
					$("#sinavListesi_34").fadeIn(500);
				},
				error	:function(x,e){
						if(x.status==0){
							msg='Bağlantı kurulamadı!<br/> İnternet bağlantınızı kontrol edin.';
						}else if(x.status==404){
							msg='İstenen URL bulunamadı.';
						}else if(x.status==500){
							msg='Sunucu hatası.';
						}else if(e=='parsererror'){
							msg='Hata.<br/>JSON isteği gerçekleştirilemedi.';
						}else if(e=='timeout'){
							msg='İstek zaman aşımı.';
						}else {
							msg='Hata.<br/>'+x.responseText;
						}
						$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});
				}
		});
	}else{
		$.Zebra_Dialog("Aktif dönemi seçiniz.", {'type': 'error','title':'Hata'});	
		return false;
	}
});








$(document).delegate("#btnOnay_35","click",function(e){
	if ($("#sinav_35 option:selected").val()>0){
		$.blockUI({ message: "<div class='bekleyiniz' align='center'><span><img src='img/loader.gif'></span><span>İşleminiz Gerçekleştiriliyor. Lütfen Bekleyiniz...</span></div>" });
		$.ajax({
				type	: 'POST',
				data	: 'a='+$("#sinav_35 option:selected").val(),
				url		: 'actions/sinavaGirmeyenleriBul_35.php',
				cache	: 'false',
				success	: function(a){
					$("#sinavListesi_35>.altSayfaFormAlani35").html(a);
					$("#sinavListesi_35").fadeIn(500);
					$.unblockUI();
				},
				error	:function(x,e){
						if(x.status==0){
							msg='Bağlantı kurulamadı!<br/> İnternet bağlantınızı kontrol edin.';
						}else if(x.status==404){
							msg='İstenen URL bulunamadı.';
						}else if(x.status==500){
							msg='Sunucu hatası.';
						}else if(e=='parsererror'){
							msg='Hata.<br/>JSON isteği gerçekleştirilemedi.';
						}else if(e=='timeout'){
							msg='İstek zaman aşımı.';
						}else {
							msg='Hata.<br/>'+x.responseText;
						}
						$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});
				}
		});
	}else{
		$.Zebra_Dialog("Sınavı seçiniz.", {'type': 'error','title':'Hata'});	
		return false;
	}
});



var sinavID = '';
$(document).delegate("#btn_yeniSifreTanimla_35","click",function(e){
	if ($("#sinavTarihi_7").val() !="" && $("#sinavSaati_7").val() !=""){
		sinavID = $("#sinav_35").val();
		$.blockUI({ message: "<div class='bekleyiniz' align='center'><span><img src='img/loader.gif'></span><span>İşleminiz Gerçekleştiriliyor. Lütfen Bekleyiniz...</span></div>" });
		$.ajax({
				type	: 'POST',
				data	: 'a='+$("#sinav_35").val()+'&b='+$("#liste_35").val()+'&c='+$("#sinavTarihi_7").val()+'&d='+$("#sinavSaati_7").val(),
				url		: 'actions/yeniSifreOlustur_35.php',
				cache	: 'false',
				success	: function(a){
					$("#sinavListesi_35>.altSayfaFormAlani35").html(a);
					$("#sinavListesi_35").fadeIn(500);
					$.unblockUI();
				},
				error	:function(x,e){
						if(x.status==0){
							msg='Bağlantı kurulamadı!<br/> İnternet bağlantınızı kontrol edin.';
						}else if(x.status==404){
							msg='İstenen URL bulunamadı.';
						}else if(x.status==500){
							msg='Sunucu hatası.';
						}else if(e=='parsererror'){
							msg='Hata.<br/>JSON isteği gerçekleştirilemedi.';
						}else if(e=='timeout'){
							msg='İstek zaman aşımı.';
						}else {
							msg='Hata.<br/>'+x.responseText;
						}
						$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});
				}
		});
	}else{
		$.Zebra_Dialog("Sınav tarihini ve saatini giriniz.", {'type': 'error','title':'Hata'});	
		return false;
	}
});




$(document).delegate("#btn_sifre_Kaydet_35","click",function(e){
		$.blockUI({ message: "<div class='bekleyiniz' align='center'><span><img src='img/loader.gif'></span><span>İşleminiz Gerçekleştiriliyor. Lütfen Bekleyiniz...</span></div>" });
		$.ajax({
				type	: 'POST',
				data	: '',
				url		: 'actions/mazeretSinavOlustur_35.php',
				cache	: 'false',
				success	: function(a){
					$("#sinavListesi_35>.altSayfaFormAlani35").html(a);
					$("#sinavListesi_35").fadeIn(500);
					$.unblockUI();
					$.Zebra_Dialog(a, {'type': 'error','title':'Bilgi'});
					if ($.trim(a)=='Sınav oluşturuldu.'){
							window.open('actions/sifreYazdir_10.php?sinav='+$.base64.encode($.base64.encode(sinavID)));
					}
				},
				error	:function(x,e){
						if(x.status==0){
							msg='Bağlantı kurulamadı!<br/> İnternet bağlantınızı kontrol edin.';
						}else if(x.status==404){
							msg='İstenen URL bulunamadı.';
						}else if(x.status==500){
							msg='Sunucu hatası.';
						}else if(e=='parsererror'){
							msg='Hata.<br/>JSON isteği gerçekleştirilemedi.';
						}else if(e=='timeout'){
							msg='İstek zaman aşımı.';
						}else {
							msg='Hata.<br/>'+x.responseText;
						}
						$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});
				}
		});
});








