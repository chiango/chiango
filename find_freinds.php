<?php
require_once("phpfunctions/function.php");

// $method = "firstname"/"latname"/"username"
// $query = passed in data from ajax

$connection = db_connect();

$sql = "SELECT * FROM users WHERE activated=1 ORDER BY lastname;";
$all_users = db_perform($connection,$sql);

//for every user
for($count=0; $count<$all_users["length"]; $count++){
    $searched = $all_users["row"][$count][$method];
    //for every substring it makes
    for($i=strlen($searched); $i>0; $i--){
        $substring = substr($searched,0,$i);
        if($query === $substring){
            if($i === strlen($searched)){
                //exact match
            }else{
                //rough match
            }
        }
    }
}

db_close($connection);

echo "";
?>
