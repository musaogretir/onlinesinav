$(document).ready(function(e) {
	
	$("#cerceve").hide().fadeIn(1500);
	
	$(document).delegate("div#code img","click",function(){
		$("div#code img").attr("src","class/captcha/captcha.php?"+Math.random());	
	});
	
	
	$("*").bind('contextmenu', function(e){return false;}); 
	
	try {
		$("body select").msDropDown();
		} catch(e) {
		alert(e.message);
	}
	
	$(document).delegate("#ogrNo","keydown",function(e){
		$(this).numeric({ negative : false , decimal : false});
	});
	
	$("#s").click(function(){
			$.ajax({
				type	: 'POST',
				data	: $("#loginForm").serialize(),
				url		: 'girisKontrol.php',
				cache	: 'false',
				success	: function(a){
					if ($.trim(a)!='OK') {
						$.Zebra_Dialog(a, {'type': 'error','title':'Hata'});
						$("div#code img").attr("src","class/captcha/captcha.php?"+Math.random());
					}else{
						window.location.href = 'sinav';	
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
});