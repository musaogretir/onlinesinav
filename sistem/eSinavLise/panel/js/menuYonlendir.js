$(document).ready(function(e) {
	var s;
	$("a","#menu").bind("click",function(e){
		s = $(this).attr("val");
		
		if (s!=1  && s!=6  && s!=13  && s!=16  && s!=22 && s!=100)
		{
			$("div#icerik").html("<div class='yukleniyor' align='center'><span><img src='img/loader.gif'></span><span>Y ü k l e n i y o r . . .</span></div>");
			
			//Soru İşlemleri 		: 1-2-3-4-5
			//Sınav İşlemleri 		: 6-7-8-9-10-11-12
			//Kullanıcı İşlemleri 	: 13-14-15
			
			//Kullanıcının yetkilerini tespit et.
			var hidden	= $("input:hidden").val();
			var charges	= $.base64.decode($.base64.decode(hidden)).split('-');
			
			if ($.inArray(s,charges)>-1)
			{
				$.ajax({
						type	: 'POST',
						url		: 'pages/'+s+'.php',
						data	: '',
						success	: function(a){
							$("div#icerik").html(a);	
						}
				});
			} else {
				$.Zebra_Dialog("Bu sayfaya erişim yetkiniz bulunmamaktadır", {'type': 'error','title':'Hata'});
				return false;
			}
			//Oturum süresini sunucu tarafında da resetle
			$.ajax({
					type	: 'POST',
					url		: 'headerMain.php',
					data	: '',
					success	: function(){	
					}
			});
		}
	});
	
	$(document).delegate("a,input:button,input:submit","click",function(){
			//Oturum süresini resetle
			$(function() {
				  var now = new Date();
				  $('#oturumSuresi').countdown(new Date(now.getTime() + 30*60000+1000), function(event) {
					var $this = $(this);
					switch(event.type) {
					  case "seconds":
					  case "minutes":
					  case "hours":
					  case "days":
					  case "weeks":
					  case "daysLeft":
						$this.find('span#'+event.type).html(event.value);
						break;
					  case "finished":
						alert("30 dakika boyunca işlem yapmadığınız için süreniz doldu.\nYeniden giriş yapınız.");
						window.location = "cikis.php";
						break;
					}
				  });
			}); 	
	});
});