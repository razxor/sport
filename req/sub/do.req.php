<?php
	require '../../inc/global.inc.php';
	require '../../classes/class.user.php';
	$usr = new user();
	$_POST = array_map('trim', $_POST);
	$ea = array();
	
	$opt = @$_POST[$t='opt'];
	if (!in_array($opt, array('a', 'b')))
		$opt = '';

	if (!@$_POST[$t='email'])
		$ea[] = array($t, $t);
	else if (!val_email($_POST[$t='email']))
		$ea[] = array($t, "i_{$t}");

	$_POST['email'] = strtolower($_POST['email']);
		
	if (!count($ea))
	{
		$msg = 'saved';
		$sub_id = db::one($db->query("SELECT sub_id FROM subs WHERE email = '%s'", $_POST['email']));
		if (!$sub_id)
		{
			$msg = 'added';
			$db->query("INSERT INTO subs (c_ts, email, user_id) VALUES (%u, '%s', %u)", time(), $_POST['email'], @$usr->p['user_id']);
			$sub_id = $db->insert_id();
		}
		
		$ss = bc::get_season('N');
		$year = $ss['year'];
		$db->query("UPDATE subs SET wknd = %u, pow = %u, opt = '%s', year = %u WHERE sub_id = %u", $_POST['wknd'], $_POST['pow'], $opt, $year, $sub_id);
		
		if (!@$_POST['wknd'] && !@$_POST['pow'] && !@$_POST['opt'])
			$msg = 'unsub';
		
		$ret = array('status' => 1, 'msg' => $msg);
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