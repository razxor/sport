<?php
	require '../../inc/global.inc.php';
	require '../../classes/class.user.php';
	$usr = new user();
	
	$_POST = trim_r($_POST);
	$ea = array();
	
	if (!$usr->logged_in())
		$ea[] = array('login', 'login');
	
	$year = @$_POST['y'];
	$week = @$_POST['w'];
	$v = @$_POST['v'];
	
	if (!count($ea))
	{
		$n_year = $year;
		$n_week = $week + 1;
		if ($week == 20)
			$n_week = 22;
		else if ($week == 22)
		{
			$n_year++;
			$n_week = 1;
		}
	}
	
	if (!count($ea))
	{
		$entry_id = db::one($db->query("SELECT entry_id FROM u_picks WHERE user_id = %u AND year = %u AND week = %u", $usr->p['user_id'], $n_year, $n_week)); 
		if (!$entry_id)
		{
			$db->query("INSERT INTO u_picks (user_id, c_ts, year, week) VALUES (%u, %u, %u, %u)", $usr->p['user_id'], time(), $n_year, $n_week);
			$entry_id = $db->insert_id();
		}
		$db->query("UPDATE u_picks SET bankroll = %d WHERE entry_id = %u", $v, $entry_id);
		
		$ret = array('status' => 1);
	}
	else
	{
		$ret = array('status' => -1, 'ea' => $ea);
	}
	
	header('Content-Type: application/json');
	echo json_encode($ret);
?>