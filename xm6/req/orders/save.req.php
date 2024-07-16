<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require '../../../classes/class.sub.php';
	require 'common.inc.php';

	$_POST = trim_r($_POST);
	$id = (int)@$_POST['id'];
	$ea = array();

	$_POST['email'] = strtolower($_POST['email']);
	
	if ($id)
	{
		$r = db::first($db->query("SELECT * FROM `%s` WHERE `%s` = %u", $tbl, $pk, $id));
		if (!$r)
			die('Item not found');
	}
	
	if (!($c_ts = strtotime($_POST[$t='date'])))
		$ea[] = array($t, $t);
	if (!strlen(@$_POST[$t='name']))
		$ea[] = array($t, $t);
	if (!strlen(@$_POST[$t='email']))
		$ea[] = array($t, $t);
	else if (!val_email($_POST[$t]))
		$ea[] = array($t, "{$t}_i");
	
	if (!count($ea) && $_POST['status'] == 'C')
	{
		if (count($db->query("SELECT `%s` FROM `%s` WHERE `%s` != %u AND email = '%s' AND opt = 'y' AND year = %u AND status = 'C' LIMIT 1", $pk, $tbl, $pk, $id, $_POST['email'], $_POST['year'])))
			$ea[] = array($t, 'dup_y');
		else if (count($db->query("SELECT `%s` FROM `%s` WHERE `%s` != %u AND email = '%s' AND opt = 'w' AND year = %u AND week = %u AND status = 'C' LIMIT 1", $pk, $tbl, $pk, $id, $_POST['email'], $_POST['year'], $_POST['week'])))
			$ea[] = array($t, 'dup_w');
	}
		
	if (!count($ea))
	{
		if (!$id)
		{
			$db->query("INSERT INTO `%s` (c_ts) VALUES (%u)", $tbl, time());
			$id = $db->insert_id();
		}
		
		if ($_POST['opt'] == 'y')
			$_POST['week'] = 0;
		
		$db->query("UPDATE `%s`
					SET name = '%s', email = '%s', opt = '%s', year = %u, week = %u, status = '%s', txn_id = '%s', price = %.2f
					WHERE `%s` = %u",
					$tbl,
					$_POST['name'], $_POST['email'], $_POST['opt'], $_POST['year'], $_POST['week'], $_POST['status'], $_POST['txn_id'], $_POST['price'],
					$pk, $id);
		
		if (@$r && D($r['c_ts']) != D($c_ts))
			$db->query("UPDATE `%s` SET c_ts = %u WHERE `%s` = %u", $tbl, $c_ts, $pk, $id);
		
		if (@$r && $r['email'] != $_POST['email'])
			$db->query("UPDATE subs SET email = '%s' WHERE email = '%s'", $_POST['email'], $r['email']);
		
		$r = $_POST;
		$r[$pk] = $id;
			
		if ($_POST['status'] == 'V')
			sub::disable_paid($r);
		else
			sub::have_paid($r);
		
			
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