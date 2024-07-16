<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';

	$_POST = trim_r($_POST);

	$ea = array();
	if (!strlen(@$_POST[$t='name']))
		$ea[] = array($t, $t);
	if (!strlen(@$_POST[$t='email']))
		$ea[] = array($t, $t);
	else if (!val_email($_POST[$t]))
		$ea[] = array($t, "{$t}_i");
	else if (count($db->query("SELECT `%s` FROM users WHERE `%s` = '%s' AND user_id != %u LIMIT 1", $pk, $t, $_POST[$t], $usr->p['user_id'])))
		$ea[] = array($t, "{$t}_d");
	if (strlen($_POST[$t='phone']))
	{
		if (!val_phone($_POST[$t]))
			$ea[] = array($t, "{$t}_i");
		else if (count($db->query("SELECT `%s` FROM users WHERE `%s` = '%s' AND user_id != %u LIMIT 1", $pk, $t, fix_phone($_POST[$t]), $usr->p['user_id'])))
			$ea[] = array($t, "{$t}_d");
	}
	if (!strlen(@$_POST[$t='user']))
		$ea[] = array($t, $t);
	else if (!val_user($_POST[$t]))
			$ea[] = array($t, "{$t}_i");
	else if (count($db->query("SELECT `%s` FROM users WHERE `%s` = '%s' AND user_id != %u LIMIT 1", $pk, $t, $_POST[$t], $usr->p['user_id'])))
		$ea[] = array($t, "{$t}_d");
	
	if ($_POST['user'] != $usr->p['user'] || strlen($_POST['pass1']))
	{
		if (!strlen(@$_POST[$t='pass0']))
			$ea[] = array($t, $t);
		else if (phash($_POST[$t]) != $usr->p['pass'])
			$ea[] = array($t, 'pass_i');
	}
	
	if (strlen($_POST['pass1']))
	{
		if (strlen(@$_POST[$t='pass1']) < 6)
			$ea[] = array($t, 'pass_s');
	}

	if (!count($ea))
	{
		$db->query("UPDATE `%s` SET name = '%s', email = '%s', phone = '%s', user = '%s' WHERE `%s` = %u",
			$tbl, $_POST['name'], $_POST['email'], fix_phone($_POST['phone']), $_POST['user'], $pk, $usr->p[$pk]);

		if ($_POST['user'] != $usr->p['user'])
			$usr->rekey();
		
		if ($_POST['pass1'] && phash($_POST['pass1']) != $usr->p['pass'])
		{
			$db->query("UPDATE `%s` SET pass = '%s', p_ts = %u WHERE `%s` = %u", $tbl, phash($_POST['pass1']), time(), $pk, $usr->p[$pk]);
			$usr->rekey();
		}
			
		$ret = array('ea' => array());
		header('Content-Type: application/json');
		echo json_encode($ret);
	}
	else
	{
		$ret = array('ea' => $ea);
		header('Content-Type: application/json');
		echo json_encode($ret);
	}
?>