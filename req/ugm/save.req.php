<?php
	require '../../inc/global.inc.php';
	require '../../classes/class.user.php';
	$usr = new user();
	
	$_POST = trim_r($_POST);
	$ea = array();
	
	if (!$usr->logged_in())
		$ea[] = array('login', 'login');
	
	if (!count($ea))
	{
		$entry_id = db::one($db->query("SELECT entry_id FROM u_picks WHERE user_id = %u AND year = %u AND week = %u", $usr->p['user_id'], $_POST['y'], $_POST['w'])); 
		if (!$entry_id)
		{
			$db->query("INSERT INTO u_picks (user_id, c_ts, year, week) VALUES (%u, %u, %u, %u)", $usr->p['user_id'], time(), $_POST['y'], $_POST['w']);
			$entry_id = $db->insert_id();
		}
		$db->query("UPDATE u_picks SET bankroll = %d, m_ts = %u WHERE entry_id = %u", $_POST['bankroll'], time(), $entry_id);
		
		if (!is_array($_POST['gid']))
			$_POST['gid'] = array();
		
		$ga = db::assoc($db->query("SELECT game_id, spread, spread_f, pick FROM games WHERE game_id IN (%s)", $_POST['gid']));
			
		$_POST['gid'] = array_intersect($_POST['gid'], array_keys($ga));
		
		foreach ($_POST['gid'] as $k=>$game_id)
		{
			$pick = $_POST['pick'][$k];
			$spread = $_POST['spv'][$k];
			$spread_f = $_POST['spf'][$k];
			$wager = $_POST['wager'][$k];
			$odds = $_POST['odds'][$k];
			$notes = $_POST['notes'][$k];
			
			$gm = $ga[$game_id];
			
			if ($pick == $gm['pick'])
				$pick = '';
			if ($spread == $gm['spread'] && $spread_f == $gm['spread_f'])
			{
				$spread = 0;
				$spread_f = '';
			}
			
			$ch = $pick || $wager || $notes || $spread_f;
			if ($ch)
			{
				$db->query("REPLACE INTO u_picks_gm
							(user_id, game_id, spread, spread_f, pick, wager, odds, notes)
							VALUES (%u, %u, %u, '%s', '%s', %u, %u, '%s')",
							$usr->p['user_id'], $game_id, $_POST['spv'][$k], $_POST['spf'][$k], $_POST['pick'][$k], $wager, $odds, $notes);
			}
			else
			{
				$db->query("DELETE FROM u_picks_gm WHERE user_id = %u AND game_id = %u", $usr->p['user_id'], $game_id);
			}
		}
		
		$ret = array('status' => 1);
	}
	else
	{
		$ret = array('status' => -1, 'ea' => $ea);
	}
	
	header('Content-Type: application/json');
	echo json_encode($ret);
?>