// Kullanıcı işlemleri menüsü ve alt menülerine ait kodlar

//Kullanıcı Tanımla Form Kontrolü
$(document).delegate("#btnOnayKullaniciEkle","click",function(){
	var formNesneleri = $("select,.altSayfaFormAlani input");
	var msg = "",s1="",s2="";
	formNesneleri.each(function(index, element) {
        if (index == 0) {if (element.value == 0) {msg+="Ünvan seçiniz.<br/>";return false;}}
		if (index == 1) {
				if ($.trim(element.value).length < 3) {msg+="Adınızı giriniz.<br/>";return false;}
				if (!/^[A-Za-zçÇöÖşŞıİğĞüÜ ]{2,25}$/.test(element.value)){msg+="Geçerli bir ad giriniz.";return false;}
		}
		if (index == 2) {
				if ($.trim(element.value).length < 2) {msg+="Soyadınızı giriniz.<br/>";return false;}
				if (!/^[A-Za-zçÇöÖşŞıİğĞüÜ ]{2,25}$/.test(element.value)){msg+="Geçerli bir soyad giriniz.";return false;}
		}
		if (index == 3) {
				if ($.trim(element.value).length < 5) {msg+="Kullanıcı adı en az 5, en çok 20 karakter olmalıdır.<br/>";return false;}
				if (!/^[A-Za-z0-9_]{5,20}$/.test(element.value)) {msg+="Geçerli bir kullanıcı adı giriniz.<br/>Kullanıcı adı rakam veya alt çizgi(_) karakteri içerebilir. Boşluk içeremez. Kullanıcı adı en az 5, en çok 20 karakter olmalıdır.";return false;}
		}
		if (index == 4) {if ($.trim(element.value).length < 6) {msg+="Şifre en az 6 karakter olmalıdır.<br/>";return false;}s1=element.value;}
		if (index == 5) {s2=element.value;}
    });
	if (s1!=s2) {msg+="Şifreler uyuşmuyor.<br/>";}
	if (msg.length>0) {
			$.Zebra_Dialog(msg, {'type':'warning','title':'Dikkat'});
	}
	else{
		msg="";
		$.ajax({
			type	: 'POST',
			data	: $("#kullaniciTanimlaForm").serialize(),
			url		: 'actions/kullaniciKaydet.php',
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
	}
});

//-----------------------------------------------------------------------

//Kullanıcı Yetkilendirme
var liste="",durum="",secim="";
$(document).delegate(".sutun>ul>li>input:checkbox","click",function(){
	durum = $(this).is(':checked');
	liste = $(this).parents("ul").find("ul input:checkbox");
	liste.prop("checked",durum);
});

$(document).delegate(".sutun>ul>li>ul>li>input:checkbox","click",function(){
	durum = $(this).is(':checked');
	if (durum){
		p = $(this).parents("div.sutun").find("ul li input:checkbox:first");
		p.prop("checked",durum);
	}
});

//Profil Ayarlama
$(document).delegate("#profil","change",function(){
	secim = $(this).val();
	if (secim == 1){
		var p1=$("#mn_1").parents("ul"),p2=$("#mn_6").parents("ul");
		$(".liste input:checkbox").prop("checked",false);	
		$("input:checkbox",p1).prop("checked",true);
		$("input:checkbox",p2).prop("checked",true);
	}
	if (secim == 2){
		$(".liste input:checkbox").prop("checked",true);	
	}
	if (secim == 3){
		$(".liste input:checkbox").prop("checked",false);	
	}
});


$(document).delegate("#btnOnayKullaniciYetkilendirme","click",function(){
	if ($("#kKullanici").val()>0)
	{
		var secim = $("input:checkbox:checked","div.liste");
		var liste = "";
		var msg="";
		var cvp="";
		
		secim.each(function(index, element) {
			liste+=element.id.split('_')[1]+"-";
		});

		if (liste.length>0){
					$.ajax({
						type	: 'POST',
						data	: 'kKullanici='+$("#kKullanici").val()+'&liste='+liste,
						url		: 'actions/kullaniciYetkilendirme.php',
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
		 }
		 else
		 {
			msg = "Seçilen kullanıcının bütün yetkilerini iptal ediyorsunuz.<br/><b>Emin misiniz ?</b>";
			$.Zebra_Dialog(msg, {
				'type':     'question',
				'title':    'Dikkat',
				'buttons':  ['Evet', 'Hayır'],
				'onClose':  function(caption) {
					if (caption == 'Evet'){
							$.ajax({
								type	: 'POST',
								data	: 'kKullanici='+$("#kKullanici").val()+'&liste='+liste,
								url		: 'actions/kullaniciYetkilendirme.php',
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
					}
				}
			});
		 }
	}else{
		msg = "Kullanıcı seçiniz.";
		$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});
	}
});

//Yetkileri yükle
$(document).delegate("select#kKullanici","change",function(){
	var k = $(this).val();
	$.ajax({
			type	: 'POST',
			data	: 'kKullanici='+$("#kKullanici").val(),
			url		: 'actions/yetkileriYukle.php',
			cache	: 'false',
			success	: function(a){
						if ($.trim(a)!=null){
							$(".sutun input:checkbox").prop('checked',false);
							var y = a.split('-');
							for(i=0;i<y.length;i++){
								$("#mn_"+y[i]).prop('checked',true);	
							}
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

//-----------------------------------------------------------------------