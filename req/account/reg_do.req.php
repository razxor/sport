<?php
	require '../../inc/global.inc.php';
	require '../../classes/class.user.php';
	$usr = new user();
	
	$_POST = array_map('trim', $_POST);
	$ea = array();

	if (!@$_POST[$t='r_user'])
		$ea[] = array($t, 'user');
	else if (!val_user($_POST[$t='r_user']))
		$ea[] = array($t, 'user_i');
	else if (count($db->query("SELECT user_id FROM users WHERE user = '%s'", $_POST[$t])))
		$ea[] = array($t, 'user_d');
	if (!@$_POST[$t='r_pass'])
		$ea[] = array($t, 'pass');
	else if (strlen($_POST[$t='r_pass']) < 6)
		$ea[] = array($t, 'pass_s');
	if (!@$_POST[$t='r_name'])
		$ea[] = array($t, 'name');
	if (!@$_POST[$t='r_email'])
		$ea[] = array($t, 'email');
	else if (!val_email($_POST[$t]))
		$ea[] = array($t, 'email_i');
	else if (count($db->query("SELECT user_id FROM users WHERE email = '%s'", $_POST[$t])))
		$ea[] = array($t, 'email_d');
	if (!@$_POST[$t='r_phone'])
		$ea[] = array($t, 'phone');
	else if (!val_phone($_POST[$t]))
		$ea[] = array($t, 'phone_i');
	else if (count($db->query("SELECT user_id FROM users WHERE phone = '%s'", $_POST[$t])))
		$ea[] = array($t, 'phone_d');

	if (!count($ea))
	{
		$c_ts = time();
		$db->query("INSERT INTO users (c_ts, user, pass, p_ts, email, name, phone, active)
					VALUES (%u, '%s', '%s', %u, '%s', '%s', '%s', %u)",
					$c_ts, $_POST['r_user'], phash($_POST['r_pass']), $c_ts, $_POST['r_email'], $_POST['r_name'], $_POST['r_phone'], 1);
		$user_id = $db->insert_id();
		
		$usr->login($_POST['r_user'], $_POST['r_pass'], 1);
		
		$ret = array('status' => 1);
	}
	else
	{
		$ret = array('status' => -1, 'ea' => $ea);
	}
	
	header('Content-Type: application/json');
	echo json_encode($ret);
?>