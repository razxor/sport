<?php
	$meta['title'] = 'Edit access data';
	$meta['robots'] = 'noindex,nofollow';
	$meta['canonical'] = '/account/acces/';
	$show_ads = false;
	
	require 'classes/class.user.php';
	$usr = new user();
	if (!$usr->logged_in())
		$JS[] = '/js/login.js';
	else
		$JS[] = '/js/acc_pw.js';
	
	$layout = 'account';
?>