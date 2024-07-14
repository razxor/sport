<?php
	require 'inc/global.inc.php';
	$usr->logout();
	header("Location: login.php");
	die();
?>