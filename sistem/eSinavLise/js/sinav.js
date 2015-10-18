$(document).ready(function(e) {
	var cevaplar = [];
	var bilgilendirme = 0;
	
	
	//Seçim İptal
	(function($){
		$.fn.disableSelection = function() {
			return this
					 .attr('unselectable', 'on')
					 .css('user-select', 'none')
					 .on('selectstart', false);
		};
	})(jQuery);
	$("*").disableSelection();
	$("*").bind('contextmenu', function(e){return false;}); 
	function disableF5(e) { if (e.which>= 112 && e.which<=123 ) e.preventDefault(); };
	$(document).bind("keydown", disableF5);

	//Cevaplar Varsa Yükle
	if ($("#pastAnswers").val()){
		var t = $.base64.decode($("#pastAnswers").val());
		var y = t.split('-');
		var d = "abcde";
		$.each(y,function(index,value){
				if (value != 'X'){
					var konum = d.indexOf(value.toLowerCase());
					$("#cevapAlani>.secenekTutucu>.satir:eq("+index+")>.sec:eq("+konum+")>img").attr("src","img/"+d[konum]+"_hover.png");	
					$("#cevapAlani>.secenekTutucu>.satir:eq("+index+")").addClass("isaretli");
					cevaplar[index+1] = d[konum].toUpperCase();
				}else{
					cevaplar[index+1] = 'X';
				}
		});
		
	}
	
	if (bilgilendirme == 0){
		$.Zebra_Dialog("Soruları çözerken sayfayı yenilemeyiniz. İlerlemek için soru numaralarını kullanınız. Aksi takdirde sistem sizi dışarı atacaktır.", {'type': 'information','title':'Bilgi'});
		bilgilendirme++;
	}

	$("#disCerceve").hide().fadeIn(1500);
	$("#cevapAlani").niceScroll();
		$(function() {
			var now = new Date();
		  $('#sinavSuresi').countdown(new Date(now.getTime() + $.base64.decode($("#examTime").val())*60000), function(event) {
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
				alert("Süreniz doldu");
				window.location = "cikis";
				break;
			}
		  });
		}); 
	
	var deger = $.base64.decode($("#sessionInfo").val());
	var dizi  = deger.split("-");	
	var int	  = self.setInterval(function(){postala()},30000);
	function postala(){	$.post('sureIsle.php',{a:(parseInt($("span#minutes").text(),10)+60*parseInt($("span#hours").text(),10)),b:dizi[0],c:dizi[1]});}
	
	
	//Önceki - Sonraki Soru ve Soru Numaraları
	
	$(document).delegate("input:button,.numara>a","click",function(){
		var istenen = $(this).attr("rel");
		var beklet  = "<div class='bekleyiniz' align='center'><span><img src='img/loader.gif'></span><span>Soru yükleniyor. Lütfen Bekleyiniz...</span></div>";
		$("#soruAlani").html(beklet);
		$.ajax({
				type	: 'POST',
				data	: 'soruID='+istenen+"&pID="+$("#pencereID").val(),
				url		: 'soruGetir.php',
				cache	: 'false',
				success	: function(a){
							$("#soruAlani").html(a);
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
		$("#cevapAlani").scrollTop((istenen * 10));
	});
	
	
	
	//Cevap Alanı
	$(document).delegate(".satir>.sec>img","mouseenter mouseleave",function(e){
		if ($(this).parents("div.satir").css('opacity') == 1){
			var resim = $(this).attr("src").split('/');
			var harf  = resim[1].substr(0,1);
			
			if ($(this).parents("div.satir").hasClass('isaretli')==false){
				if (e.type == 'mouseenter'){			
					$(this).attr("src","img/"+harf+"_hover.png");
				}else{
					$(this).attr("src","img/"+harf+".png");
				}
			}
		}
	});
	
	
	
	$(document).delegate(".satir>.sec>img","click",function(e){
		var resim = $(this).attr("src").split('/');
		var harf  = resim[1].substr(0,1);
		var kutu  = $(this).parents("div.satir");
		var dizi  = ['a','b','c','d','e'];
		var satirNo = $(this).parents("div.satir").index()+1;
		if (kutu.css('opacity') == 1){
			
			if (kutu.hasClass('isaretli'))
			{
				$("img",kutu).each(function(i, e) {
					 $(e).attr("src","img/"+dizi[i]+".png");
				});
			}
			$(this).attr("src","img/"+harf+"_hover.png");
			$(this).parents("div.satir").addClass('isaretli');
			
			cevaplar[satirNo] = harf.toUpperCase();			
			
		}
	});
	
	var calistir = self.setInterval(function(){cevapAlaniKontrol()},500);
	function cevapAlaniKontrol(){
		var soruNo = $.trim($(".soruNo").text()).split(' ');
	
		if (soruNo[1])
			for(i=0;i<=$(".satir").size()-1;i++){
				if (i!=(soruNo[1]-1)){
					$(".secenekTutucu>.satir:eq("+i+")").css({'opacity':'0.3','border':'none'});
				}else{
					$(".secenekTutucu>.satir:eq("+i+")").css({'opacity':'1','border':'1px solid red'});					
				}
				if ($(".secenekTutucu>.satir:eq("+i+")").css('opacity')<1){
					$(".secenekTutucu>.satir:eq("+i+")").attr('disabled','disabled');
				}else{
					$(".secenekTutucu>.satir:eq("+i+")").removeAttr('disabled');
				}
			}
		}
	
	var kb="";//Kayıt bilgisi{Cevaplar}
	//Cevapları Kaydet Butonu
	$(document).delegate("#s8>img","click",function(){
		kb="";
		for(i=1;i<=$(".satir").size();i++)
		{
			if (cevaplar[i]) yaz = cevaplar[i]; else yaz = 'X';
			kb +=yaz + "-";
		}
		kb = kb.substring(0,kb.length-1);
		
		$.post('cevaplarimiKaydet.php',{a:dizi[0],b:dizi[1],c:kb},function(cevap){$.Zebra_Dialog(cevap, {'type': 'information','title':'Bilgi'});});
	});
	
	//Otomatik cevap kaydet
	var saver  = self.setInterval(function(){autoAnswerSave()},60000);
	function autoAnswerSave(){kb="";for(i=1;i<=$(".satir").size();i++){if (cevaplar[i]) yaz = cevaplar[i]; else yaz = 'X';kb +=yaz + "-";}kb = kb.substring(0,kb.length-1);$.post('cevaplarimiKaydet.php',{a:dizi[0],b:dizi[1],c:kb});}
	
	//Bitir Butonu
	$(document).delegate("#s10>img","click",function(){
		kb="";
		for(i=1;i<=$(".satir").size();i++)
		{
			if (cevaplar[i]) yaz = cevaplar[i]; else yaz = 'X';
			kb +=yaz + "-";
		}
		kb = kb.substring(0,kb.length-1);
		
		if (kb.indexOf('X')>-1){
			$.Zebra_Dialog("Boş bıraktığınız sorular var.<br/>Sınavı bitirmek istediğinizden emin misiniz?", {
				'type'		:'question',
				'title'		:'Dikkat',
				'buttons'	:['Evet','Hayır'],
				'onClose'	:function(caption) {
					if (caption == 'Evet'){
						$.ajax({
								type	: 'POST',
								data	: 'a='+dizi[0]+"&b="+dizi[1]+"&c="+kb,
								url		: 'cevaplarimiKaydet.php',
								cache	: 'false',
								success	: function(a){
										$.Zebra_Dialog(a, {
											'type'		:'information',
											'title'		:'Dikkat',
											'buttons'	:['Tamam'],
											'onClose'	:function(caption) {
												if (caption == 'Tamam'){
													$.ajax({
															type	: 'POST',
															data	: 'a='+dizi[0]+"&b="+dizi[1],
															url		: 'sinaviBitir.php',
															cache	: 'false',
															success	: function(a){
																	  if ($.trim(a) == 'OK'){ window.location = 'cikis';}
															}
													});
												}
											}
										});
								}
						});
						
					}//Evet ise
				}
			});
		}else{
			$.Zebra_Dialog("Sınavı bitirmek istediğinizden emin misiniz?", {
				'type'		:'question',
				'title'		:'Dikkat',
				'buttons'	:['Evet','Hayır'],
				'onClose'	:function(caption) {
					if (caption == 'Evet'){
						$.ajax({
								type	: 'POST',
								data	: 'a='+dizi[0]+"&b="+dizi[1]+"&c="+kb,
								url		: 'cevaplarimiKaydet.php',
								cache	: 'false',
								success	: function(a){
										$.Zebra_Dialog(a, {
											'type'		:'information',
											'title'		:'Dikkat',
											'buttons'	:['Tamam'],
											'onClose'	:function(caption) {
												if (caption == 'Tamam'){
													$.ajax({
															type	: 'POST',
															data	: 'a='+dizi[0]+"&b="+dizi[1],
															url		: 'sinaviBitir.php',
															cache	: 'false',
															success	: function(a){
																	 if ($.trim(a) == 'OK'){ window.location = 'cikis';}
															}
													});
												}
											}
										});
								}
						});
						
					}//Evet ise
				}
			});
		}
	});
});