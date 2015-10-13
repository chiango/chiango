<?php
	include("phpfunctions/other.php");
	session_start(); session_destroy();
	redirect_to("index.php");
?>
