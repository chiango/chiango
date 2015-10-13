<?php
	require_once("phpfunctions/function.php");
	session_start();

	//if user not logged in, redirect to home page
	if( !isset($_SESSION["login"]) ){redirect_to("index.php");}

	//if no value in $_GET, redirect to home page
	if( !isset($_GET["id"]) ){redirect_to("index.php");}

	//if the user is doesn't exist, it will return false
	//if the eser exists but it isn't activated, it will return 0
	//only if the user exists and it is activated will it return 1
	$this_user = mysql_property_exists("users","id","'".$_GET["id"]."'","*");

	if($this_user["activated"] != 1){redirect_to("index.php");}
	$visiting_user = $_SESSION["login"];

	//determinig if you are visiting your page or someone is visiting your page
	if( $this_user["username"] === $visiting_user["username"] ){$user = "Your";}
	else{$user =  $this_user["username"]."'s";}



	//getting the printing
	$exact_count = "no";
	$exact_match = "";
	$rough_match = "";
	$search_method = "";
	$search_text = "";


	$result = mysql_perform("SELECT firstname,lastname,username FROM users;");
	print_r($result);

	// if(isset($_POST["search"])){//search sebmitted
	// 	if(c_str_empty($_POST["searchtext"])){
	// 		//display all of the users in chiango in the result box
	// 	}else{
	// 		//getting the values of searchmethod and searchtext so we can put it back on the page
	// 		$search_method = $_POST["searchmethod"];
	// 		$search_text = $_POST["searchtext"];
	// 		//getting the searchmethos
	// 		if($_POST["searchmethod"] === "first"){$sm = "firstname";}
	// 		elseif($_POST["searchmethod"] === "last"){$sm = "lastname";}
	// 		else{$sm = "username";}
	//
	//
	// 		//searching for exact match
	// 		$find_match = mysql_property_exists("users",$sm,"'".$_POST["searchtext"]."'","*");
	// 		if($find_match !== false){
	// 			//if there is a exact match, put exact match
	// 			$exact_match = "<div class='search_box'>";
	// 			$exact_match .= "<h3>".$find_match["firstname"]." ".$find_match["lastname"]." (".$find_match["username"].")"."</h3>";
	// 			$exact_match .= "</div>";
	// 		}
	//
	//	}
	//}
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $user; ?> Homepage</title>


		<!-- trnsporting thr php $result to javascript -->
		<script type="text/javascript">
			var all_user = <?php echo json_encode($result) ?>;
			var usernames = [];
			var firsts = [];
			var lasts = [];

			for(var i=0; i<all_user.length ;i++){
				usernames.push( all_user.row[i]["username"]);
				firsts.push( all_user.row[i]["firstname"]);
				lasts.push( all_user.row[i]["lastname"]);
			}

		</script>

		<link rel="stylesheet" type="text/css" href="jscss/home.css">
		<script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>



	</head>
	<body>
		<script type="text/javascript" src="jscss/home.js"></script>
		<div class="header">
			<h1>Header</h1>
		</div>

		<div class="friends">
			<div class="tab_content">
				<div class="exist">
					<h2><?php echo $user; ?> Friends:</h2>
					<!--echo out current friends-->
					<ul>
						<?php
						$query = "SELECT * FROM friends WHERE friender='".$this_user["id"]."' OR friended='".$this_user["id"]."';";
						$friend_list = mysql_perform($query);
						for($count = 0;$count<$friend_list["length"];$count++){
							//if i am friender, return friended username
							//if i am friended, return friender username
							if($friend_list["row".$count]["friended"] === $this_user["id"]){
								$my_friend = $friend_list["row".$count]["friender"];
							}else{
								$my_friend = $friend_list["row".$count]["friender"];
							}

							echo "<li><div class='friend_box'><h3>".$my_friend."</h3></div></li>";
						}
						?>
					</ul>

				</div>

				<div class="search">

						<div class="search_by">
							<h2>Search By </h2>
							<form>
								<select id="method" name="searchmethod" >
									<option value="first">First Name</option>
									<option value="last">Last Name</option>
									<option value="user">Username</option>
								</select>

								<input id="searchbar" type="text" name="searchtext" placeholder="Type Name" value=<?php echo $search_text;?>>
								<!-- <input id="search" type="submit" value="Search" name="search"> -->
							</form>
						</div>


						<div class="exact_match">
							<p></p>
							<div class="matches">

							</div>
						</div>


						<div class="rough_match">
							<h4 id="s">R U Looking 4...</h4>
							<div class="matches">
								<?php echo $rough_match; ?>
							</div>
						</div>
				</div>



				<div class="confirm">
					<h2>Confirm these friend requests!</h2>
				</div>
			</div>
			<div class="friend_buttons">
				<button id="friends">Friends</button>
				<button id="search">Search</button>
				<button id="confirm">Confirm</button>
			</div>

		</div>

		<div class="groups">
			<h2><?php echo $user; ?> Groups:</h2>
		</div>

		<div class="page">
			<h2>Home Page of <?php echo $this_user["username"]; ?></h2>
		</div>

		<div class="logout_button">
			<button onclick="location.replace('logout.php');">Log Out</button>
		</div>

	</body>
</html>
