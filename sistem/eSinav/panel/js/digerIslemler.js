//Öğretim Yılı Aktif Yap
$(document).delegate("#btnOnayOgretimYiliAktifYap","click", function(){
	$.ajax({
						type	: 'POST',
						data	: 'a='+$("#mevcutOgretimYiliListesi").val(),
						url		: 'actions/ogretimYiliAktifYap.php',
						cache	: 'false',
						success	: function(a){
							$.Zebra_Dialog(a, {'type': 'confirmation','title':'Bilgi'});
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

//Sınıf Listesi Yükle
$(document).delegate("#btnOnaySinifSec","click", function(){
	var msg = "";
	
	if ($("#bolum_30 option:selected").val()==0) {
		msg = "Bölüm seçiniz.";
	}
	if (!msg){
		if ($("#seviye_30 option:selected").val()==0) {
			msg = "Sınıf seviyesini seçiniz.";
		}	
	}
	if (!msg){
		if ($("#ogretimTuru_30 option:selected").val()==0) {
			msg = "Öğretim türünü seçiniz.";
		}	
	}
	
	if (msg) {
		$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});return false;
	}else{
		var content = "<input type='hidden' id='bilgi_30' name='bilgi_30' value='"+$("#bolum_30 option:selected").val()+"-"+$("#seviye_30 option:selected").val()+"-"+$("#ogretimTuru_30 option:selected").val()+"'/>";
		$("#bilgi_30").remove();
		$("#ogrenciListesiYukleForm").append(content);
		$("#gizliBolum_30").slideDown("slow");
	}
});


//Excel dosyası yükleme [Sınıf Listesi]
	$(document).delegate("#btnOnaySinifYukle","click",function(e) {
        
		 var ext = $('#ogrenciListesiYukle_30').val().split('.').pop().toLowerCase();
		 if($.inArray(ext, ['xls','xlsx']) == -1) {
			$.Zebra_Dialog("Hatalı dosya türü!<br/>Yalnızca EXCEL dosyaları yükleyebilirsiniz.", {'type': 'error','title':'Hata'});return false;
		 }
		 
		 var bar = $('.bar');
		 var percent = $('.percent');
		 var status = $('#status');


		 $('form#ogrenciListesiYukleForm').submit(function(){
				$('form#ogrenciListesiYukleForm').ajaxForm({
						delegation: true,
						beforeSend: function() {
							status.empty();
							var percentVal = '0%';
							bar.width(percentVal)
							percent.html(percentVal);
						},
						uploadProgress: function(event, position, total, percentComplete) {
							var percentVal = percentComplete + '%';
							bar.width(percentVal)
							percent.html(percentVal);
						},
						complete: function(xhr) {
							$("#altSayfaFormAlani_30").append(xhr.responseText);
							$("#altSayfaButonAlani_30").remove();
							return false;
						}
				});
		 });
    });
//Listeyi kaydet butonu
$(document).delegate("#btn_ogrenciListesiKaydet_30","click",function(){
	var $this = $(this);
	$this.fadeOut(500).after("<div class='bekleyiniz' align='center'><span><img src='img/loader.gif'></span><span>İşleminiz Gerçekleştiriliyor. Lütfen Bekleyiniz...</span></div>");
	$.ajax({
						type	: 'POST',
						data	: 'bilgi_30='+$("#bilgi_30").val(),
						url		: 'actions/sinifListesiKaydet.php',
						cache	: 'false',
						success	: function(a){
							$.Zebra_Dialog(a, {
										'type':     'information',
										'title':    'Bilgi',
										'buttons':  ['Tamam'],
										'onClose':  function(caption) {
											if (caption == 'Tamam'){
												$.ajax({
														type	: 'POST',
														url		: 'pages/30.php',
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
								$this.fadeIn(500);
								$(".bekleyiniz").remove();
						}
	});	

});

//Mevcut Sınıf Listeleri

$(document).delegate(".listeBolumBaslik_33","click",function(){
	var $this = $(this);
		if ($this.next(".listeBolumIcerik_33").hasClass('open') == false){
			$(".listeBolumIcerik_33").removeClass('open').slideUp(250);
			$this.next(".listeBolumIcerik_33").slideDown(500).addClass('open');			
		}
});


//Ders Ekle

var ekle_31 = '<div id="ekle_31" class="altSayfaFormAlaniBilgiSatiri"><div class="altSayfaFormSoruAlani">Ders Adı : </div><div class="altSayfaFormCevapAlani"><input type="text" name="dersAdi_31" id="dersAdi_31"/></div><div class="altSayfaFormAciklamaAlani">Dersin adını giriniz.</div></div>';

var eklendi = 0;
$(document).delegate("#bolum_31","change",function(){
	
	if ($(this).val()>0 && !eklendi){
		$(this).parent("div").parent("div").after(ekle_31);
		$("#ekle_31").hide().slideDown(800);
		eklendi = 1;
	}
	if ($(this).val()==0)
	{
		$("#ekle_31").slideUp(800,function(){$(this).remove()});	
		eklendi = 0;
	}
});

$(document).delegate("#btnOnayDersKaydet_31","click",function(){
	msg = "";
	if ($("#bolum_31").val()>0){
		if ($.trim($("#dersAdi_31").val()).length>0){
				$.ajax({
						type	: 'POST',
						data	: 'a='+$("#bolum_31").val()+"&b="+$.trim($("#dersAdi_31").val()),
						url		: 'actions/dersAdiKaydet.php',
						cache	: 'false',
						success	: function(a){
							$.Zebra_Dialog(a, {'type': 'confirmation','title':'Bilgi'});
							if ($.trim(a)=="Ders eklendi."){
									$.ajax({
											type	: 'POST',
											url		: 'pages/31.php',
											data	: '',
											success	: function(a){
														$("div#icerik").html(a).hide().fadeIn(800);	
											}
									});
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
			msg = "Dersin adını giriniz.";	
		}
	}else{
		msg = "Bölümü seçiniz.";	
	}
	if (msg) $.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});
});



