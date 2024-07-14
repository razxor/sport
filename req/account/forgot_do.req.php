<?php
	require '../../inc/global.inc.php';
	
	$_POST = array_map('trim', $_POST);
	$_POST['s_email'] = strtolower(@$_POST['s_email']);
	$ea = array();
	
	if (!count($ea))
	{
		if (!@$_POST[$t='s_email'])
			$ea[] = array($t, 'email');
		else if (!val_email($_POST[$t]))
			$ea[] = array($t, 'email_i');
		else if (!($us = db::first($db->query("SELECT user_id, email FROM users WHERE email = '%s'", $_POST['s_email']))))
			$ea[] = array($t, 'email_nf');
		else if (db::one($db->query("SELECT entry_id FROM reset_r WHERE user_id = %u AND c_ts > %u", $us['user_id'], time() - 3600)))
			$ea[] = array($t, 'reset_l');
	}
	
	if (!count($ea))
	{
		srand(microtime(true) * 1000000);
		$x1 = rand(0, 0xFFFFFFFF - 1);
		$x2 = rand(0, 0xFFFFFFFF - 1);
		
		$db->query("UPDATE reset_r SET x1 = 0, x2 = 0 WHERE user_id = %u", $us['user_id']);
		$db->query("INSERT INTO reset_r (c_ts, user_id, x1, x2) VALUES (%u, %u, %u, %u)", time(), $us['user_id'], $x1, $x2);
		$entry_id = $db->insert_id();
		
		$rs_link = "/reset/".md5($entry_id)."/{$x1}/{$x2}";
		require dirname(__FILE__).'/../../libs/phpmailer/PHPMailerAutoload.php';
		send_email('reset', array('rs_link' => $rs_link, 'email' => $us['email']), "Password reset");
		
		$ret = array('status' => 1);
	}
	else
	{
		$ret = array('status' => -1, 'ea' => $ea);
	}
	
	header('Content-Type: application/json');
	echo json_encode($ret);
?>