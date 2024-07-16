<?php
	$meta['title'] = 'Scores';
	$meta['robots'] = 'noindex,nofollow';
	$meta['canonical'] = '/my-picks/scores/';
	$show_ads = false;
	
	require 'classes/class.user.php';
	$usr = new user();
	if (!$usr->logged_in())
		$JS[] = '/js/login.js';
	else
	{
		$JS[] = '/js/pick-scores.js';
		
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
		
		$games = $db->query("SELECT G.*, UG.spread, UG.spread_f, UG.pick, UG.wager, UG.odds, UG.notes FROM games G JOIN u_picks_gm UG ON (G.game_id = UG.game_id AND user_id = %u) WHERE G.year = %u AND G.week = %u ORDER BY G.game_id ASC", $usr->p['user_id'], $year, $week);
		pp::games($games);
		
		$needs_refresh = (int)($game_year == $year && $game_week == $week);
	}
	
	$layout = 'default';
?>