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

	public function htmlDonusum($text){
		$e = array(	" " => "&#32;",				
					"!" => "&#33;",				
					'"' => "&#34;",				
					"#" => "&#35;",				
					"$" => "&#36;",				
					"%" => "&#37;",				
					"&" => "&#38;",				
					"'" => "&#39;",				
					"(" => "&#40;",				
					")" => "&#41;",
					"*" => "&#42;",
					"+" => "&#43;",
					"," => "&#44;",
					"-" => "&#45;",
					"." => "&#46;",
					"/" => "&#47;",
					":" => "&#58;",
					";" => "&#59;",
					"<" => "&#60;",
					"=" => "&#61;",
					">" => "&#62;",
					"?" => "&#63;",
					"@" => "&#64;",
					"[" => "&#91;",
					"\\" => "&#92;",
					"]" => "&#93;",
					"^" => "&#94;",
					"_" => "&#95;",
					"`" => "&#96;",
					"{" => "&#123;",
					"|" => "&#124;",
					"}" => "&#125;",
					"~" => "&#126;"
			);
		$return = null;
		for($i=0;$i<strlen($text);$i++){
			if (isset($e[substr($text,$i,1)])) $return .=$e[substr($text,$i,1)]; else $return .= substr($text,$i,1);
		}
		return $return;
	}
}

?>