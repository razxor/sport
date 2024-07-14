<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';

	$_POST = trim_r($_POST);
	$id = (int)@$_POST['id'];
	$k = @$_POST['k'];
	$v = @$_POST['v'];
	
	if (!in_array($k, array('active')))
		die("Cannot set property {$k}");
	
	if ($k == 'active' && !in_array($v, array(0, 1)))
		die("Cannot set value {$v}");
	
	$r = db::first($db->query("SELECT * FROM `%s` WHERE `%s` = %u", $tbl, $pk, $id));
	if (!$r)
		die('Item not found');
	
	$db->query("UPDATE `%s` SET `%s` = '%s' WHERE `%s` = %u", $tbl, $k, $v, $pk, $id);
	
	$ret = array('status' => 1);
	header('Content-Type: application/json');
	echo json_encode($ret);
?>