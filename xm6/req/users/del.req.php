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

	if ($usr->p[$pk] == $id)
		die('Don\'t delete yourself');
		
	if (!count($ea))
	{
		$db->query("DELETE FROM `%s` WHERE `%s` = %u", $tbl, $pk, $id);
				
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