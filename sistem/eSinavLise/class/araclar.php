<?php

class araclar{
	
	protected $_commands = array(	'HTTP_CLIENT_IP',
									'HTTP_X_FORWARDED_FOR',
									'HTTP_X_FORWARDED',
									'HTTP_X_CLUSTER_CLIENT_IP',
									'HTTP_FORWARDED_FOR',
									'HTTP_FORWARDED',
									'REMOTE_ADDR'
								);
	
	
	public function __construct() {
	
	}
	
	public function get_real_ip()
	{
		 $UsesProxy = (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) || !empty($_SERVER['HTTP_CLIENT_IP'])) ? true : false;
		  if ($UsesProxy && !empty($_SERVER['HTTP_CLIENT_IP'])) {
			$UserIP = $_SERVER['HTTP_CLIENT_IP'];
		  }
		  elseif ($UsesProxy && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$UserIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
			if (strstr($UserIP, ',')) {
			  $UserIPArray = explode(',', $UserIP);
			  foreach ($UserIPArray as $IPtoCheck) {
				if (!$this->IPCheck_RFC1918($IPtoCheck)) {
				  $UserIP = $IPtoCheck;
				  break;
				}
			  }
			  if ($UserIP == $_SERVER['HTTP_X_FORWARDED_FOR']) {
				$UserIP = $_SERVER['REMOTE_ADDR'];
			  }
			}
		  }
		  else{
			$UserIP = $_SERVER['REMOTE_ADDR'];
		  }
		  return $UserIP;
	}

	public function strtoupper_tr($s)
	{
	 $tmp = str_replace(
	 array("a","b","c","ç","d","e","f","g","ğ","h","ı",
	"i","j","k","l","m","n","o","ö","p","r","s","ş","t",
	"u","ü","v","y","z","q","w","x"),
	 array("A","B","C","Ç","D","E","F","G","Ğ","H","I",
	"İ","J","K","L","M","N","O","Ö","P","R","S","Ş","T",
	"U","Ü","V","Y","Z","Q","W","X"),
	 $s
	 );
	 return $tmp;
	}
	
	public function strtolower_tr($s)
	{
	 $tmp = str_replace(
	 array("A","B","C","Ç","D","E","F","G","Ğ","H","I",
	"İ","J","K","L","M","N","O","Ö","P","R","S","Ş","T",
	"U","Ü","V","Y","Z","Q","W","X"),
	 array("a","b","c","ç","d","e","f","g","ğ","h","ı",
	"i","j","k","l","m","n","o","ö","p","r","s","ş","t",
	"u","ü","v","y","z","q","w","x"),
	 $s
	 );
	 return $tmp;
	}
	 
	public function ucfirst_tr($s)
	{
	 return $this->strtoupper_tr(substr($s,0,1)) . $this->strtolower_tr(substr($s,1));
	}
}

?>