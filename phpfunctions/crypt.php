<?php 
	function hash_password($password){
		$salt = "$2y$10$";
		$salt .= video_random(22);
		
		return crypt($password,$salt);
	}
	
	function check_password($input,$existed){
		$input_crypted = crypt($input,$existed);
		
		if($input_crypted === $existed){return true;}else{return false;}
	}
?>