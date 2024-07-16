<?php
	require '../../inc/global.inc.php';
	require '../../classes/class.user.php';
	$usr = new user();
	
	$year = @$_POST['y'];
	$week = @$_POST['w'];
	
	$games = $db->query("SELECT * FROM games WHERE year = %u AND week = %u ORDER BY game_id ASC", $year, $week);
	pp::games($games);
	
	$uga = db::assoc($db->query("SELECT game_id, spread, spread_f, pick, wager, odds, notes FROM u_picks_gm WHERE user_id = %u AND game_id IN (%s)", $usr->p['user_id'], db::choose($games, 'game_id')));
	pp::add_user_picks($games, $uga);
	
	$t_now = time() + $time_offset;
	
	$all_fin = true;
	
	$ret = array('g' => array());
	foreach ($games as $r)
	{
		if ($r['status'] != 'F')
			$all_fin = false;
		if ($r['g_ts'] < $t_now)
		{
			$p_res = false;
			if ($r['pick'] && $r['status'] == 'F')
				$p_res = bc::pick_result($r);
			$ret['g'][] = array('game_id' => $r['game_id'], 'v_score' => $r['v_score'], 'h_score' => $r['h_score'], 'p_res' => $p_res);
		}
	}
	
	$ret['af'] = $all_fin;
	
	header('Content-Type: application/json');
	echo json_encode($ret);
?>