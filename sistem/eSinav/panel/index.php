<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>E-Sınav Yönetim Paneli</title>
<link href="css/index.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/zebra_dialog.css" rel="stylesheet" type="text/css" media="all" />

<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/zebra_dialog.js"></script>
<script type="text/javascript" src="js/index.js"></script>
</head>

<body>

<div id="cerceve">
	<form id="loginForm">
		<div id="baslik">Yönetim Paneli Giriş Ekranı</div>
		<div class="satir">	
				<div class="soru">Kullanıcı Adı :</div>
                <div class="cevap"><input type="text" name="u" id="u" /></div>
		</div>
        <div class="satir">	
				<div class="soru">Şifre :</div>
                <div class="cevap"><input type="password" name="p" id="p" /></div>
		</div>
        <div id="code">	
				<img src="class/captcha/captcha.php" width="200" height="70" />
		</div>
        <div class="satir">	
				<div class="soru">Güvenlik Kodu :</div>
                <div class="cevap"><input type="text" name="c" id="c" /></div>
		</div>
        <div class="btn">	
				<input type="button" id="s" name="s" value="Giriş Yap" />
		</div>
    </form>    
</div>

</body>
</html>