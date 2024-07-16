<?php
	require 'classes/class.user.php';
	$usr = new user();
	$usr->logout();
	header("Location: {$url_proto}://{$maindw}/");
	die();
?>