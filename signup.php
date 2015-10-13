<?php
	require_once("phpfunctions/function.php");
	$con = db_connect();

	//if the request is submitted throught a form
	if( isset($_POST["submit"]) ){

		//get all the information from the form submission
		$email = $_POST["email"];
		$password = $_POST["password"];
		$username = $_POST["username"];
		$first = $_POST["first"];
		$last = $_POST["last"];

		$url_add = "&email=".$email."&user=".$username."&f=".$first."&l=".$last;

		//check to see if any values are blank in $_POST
		//and if there are, put in array $blank_values and direct back to home
		$blank_values = array();
		foreach($_POST as $form_name => $value){
			if( c_str_empty($value) ){
				array_push($blank_values,$form_name);
			}
		}
		if( count($blank_values)>0 ){
			$count = 0;
			$return_str = "";
			foreach($blank_values as $blank_name){
				$return_str .= "&blank{$count}=".$blank_name;
				$count += 1;
			}
			$return_str .= "&count=".$count;
			redirect_to("index.php?signup=1&error=3".$url_add.$return_str);
		}


		//if password and confirm don't matchup, direct back to home
		if($password !== $_POST["confirm"]){
			redirect_to("index.php?signup=1&error=4".$url_add);
		}

		//add_login_info will return the string that will create our username in our database
		$password = hash_password($password);
		$query = add_login_info($email,$password,$username,$first,$last);

		//if username exists, direct back to home and call error 2 on signup
		$username_exists = mysql_exists("users","username","'".$username."'","email");
		if($username_exists !== false){
			redirect_to("index.php?signup=1&error=2".$url_add."&usr=".$username);
		}

		//if email address exists, direct back to home and call error 1 on signup
		if($query === false){
			redirect_to("index.php?signup=1&error=1".$url_add);
		}

		//up to here, we can assume the email and username are all unique and good
		//because redirect_to also calls exit;

		//send an activation email to the new email address
		$mail_subject = "Confirm your Chiango account!";
		$mail_alt = "Chiango, the smallest chat in the whole world";
		$html_add = "email.html";
		$account_id = substr( $query , strpos($query,"VALUES('") + strlen("VALUES('") , 30);
		$mail = send_mail($email,$mail_subject,file_get_contents($html_add),$mail_alt,$account_id);

		//if the email was successfully sent and the user didn't just enter jibberish
		//add the whole thing to our database
		if($mail === true){
			$result = db_perform($con,$query);

			//redirect user to another page to remind them to check their email
			redirect_to("remind_activation.php?success=1");
		}
		else{//if the user entered a incorrect email address

			//direct user back to home with error 0 on signup
			redirect_to("index.php?signup=1&error=0".$url_add);
		}
	}else{//request was from a browser and not from a form
		redirect_to("index.php");
	}
?>
