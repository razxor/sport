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
	
	if (!($s_ts = strtotime($_POST[$t='s_date'])))
		$ea[] = array($t, $t);
	if (!($e_ts = strtotime($_POST[$t='e_date'])))
		$ea[] = array($t, $t);
	
	if (!count($ea))
	{
		if ($s_ts > $e_ts)
			$ea[] = array('e_date', 'date_b');
		$year = date('Y', $s_ts);
	}
		
	if (!count($ea))
	{
		if (!$id)
		{
			$db->query("INSERT INTO `%s` (`%s`) VALUES (%u)", $tbl, $pk, $year);
			$id = $year;
		}
		
		$db->query("UPDATE `%s`
					SET s_ts = %u, e_ts = %u
					WHERE `%s` = %u",
					$tbl,
					$s_ts, $e_ts,
					$pk, $id);
		
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