<?php
	require '../../inc/global.inc.php';
	require '../../classes/class.user.php';
	$usr = new user();
	
	$_POST = array_map('trim', $_POST);
	$_POST['email'] = strtolower($_POST['email']);
	$ea = array();
	
	if (!$usr->logged_in())
		$ea[] = array('login', 'login');
	
	if (!count($ea))
	{
		if (!@$_POST[$t='name'])
			$ea[] = array($t, $t);
		if (!@$_POST[$t='email'])
			$ea[] = array($t, $t);
		else if (!val_email($_POST[$t]))
			$ea[] = array($t, 'email_i');
		else if (count($db->query("SELECT user_id FROM users WHERE email = '%s' AND user_id != %u", $_POST[$t], $usr->p['user_id'])))
			$ea[] = array($t, 'email_d');
		if (!@$_POST[$t='phone'])
			$ea[] = array($t, 'phone');
		else if (!val_phone($_POST[$t]))
			$ea[] = array($t, 'phone_i');
		else if (count($db->query("SELECT user_id FROM users WHERE phone = '%s' AND user_id != %u", $_POST[$t], $usr->p['user_id'])))
			$ea[] = array($t, 'phone_d');
	}
	
	if (!count($ea))
	{
		$m = 'ok';
		
		$db->query("UPDATE users SET name = '%s', email = '%s', phone = '%s' WHERE user_id = %u",
				$_POST['name'], $_POST['email'], $_POST['phone'], $usr->p['user_id']);
				
		$ret = array('status' => 1, 'm' => $m);
	}
	else
	{
		$ret = array('status' => -1, 'ea' => $ea);
	}
	
	header('Content-Type: application/json');
	echo json_encode($ret);
?>