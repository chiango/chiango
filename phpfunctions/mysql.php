<?php
	define("server","localhost");
	define("username","test");
	define("password","132978");
	define("database","chiango");
	define("table","users");

	//connect to mysql database and return the connection
	function db_connect(){
		$con = new mysqli(server,username,password,database);
		if($con -> connect_errno){
			echo "There were some errors connecting to the database.<br>";
			echo $con->connect_error;
		}
		return $con;
	}

	//close he connection to database
	function db_close(){$con->close();}

	//perform a query to the database from the connection
	//and if it is a SELECT query, return the result
	function db_perform($query){
		if(!$result = $con->query($query)){
			echo "Errors trying to peroform query ".$query."<br>";
			echo $con->error;
		}

		if($result !== true){
			$return=[];
			$count=0;
			$return["length"] = $result->num_rows;
			while( $row=$result->fetch_assoc() ){
				$return["row"][$count] = $row;
				$count+=1;
			}
			return $return;

		}else{return true;}
	}

	//using db_perform() to check if a value exists in a table
	function mysql_exists($table,$checkprop,$checkvalue,$returnprop,$limit=true){
		if( isset($con) ){
			$sql = "SELECT ".$returnprop." FROM ".$table." WHERE ".$checkprop."=".$checkvalue." LIMIT 1;";
			$result = db_perform($sql);
			if( $result["length"] === 0 ){return false;}
		}
		return $result["row"][0];
	}

	//checks for reapeating username/password and adds a new user to
	function add_login_info($email,$password,$username,$firstname,$lastname){
		if( isset($con)  ){
			$email_unique = mysql_empty("users","email","'".$email."'","id");
			$username_unique = mysql_empty("users","username","'".$username."'","id");

			if($email_unique and $username_unique){
				$id = generate_random(30);
				while (mysql_empty("users","id","'".$id."'","email") != false){
					$id = generate_random(30);
				}

				$result = "";
				$result .= "INSERT INTO users (id, email, password, username, firstname, lastname, activated)";
				$result .= "VALUES('".$id."','" .$email. "','" .$password. "','" .$username. "','" .$firstname. "','" .$lastname. "',0);";

				db_perform($result);
				return true;
			}
		}
		return false;
	}

	function add_friend($friender,$friended){
		$result = "";

		$result .= "INSERT INTO friends (friender,friended,time)";
		$result .= "VALUES('" .$friender. "','" .$friended. "','" .date("Y-m-d"). "');";

		return $result;
	}

	// function mysql_perform($query,$username="test",$password="132978",$dbname="chiango",$servername="localhost"){
	// 	$con = new mysqli($servername,$username,$password,$dbname);
	// 	if($con -> connect_errno){
	// 		echo "There were some errors connecting to the database.<br>";
	// 		echo $con->connect_error;
	// 	}
	// 	if(!$result=$con->query($query)){
	// 		echo "Errors trying to peroform query ".$query."<br>";
	// 		echo $con->error;
	// 	}
	// 	$con->close();
	//
	// 	if($result !== true){
	// 		$return=[];
	// 		$count=0;
	// 		$return["length"]=$result->num_rows;
	// 		while( $row=$result->fetch_assoc() ){
	// 			$return["row"][$count] = $row;
	// 			$count+=1;
	// 		}
	// 		return $return;
	//
	// 	}else{return true;}
	//
?>
