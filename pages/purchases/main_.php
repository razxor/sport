<?php
	$meta['title'] = 'Purchase weekly NFL picks';
	$meta['description'] = "Purchase one week's picks for ".P($week_price)." or purchase a discounted prorated remainder season package including playoffs";
	$meta['canonical'] = '/purchases/';
	$JS[] = '/js/buy.js?2018032916';
	$JS[] = 'https://www.paypalobjects.com/api/checkout.js';
	
	$ss = bc::get_season('N');
	$year = $ss['year'];
	$week = bc::get_week($year, 'P');
	
	require 'classes/class.user.php';
	$usr = new user();
	if ($usr->logged_in())
		$D[$t='email'] = $usr->p['email'];
	if (@$_GET[$t='email'])
		$D[$t] = $_GET[$t];
	if (@$_GET[$t='opt'])
		$D[$t] = $_GET[$t];
?>