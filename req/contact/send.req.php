<?php
	require '../../inc/global.inc.php';
	$_POST = array_map('trim', $_POST);
	$ea = array();

	//session_start();
	
	if (!@$_POST[$t='name'])
		$ea[] = array($t, $t);
	if (!@$_POST[$t='email'])
		$ea[] = array($t, $t);
	else if (!val_email($_POST[$t='email']))
		$ea[] = array($t, "i_{$t}");
	if (!@$_POST[$t='subject'])
		$ea[] = array($t, $t);
	if (!@$_POST[$t='message'])
		$ea[] = array($t, $t);
	else if (strlen($_POST[$t='message']) < 10)
		$ea[] = array($t, 's_msg');

	if (!count($ea))
	{
		$db->query("INSERT INTO c_req (c_ts, name, email, phone, subject, message, remote_addr)
					VALUES (%u, '%s', '%s', '%s', '%s', '%s', '%s')",
					time(), $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['subject'], $_POST['message'], $_SERVER['REMOTE_ADDR']);

		ob_start();
		require dirname(__FILE__).'/contact_email.inc.php';
		$msg = ob_get_contents();
		ob_end_clean();

		require dirname(__FILE__).'/../../libs/phpmailer/PHPMailerAutoload.php';

		$mail = new PHPMailer();
		$mail->CharSet = 'UTF-8';
		$mail->ContentType = 'text/plain';
		$mail->IsHTML(false);

		$mail->IsSMTP();
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Host = $sender['host'];
		$mail->Port = $sender['port'];
		$mail->Username = $sender['username'];
		$mail->Password = $sender['password'];

		$mail->AddReplyTo($_POST['email'], $_POST['name']);
		$mail->SetFrom("{$sender['email']}@{$sender['domain']}", $sender['name']);
		$mail->AddAddress($contact_info['email']);

		$mail->Subject = $_POST['subject'];
		$mail->Body = $msg;

		if (!$mail->Send()) $ea[] = array('main', 'f_send');

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