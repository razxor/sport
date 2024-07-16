<?php
	$meta['title'] = 'Account';
	$meta['robots'] = 'noindex,nofollow';
	$meta['canonical'] = '/account/';
	
	require 'classes/class.user.php';
	$usr = new user();
	if (!$usr->logged_in())
		$JS[] = '/js/login.js';
	
	$bt = false;
	if (@$_GET['bt'])
	{
		$pu = parse_url($_GET['bt']);
		if (@$pu['host'] == $maind || @$pu['host'] == $maindw)
			$bt = "{$url_proto}://{$maindw}{$pu['path']}";
	}
	
	$layout = 'account';
?>