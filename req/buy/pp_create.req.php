<?php
	require '../../inc/global.inc.php';
	require '../../classes/class.user.php';
	require '../../classes/class.paypal.php';
	require '../../libs/PayPal-PHP-SDK/autoload.php';
	$_POST = array_map('trim', $_POST);
	$ea = array();
	
	$opt = $_POST[$t='opt'];
	if (!in_array($opt, array('w', 'y')))
		$opt = '';
	if (!$opt)
		$ea[] = array($t, $t);
	if (!@$_POST[$t='email'])
		$ea[] = array($t, $t);
	else if (!val_email($_POST[$t='email']))
		$ea[] = array($t, "i_{$t}");
	
	if (!count($ea))
	{
		$ss = bc::get_season('N');
		$year = $ss['year'];
		$week = bc::get_week($year, 'P');
		
		if ($opt == 'y' && count($db->query("SELECT order_id FROM orders WHERE email = '%s' AND opt = 'y' AND year = %u AND status = 'C' LIMIT 1", $_POST['email'], $year)))
			$ea[] = array('opt', 'dup_year');
		else if ($opt == 'w' && count($db->query("SELECT order_id FROM orders WHERE email = '%s' AND opt = 'y' AND year = %u AND status = 'C' LIMIT 1", $_POST['email'], $year)))
			$ea[] = array('opt', 'dup_year');
		else if ($opt == 'w' && count($db->query("SELECT order_id FROM orders WHERE email = '%s' AND opt = 'w' AND year = %u AND week = %u AND status = 'C' LIMIT 1", $_POST['email'], $year, $week)))
			$ea[] = array('opt', 'dup_week');
	}
	
	if (!count($ea))
	{
		$usr = new user();
		$payment = paypal::create($_POST);
		$ret = array('status' => 1, 'paymentID' => $payment->getId());
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