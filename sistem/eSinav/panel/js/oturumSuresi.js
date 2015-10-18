$(document).ready(function(e) {
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
