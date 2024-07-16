<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';

	$_POST = trim_r($_POST);
	$ea = array();

	if (!strlen(@$_POST[$t='subj']))
		$ea[] = array($t, $t);
	if (!strlen(@$_POST[$t='msg']))
		$ea[] = array($t, $t);
	
	if (!count($ea))
	{
		
	}
		
	if (!count($ea))
	{
		require dirname(__FILE__).'/../../../libs/phpmailer/PHPMailerAutoload.php';
		
		$recs = $db->query("SELECT email FROM users");
		foreach ($recs as $r)
		{
			$r['msg'] = $_POST['msg'];
			send_email('mass', $r, $_POST['subj']);
			sleep(2);
		}
		
		$ret = array('ea' => array());
		header('Content-Type: application/json');
		echo json_encode($ret);
	}
	else
	{
		ob_start();
		require 'paste_estr.inc.php';
		$estr = ob_get_contents();
		ob_end_clean();
		
		$ret = array('ea' => $ea, 'estr' => $estr);
		header('Content-Type: application/json');
		echo json_encode($ret);
	}
?>