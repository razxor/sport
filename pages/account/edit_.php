<?php
	$meta['title'] = 'Edit contact info';
	$meta['robots'] = 'noindex,nofollow';
	$meta['canonical'] = '/account/edit/';
	$show_ads = false;
	
	require 'classes/class.user.php';
	$usr = new user();
	if (!$usr->logged_in())
		$JS[] = '/js/login.js';
	else
		$JS[] = '/js/acc_edit.js';
	
	$layout = 'account';
?>