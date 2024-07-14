<?php
	require '../../inc/global.inc.php';
	require '../../classes/class.user.php';
	$usr = new user();
	
	$_POST = array_map('trim', $_POST);
	$ea = array();
	
	if (!$usr->logged_in())
		$ea[] = array('login', 'login');
	
	$opt = @$_POST[$t='opt'];
	if (!in_array($opt, array('a', 'b')))
		$opt = '';
	
	if (!count($ea))
	{
		$sub_id = db::one($db->query("SELECT sub_id FROM subs WHERE email = '%s'", $usr->p['email']));
		if (!$sub_id)
		{
			$msg = 'added';
			$db->query("INSERT INTO subs (c_ts, email, user_id) VALUES (%u, '%s', %u)", time(), $usr->p['email'], $usr->p['user_id']);
			$sub_id = $db->insert_id();
		}
		
		$ss = bc::get_season('N');
		$year = $ss['year'];
		$db->query("UPDATE subs SET wknd = %u, pow = %u, opt = '%s', year = %u WHERE sub_id = %u", $_POST['wknd'], $_POST['pow'], $opt, $year, $sub_id);
		
		$ret = array('status' => 1);
	}
	else
	{
		$ret = array('status' => -1, 'ea' => $ea);
	}
	
	header('Content-Type: application/json');
	echo json_encode($ret);
?>