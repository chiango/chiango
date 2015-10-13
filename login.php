<?php
	require_once("phpfunctions/function.php");
	$con = db_connect();
	//if the values are submitted through a form
	if( isset($_POST["submit"]) ){

		//get the values from the submission
		$email = $_POST["email"];
		$password = $_POST["password"];
		//return false if the user isn't found
		$usrexists = mysql_exists("users","email","'".$email."'","*");


		if( $usrexists === false ){
			//redirect back to home with error 1
			redirect_to( "index.php?signup=0&error=1" );
		}

		if($usrexists["activated"] == 0){
			//redirect to a page to remind user to activate their account
			redirect_to("remind_activation.php?success=0");
		}

		if( check_password($password,$usrexists["password"]) === false ){
			//password is not right redirect back to home with error 0
			redirect_to( "index.php?signup=0&error=0&user=".$email );
		}


		//up to here everything is valid and user is correctly logged in
		session_start();

		foreach($usrexists as $key => $value){$_SESSION["login"][$key] = $value;}
		//print_r($_SESSION);
		redirect_to("home.php?id=".$usrexists["id"]);

	}else{
		//values are not submitted through a form
		redirect_to("index.html");
	}
?>
