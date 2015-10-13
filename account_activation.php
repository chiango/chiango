<?php
	require_once("phpfunctions/function.php");

	$direct = "http://chiango.no-ip.org";

	//if it is from a email link clicked
	if(isset($_GET["account_id"])){
		$result = mysql_property_exists("users","id","'".$_GET["account_id"]."'","activated");

		if($result === false){  //property doesn't exist
			$message = "This account doesn't exist or the URL expired. We will redirect you in 5 seconds.";
			redirect_wait($direct,5);
		}else{
			if($result["activated"] === "1"){  //account_ already activated
				$message = "This account is already activated. We will redirect you in 5 seconds.";
				redirect_wait($direct,5);
			}else{  //here is the sweet spot where user exists and isn't activated yet'
				$sql = "UPDATE users SET activated=1 WHERE id='".$_GET["account_id"]."';";
				$con = db_connect();
				db_perform($con,$sql);
				$message = "Account activated. Link will expire. We will redirect you in 5 seconds.";
				redirect_wait($direct,5);
			}
		}
	}else{redirect_to($direct);}
?>

<!DOCTYPE html>
<html>
	<body>
		<h1><?php echo $message; ?></h1>
	</body>
</html>
