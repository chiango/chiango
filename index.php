<?php
	require_once("phpfunctions/function.php");

	//if user already logged in, log user in
	session_start();
	if( isset($_SESSION["login"]) ){redirect_to("home.php?id=".$_SESSION["login"]["id"]);}

	//setup the default values in case of error
	$error_login = ""; $email_login = "";
	$email_signup = ""; $first_signup = "";
	$last_signup = ""; $user_signup = "";
	$error_signup = "";

	$blank_array = array();

	//if error exists
	if( isset($_GET["signup"]) ) {
		if( $_GET["signup"] === '0' ){  //this refers to the login box

			switch(isset_empty("error")){
				case "0": $error_login = "*Password is incorrect";break;
				case "1": $error_login = "*User doesn't exist";break;
			}
			//fill the value of login box
			$email_login = isset_empty("user");

		}else{  //this refers to the signup box

			switch(isset_empty("error")){
				case "0": $error_signup = "*Your email address ".isset_empty("email")." isn't right. Please double check.";break;
				case "1": $error_signup = "*User exists already.<a href=\"\">Forgot Password?</a>";break;
				case "2": $error_signup = "*Username ".isset_empty("usr")." is already taken, please chose another one.";break;
				case "3":
					$error_signup = "*Values can't be blank.";
					for( $i = 0; $i < intval( $_GET["count"] ); $i++ ){
						array_push($blank_array,$_GET["blank{$i}"]);
					}break;

				case "4": $error_signup = "*The two passwords you entered aren't the same.";break;
			}

			//fill the value of the signup box
			$email_signup = isset_empty("email");
			$user_signup = isset_empty("user");
			$first_signup = isset_empty("f");
			$last_signup = isset_empty("l");
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Hello Chiango User!</title>
		<link rel="stylesheet" type="text/css" href="jscss/index.css"/>
		<script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
		<script>
			$(document).ready(function(){
				var $number = 250;
				var $ini_height = "20%";
				var $add_height = "80%";
				var $signup = "<?php echo isset_empty("signup");?>";

				if($signup == "1"){
					$('#signup').show($number);
					$('.signup').animate({height:$add_height},$number);
					$('#login').hide();
				}else if($signup == "0"){
					$('#login').show($number);
					$('.login').animate({height:$add_height},$number);
					$('#signup').hide();
				}else{
					$('#login').hide();
					$('#signup').hide();
				}

				$('.login').mouseenter(function(){
					$('#login').show($number);
					$(this).animate({height:$add_height},$number);
				});
				$('.login').mouseleave(function(){
					$('#login').hide($number);
					$(this).animate({height:$ini_height},$number);
				});
				$('.signup').mouseenter(function(){
					$('#signup').show($number);
					$(this).animate({height:$add_height},$number);
				});
				$('.signup').mouseleave(function(){
					$('#signup').hide($number);
					$(this).animate({height:$ini_height},$number);
				});
			});
		</script>
	</head>
	<body>
		<div class="head">
			<h1><?php echo $TITLE;?>, the smallest chat in the whole world</h1>
		</div>
		<div class="login">
			<h1>Log In</h1>
			<?php
				if($error_login != ""){echo "<p id=\"error\"> $error_login </p>";}
			?>
			<div id="login">


				<form method="post" action="login.php">
					<input id="email"    type="text"     name="email"    placeholder="E-mail"   maxlength="50" value=<?php echo $email_login;?>>
					<input id="password" type="password" name="password" placeholder="Password" maxlength="30">
					<input id="submit"   type="submit"   name="submit"   value="Log In">
				</form>
				<a href=""><h3>Forgot Password?</h3></a>
			</div>

		</div>
		<div class="signup">
			<h1>Sign Up</h1>
			<?php
				if($error_signup != ""){echo "<p id=\"error\"> $error_signup </p>";}
			?>
			<div id="signup">


				<form method="post" action="signup.php">
					<input id="email"    type="text"     name="email"    placeholder="E-mail"           class=<?php if(in_array("email",$blank_array)){echo "blank";}else{echo "";}?>     maxlength="50"  value=<?php echo $email_signup; ?>>
					<input id="username" type="text"     name="username" placeholder="Username"         class=<?php if(in_array("username",$blank_array)){echo "blank";}else{echo "";}?>  maxlength="50"  value=<?php echo $user_signup; ?>>
					<input id="first"    type="text"     name="first"    placeholder="First Name"       class=<?php if(in_array("first",$blank_array)){echo "blank";}else{echo "";}?>     maxlength="15"  value=<?php echo $first_signup; ?>>
					<input id="last"     type="text"     name="last"     placeholder="Last Name"        class=<?php if(in_array("last",$blank_array)){echo "blank";}else{echo "";}?>      maxlength="15"  value=<?php echo $last_signup; ?>>
					<input id="password" type="password" name="password" placeholder="Password"         class=<?php if(in_array("password",$blank_array)){echo "blank";}else{echo "";}?>  maxlength="30">
					<input id="confirm"  type="password" name="confirm"  placeholder="Confirm Password" class=<?php if(in_array("confirm",$blank_array)){echo "blank";}else{echo "";}?>   maxlength="30">
					<input id="submit"   type="submit"   name="submit"   value="Sign Up">

				</form>
			</div>

		</div>
	</body>
</html>
