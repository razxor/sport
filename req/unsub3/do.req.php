<?php
	require '../../inc/global.inc.php';
	$_POST = array_map('trim', $_POST);
	$ea = array();
	
	if (!@$_POST[$t='email'])
		$ea[] = array($t, $t);
	else if (!val_email($_POST[$t]))
		$ea[] = array($t, "i_{$t}");
	else if (!($sub = db::first($db->query("SELECT * FROM subs WHERE email = '%s'", $_POST['email']))))
		$ea[] = array('main', 'ns');
		
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