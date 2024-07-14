<?php
	$meta['title'] = 'Pick results';
	$meta['robots'] = 'noindex,nofollow';
	$meta['canonical'] = '/my-picks/results/';
	$show_ads = false;
	
	require 'classes/class.user.php';
	$usr = new user();
	if (!$usr->logged_in())
		$JS[] = '/js/login.js';
	else
	{
		$JS[] = '/js/pick-results.js';
		
		$ss = bc::get_season('P');
		$year = $ss['year'];
		if (is_numeric(@$_GET[$t='y']))
			$year = $_GET[$t];
		
		$recs_bc = bc::season_results_bc($year);
		$stats_bc = bc::season_result_stats($recs_bc);
		
		$recs_us = bc::season_results_us($year);
		$stats_us = bc::season_result_stats($recs_us);
		
		$recs_hh = bc::season_results_hh($year);
		$stats_hh = bc::season_result_stats($recs_hh);
	}
	
	$layout = 'default';
?>