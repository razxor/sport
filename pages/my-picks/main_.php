<?php
	$meta['title'] = 'My picks';
	$meta['robots'] = 'noindex,nofollow';
	$meta['canonical'] = '/my-picks/';
	$show_ads = false;
	
	require 'classes/class.user.php';
	$usr = new user();
	if (!$usr->logged_in())
		$JS[] = '/js/login.js';
	else
	{
		$JS[] = '/js/my-picks.js?2018022415';
		
		$ss = bc::get_season('P');
		$game_year = $year = $ss['year'];
		if (is_numeric(@$_GET[$t='y']))
			$year = $_GET[$t];
			
		$seasons = $db->query("SELECT DISTINCT year FROM games ORDER BY year ASC");
		$weeks = $db->query("SELECT DISTINCT week FROM games WHERE year = %u ORDER BY week ASC", $year);
		//$last_week = db::one($db->query("SELECT week FROM games WHERE year = %u AND pick != '' AND pick_mod != 'p' ORDER BY year DESC, week DESC LIMIT 1", $year));
		$game_week = $week = bc::get_week($year, 'G');
		if (is_numeric(@$_GET[$t='w']))
			$week = $_GET[$t];
		
		$games = $db->query("SELECT * FROM games WHERE year = %u AND week = %u ORDER BY game_id ASC", $year, $week);
		pp::games($games);
		
		$needs_refresh = (int)($game_year == $year && $game_week == $week);
		
		$ud = db::first($db->query("SELECT * FROM u_picks WHERE user_id = %u AND year = %u AND week = %u", $usr->p['user_id'], $year, $week));
		if (!$ud['bankroll'])
			$ud['bankroll'] = 1000;
		
		$uga = db::assoc($db->query("SELECT game_id, spread, spread_f, pick, wager, odds, notes FROM u_picks_gm WHERE user_id = %u AND game_id IN (%s)", $usr->p['user_id'], db::choose($games, 'game_id')));
		pp::add_user_picks($games, $uga);
		
		$st = bc::pick_stats($games);
		$st2 = bc::game_stats($games);
	}
	
	$layout = 'default';
?>