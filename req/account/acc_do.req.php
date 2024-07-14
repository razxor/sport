<?php
	require '../../inc/global.inc.php';
	require '../../classes/class.user.php';
	$usr = new user();
	
	$_POST = array_map('trim', $_POST);
	$ea = array();
	
	if (!$usr->logged_in())
		$ea[] = array('login', 'login');
	
	if (!count($ea))
	{
		if ($_POST['user'] != $usr->p['user'] && $usr->p['u_ch'])
		{
			if (!strlen($_POST[$t='user']))
				$ea[] = array($t, $t);
			else if (!val_user($_POST[$t]))
				$ea[] = array($t, 'user_i');
			else if (count($db->query("SELECT user_id FROM users WHERE user = '%s' AND user_id != %u", $_POST[$t], $usr->p['user_id'])))
				$ea[] = array($t, 'user_d');
		}
		
		if ($_POST['user'] != $usr->p['user'] && !$usr->p['u_ch'])
			$ea[] = array('user', 'user_ch');
			
		if (strlen($_POST['pass1']))
		{
			if (!strlen($_POST[$t='pass0']))
				$ea[] = array($t, 'pass');
			else if (phash($_POST[$t]) != $usr->p['pass'])
				$ea[] = array($t, 'wrong');
			if (strlen($_POST[$t='pass1']) < 6)
				$ea[] = array($t, 'short');
			if (!strlen($_POST[$t='pass2']))
				$ea[] = array($t, 'confirm');
			else if ($_POST[$t] != $_POST['pass1'])
				$ea[] = array($t, 'match');
			else if ($_POST['pass0'] == $_POST[$t='pass1'])
				$ea[] = array($t, 'same');
		}
	}
	
	if (!count($ea))
	{
		if (strlen($_POST['pass1']) && $usr->p['pass'] != phash($_POST['pass1']))
		{
			$db->query("UPDATE users SET pass = '%s', p_ts = %u WHERE user_id = %u", phash($_POST['pass1']), time(), $usr->p['user_id']);
			$usr->rekey();
		}
		if ($_POST['user'] != $usr->p['user'] && $usr->p['u_ch'])
		{
			$db->query("UPDATE users SET user = '%s', u_ch = 0 WHERE user_id = %u", $_POST['user'], $usr->p['user_id']);
			$usr->rekey();
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