<?php 
	function generate_random($length){
		return bin2hex( openssl_random_pseudo_bytes($length/2) ) ;
	}
	
	function video_random($length){
		return substr(str_replace("+",".",base64_encode(md5(uniqid(mt_rand(),true)))),0,$length);
	}
?>

