<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';
	
	$_POST = trim_r($_POST);
	$v = (int)@$_POST['v'];
	$ea = array();
	
	if (!count($ea))
	{
		$db->query("REPLACE INTO settings (k, v) VALUES ('%s', '%s')", 'free_auto', $v);
		
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