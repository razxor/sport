<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';

	$_POST = trim_r($_POST);
	$id = (int)@$_POST['id'];
	$mode = @$_POST['mode'];
	
	if (!in_array($mode, array('up', 'dn')))
		die("Cannot set property {$mode}");
	
	$r = db::first($db->query("SELECT * FROM `%s` WHERE `%s` = %u", $tbl, $pk, $id));
	if (!$r)
		die('Item not found');
	
	$r['d_o'] += $mode == 'up' ? -10 : 10;
	$db->query("UPDATE `%s` SET d_o = %d WHERE `%s` = %u", $tbl, $r['d_o'], $pk, $id);
	
	$ret = array('status' => 1);
	header('Content-Type: application/json');
	echo json_encode($ret);
?>