<?php
	function redirect_to($path){
		if(isset($con)){$con->close();}
		header("Location: ".$path);
		exit;
	}

	function redirect_wait($path,$seconds){
		header('Refresh: '.$seconds.'; URL='.$path);
		//exit;
	}

	function google_search($search_query){
		return "http://www.google.com/search?q=".htmlspecialchars($search_query);
	}

	function phptojs($varible){
		return json_encode($varible);
	}
?>
