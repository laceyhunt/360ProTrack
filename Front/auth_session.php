<?php
	session_start();
	if(!isset($_SESSION["email"])){
		header("Location: http://".$_SERVER['HTTP_HOST'].'/360ProTrack/360ProTrack/Front/login.php');
		exit();
	}
?>