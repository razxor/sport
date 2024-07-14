<?php
	$meta['title'] = 'Edit mailing options';
	$meta['robots'] = 'noindex,nofollow';
	$meta['canonical'] = '/account/mailing/';
	$show_ads = false;
	
	require 'classes/class.user.php';
	$usr = new user();
	if (!$usr->logged_in())
		$JS[] = '/js/login.js';
	else
		$JS[] = '/js/acc_mailing.js';
	
	$layout = 'account';
?>