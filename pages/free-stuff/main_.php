<?php
	$meta['title'] = 'Free weekly NFL picks';
	$meta['description'] = "Sign up for free weekly info to verify our winning NFL picks";
	$meta['canonical'] = '/free-stuff/';
	$JS[] = '/js/free.js';
	
	if (1)
	{
		$D['email'] = 'contact@pichost.me';
	}
	
	require 'classes/class.user.php';
	$usr = new user();
	if ($usr->logged_in())
		$D['email'] = $usr->p['email'];
?>