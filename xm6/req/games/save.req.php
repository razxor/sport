<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';

	$_POST = trim_r($_POST);
	$id = (int)@$_POST['id'];
	$ea = array();

	$r = db::first($db->query("SELECT * FROM `%s` WHERE `%s` = %u", $tbl, $pk, $id));
	if (!$r)
		die('Item not found');

	if (!count($ea))
	{
		$db->query("UPDATE `%s`
					SET pick = '%s', pick_mod = '%s', spread = %u, spread_f = '%s'
					WHERE `%s` = %u",
					$tbl,
					$_POST['pick'], $_POST['pick_mod'], $_POST['spread'], $_POST['spread_f'],
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