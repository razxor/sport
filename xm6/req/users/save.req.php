<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';

	$_POST = trim_r($_POST);
	$id = (int)@$_POST['id'];
	$ea = array();

	if ($id)
	{
		$r = db::first($db->query("SELECT * FROM `%s` WHERE `%s` = %u", $tbl, $pk, $id));
		if (!$r)
			die('Item not found');
	}
	
	if ($usr->p['user_id'] != $id)
	{
		if (!strlen(@$_POST[$t='user']))
			$ea[] = array($t, $t);
		else if (!val_user($_POST[$t]))
			$ea[] = array($t, "{$t}_i");
		else if (count($db->query("SELECT `%s` FROM `%s` WHERE `%s` != %u AND `%s` = '%s'", $pk, $tbl, $pk, $id, $t, $_POST[$t])))
			$ea[] = array($t, "{$t}_d");
	}
	
	if (!$id)
	{
		if (!strlen(@$_POST[$t='pass']))
			$ea[] = array($t, $t);
		else if (strlen(@$_POST[$t='pass']) < 6)
			$ea[] = array($t, "{$t}_s");
	}
	
	if (!strlen(@$_POST[$t='name']))
		$ea[] = array($t, $t);
	if (!strlen(@$_POST[$t='email']))
		$ea[] = array($t, $t);
	else if (!val_email($_POST[$t]))
		$ea[] = array($t, "{$t}_i");
	else if (count($db->query("SELECT `%s` FROM `%s` WHERE `%s` != %u AND `%s` = '%s'", $pk, $tbl, $pk, $id, $t, $_POST[$t])))
		$ea[] = array($t, "{$t}_d");
	
	if (strlen(@$_POST[$t='phone']))
	{
		if (!val_phone($_POST[$t]))
			$ea[] = array($t, "{$t}_i");
		else if (count($db->query("SELECT `%s` FROM `%s` WHERE `%s` != %u AND `%s` = '%s'", $pk, $tbl, $pk, $id, $t, fix_phone($_POST[$t]))))
			$ea[] = array($t, "{$t}_d");
	}

	if (!count($ea))
	{
		if (!$id)
		{
			$db->query("INSERT INTO `%s` (c_ts) VALUES (%u)", $tbl, time());
			$id = $db->insert_id();
		}
		
		$db->query("UPDATE `%s`
					SET name = '%s', email = '%s', phone = '%s'
					WHERE `%s` = %u",
					$tbl,
					$_POST['name'], $_POST['email'], fix_phone($_POST['phone']),
					$pk, $id);
		
		if ($usr->p['user_id'] != $id)
		{
			$db->query("UPDATE `%s`
					SET user = '%s', role_id = %u, active = %u
					WHERE `%s` = %u",
					$tbl,
					$_POST['user'], $_POST['role_id'], $_POST['active'],
					$pk, $id);
			
			if ($_POST['pass'])
			{
				$db->query("UPDATE `%s` SET pass = '%s' WHERE `%s` = %u", $tbl, phash($_POST['pass']), $pk, $id);
			}
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