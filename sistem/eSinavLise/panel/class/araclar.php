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

}

?>