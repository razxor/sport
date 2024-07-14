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
	
	if (!strlen(@$_POST[$t='title']))
		$ea[] = array($t, $t);
	
	if (!count($ea))
	{
		if (!$id)
		{
			$db->query("INSERT INTO `%s` (`%s`) VALUES (NULL)", $tbl, $pk);
			$id = $db->insert_id();
		}
		
		$db->query("UPDATE `%s`
					SET title = '%s', link = '%s', d_o = %d, active = %u
					WHERE `%s` = %u",
					$tbl,
					$_POST['title'], $_POST['link'], $_POST['d_o'], $_POST['active'],
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