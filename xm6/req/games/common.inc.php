<?php
	$tbl = 'games';
	$pk = 'game_id';
	
	$pick_opt = array('h' => 'Home', 'a' => 'Away');
	$pick_mod = array('p' => 'p', '?' => '?', '*' => '*', '!' => '!');
	
	/*$season = db::first($db->query("SELECT * FROM seasons WHERE %u BETWEEN s_ts AND e_ts LIMIT 1", time()));
	if (!$season)
		$season = db::first($db->query("SELECT * FROM seasons ORDER BY year DESC LIMIT 1"));
	
	$week = db::one($db->query("SELECT week FROM games WHERE year = %u AND status != 'F' ORDER BY game_id ASC LIMIT 1", $season['year']));*/
	
	function process_pick_data($str, &$ea)
	{
		$ea = array();
		$lines = explode("\n", $str);
		foreach ($lines as $k=>$line)
		{
			$ret = process_pick_line($line, $el);
			if (!$ret)
				$ea[] = array($k, $el);
		}
		
		return !(bool)count($ea);
	}
	
	function process_pick_line($str, &$el)
	{
		global $db, $season;
		
		$el = false;
		
		if (!trim($str))
			return true;
		
		$a = array_map('trim', explode('|', $str));
		if (count($a) != 9)
		{
			$el = "Invalid column count ".count($a);
			return false;
		}
		
		list($week, $day, $date, $time, $v_code, $h_code, $spread, $pick, $notes) = $a;
		
		if (!strlen($v_code))
		{
			$el = "No away team specified";
			return false;
		}
		if (!strlen($h_code))
		{
			$el = "No home team specified";
			return false;
		}
		
		$spread_f = substr($spread, -1, 1);
		$spread = substr($spread, 0, -1);
		if ($spread == 'even')
			$spread = 0;
		$spread_f = strtolower($spread_f);
		
		if (!is_numeric($spread))
		{
			$el = "Invalid point spread value {$spread}";
			return false;
		}
		
		if (!in_array($spread_f, array('a', 'h')))
		{
			$el = "Invalid favoring in point spread: {$spread_f}";
			return false;
		}
		
		$spread = -$spread;
		
		$pick1 = '';
		$pick2 = '';
		if ($pick)
		{
			$pick1 = strtolower(substr($pick, 0, 1));
			if (!in_array($pick1, array('a', 'h')))
			{
				$el = "Invalid favoring in pick: {$pick1}";
				return false;
			}
			
			$pick2 = strtolower(substr($pick, 1, 1));
			if (!in_array($pick2, array('', '*', '!', '?', 'p')))
			{
				$el = "Invalid modifier in pick: {$pick2}";
				return false;
			}
		}
		
		$v_team_id = db::one($db->query("SELECT team_id FROM teams WHERE code = '%s' OR code2 = '%s'", $v_code, $v_code));
		if (!$v_team_id)
		{
			$el = "Away team not found by code: {$v_code}";
			return false;
		}
		$h_team_id = db::one($db->query("SELECT team_id FROM teams WHERE code = '%s' OR code2 = '%s'", $h_code, $h_code));
		if (!$h_team_id)
		{
			$el = "Home team not found by code: {$h_code}";
			return false;
		}
		
		$game = db::first($db->query("SELECT game_id FROM games WHERE year = %u AND week = %u AND h_team_id = %u AND v_team_id = %u", $season['year'], $week, $h_team_id, $v_team_id));
		if (!$game)
		{
			$el = "Game not found: {$v_code} at {$h_code} week {$week}, season {$season['year']}";
			return false;
		}
		
		$db->query("UPDATE games SET spread = %u, spread_f = '%s', pick = '%s', pick_mod = '%s' WHERE game_id = %u", $spread * 10, $spread_f, $pick1, $pick2, $game['game_id']);
		
		return true;
	}
?>