<?php
	require '../../inc/global.inc.php';
	require '../../classes/class.user.php';
	$usr = new user();
	
	$_POST = array_map('trim', $_POST);
	$ea = array();
	
	$md5 = @$_POST['h'];
	$x1 = @$_POST['x1'];
	$x2 = @$_POST['x2'];
	
	if (!count($ea))
	{
		$rec = db::first($db->query("SELECT * FROM reset_r WHERE MD5(entry_id) = %u AND x1 = %u AND x2 = %u", $md5, $x1, $x2));
		if (!$rec)
			$ea[] = array('pass1', 'params');
	}
	
	if (!count($ea))
	{
		$us = db::first($db->query("SELECT user_id, user, pass FROM users WHERE user_id = %u", $rec['user_id']));
		if (!$us)
			$ea[] = array('pass1', 'params');
	}
	
	if (!count($ea))
	{
		if (!strlen($_POST[$t='pass1']))
			$ea[] = array($t, 'pass');
		else if (strlen($_POST[$t='pass1']) < 6)
			$ea[] = array($t, 'short');
		if (!strlen($_POST[$t='pass2']))
			$ea[] = array($t, 'confirm');
		else if ($_POST[$t] != $_POST['pass1'])
			$ea[] = array($t, 'match');
		else if ($us['pass'] == phash($_POST[$t='pass1']))
			$ea[] = array($t, 'same');
	}
	
	if (!count($ea))
	{
		$db->query("UPDATE users SET pass = '%s', p_ts = %u WHERE user_id = %u", phash($_POST['pass1']), time(), $us['user_id']);
		$usr->login($us['user'], $_POST['pass1'], 1);
		$db->query("UPDATE reset_r SET x1 = 0, x2 = 0 WHERE user_id = %u", $us['user_id']);
		
		$ret = array('status' => 1);
	}
	else
	{
		$ret = array('status' => -1, 'ea' => $ea);
	}
	
	header('Content-Type: application/json');
	echo json_encode($ret);
?>