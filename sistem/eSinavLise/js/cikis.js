$(document).ready(function(e) {
	
	$("#disCerceve").hide().fadeIn(1500);
	
    $("img","#btn").hover(function(){
		$(this).attr("src","img/cikis/cikis_hover.png");
	},function(){
		$(this).attr("src","img/cikis/cikis.png");
	});
	
	$("img","#btn").click(function(){window.location='out.php';});
});