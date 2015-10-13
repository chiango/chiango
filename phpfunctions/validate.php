<?php 
	function show_error($errors,$class){
		echo "Your submission had these errors:\n";
		$result = "";
		if( !empty($errors) ){
		$result .= "<div class=".$class.">";
			$result .= "<ul>";
			foreach ($errors as $thing){
				$result .= "<li>{$thing}</li>";
			}
			$result .= "</ul>";
		$result .= "</div>";
		}
		return $result;
	}
	
	function c_maxstr_len($string,$max){
		return strlen($string) < $max;
	}
	
	function c_str_empty($string){
		$string = trim($string);
		return $string === "";
	}
	
	function string_validation($string_array){
		global $error;
		global $count;
		foreach ($string_array as $convert => $max){
			$string = $_POST[$convert];
			if( !c_maxstr_len($string,$max) ){
				$error[$count] = ucfirst($convert)." is too long.";
				$count+=1;
			}
			if( c_str_empty($string) ){
				$error[$count] = ucfirst($convert)." can't be empty.";
				$count+=1;
			}
		}
	}
	
	function isset_empty($string){
		if(isset($_GET[$string])){return $_GET[$string];}
		else{return "";}
	}
?>