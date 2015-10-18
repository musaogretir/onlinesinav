$(document).ready(function(e) {
    function getIEVersion() {
			var rv = -1; // Return value assumes failure.
			if (navigator.appName == 'Microsoft Internet Explorer') {
				var ua = navigator.userAgent;
				var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
				if (re.test(ua) != null)
					rv = parseFloat( RegExp.$1 );
			}
			return rv;
	}
	
	if (getIEVersion()<0)
	{
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
						window.location.href = 'yonetimAnasayfa.php';	
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
	}
	else{
		msg = "Sistemi kullanabilmek için CHROME tarayacısı ile giriş yapınız.";
		$.Zebra_Dialog(msg, {'type': 'error','title':'Hata'});
	}
	//Güvenlik Kodu Yenile
	$("#code img").click(function(){$(this).attr("src","class/captcha/captcha.php?"+Math.random());});
});