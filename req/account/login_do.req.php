<?php
	require '../../inc/global.inc.php';
	require '../../classes/class.user.php';
	$usr = new user();
	
	$_POST = array_map('trim', $_POST);
	$ea = array();

	if (!@$_POST[$t='l_user'])
		$ea[] = array($t, 'user');
	else if (!val_user($_POST[$t='l_user']) && !val_email($_POST[$t]))
		$ea[] = array($t, 'i_user');
	if (!@$_POST[$t='l_pass'])
		$ea[] = array($t, 'l_pass');
	else if (strlen($_POST[$t='l_pass']) < 4)
		$ea[] = array($t, 'i_pass');
	if (!count($ea) && !$usr->login($_POST['l_user'], $_POST['l_pass'], 1))
		$ea[] = array($t, 'login_f');

	if (!count($ea))
	{
		$ret = array('status' => 1);
	}
	else
	{
		$ret = array('status' => -1, 'ea' => $ea);
	}
	
	header('Content-Type: application/json');
	echo json_encode($ret);
?>