$(document).ready(function(e) {
	
	$("#cerceve").hide().fadeIn(1500);
	
	$("input:button").click(function(){
			if ($(this).attr('rel') == "eSinav") {window.location = "sistem/eSinav";} else{
				window.location = "sistem/eSinavLise";
			}
	});
});