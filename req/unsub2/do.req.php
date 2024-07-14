<?php
	require '../../inc/global.inc.php';
	$_POST = array_map('trim', $_POST);
	$ea = array();
	
	if (!@$_POST[$t='email'] || !@$_POST[$t='x'])
		$ea[] = array('main', 'params');
	else if (!($sub = db::first($db->query("SELECT * FROM subs WHERE email = '%s'", $_POST['email']))))
		$ea[] = array('main', 'ns');
	else if ($sub['c_ts'] != $_POST['x'])
		$ea[] = array('main', 'params');
		
	if (!count($ea))
	{
		$db->query("DELETE FROM subs WHERE email = '%s'", $_POST['email']);
		
		$ret = array('status' => 1);
		header('Content-Type: application/json');
		echo json_encode($ret);
	}
	else
	{
		$ret = array('status' => -1, 'ea' => $ea);
		header('Content-Type: application/json');
		echo json_encode($ret);
	}
?>