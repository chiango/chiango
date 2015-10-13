<?php 
	if(isset($_GET["success"])){
		if($_GET["success"]=="1"){
			$message = "<h1 style='text-align:center;'>You Have successfully created your account!</h1>";
			$message .= "<p>Now all that is left for you to do is confirm your email address.</p>";
			
		}else{
			$message = "<h1 style='text-align:center'>You Are seeing this page because you haven't activated your account yet</h1>";
			$message .= "<p>In order to do that, you will need to check your email and find the activation link chiangochen@gmail.com sent you.</p>";
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Chiango: Activate Your Account!</title>
	</head>
	<body>
		<?php echo $message?>
	</body>
</html>