<?php
	require '../../inc/global.inc.php';
	require '../../classes/class.paypal.php';
	require '../../classes/class.sub.php';
	require '../../libs/phpmailer/PHPMailerAutoload.php';
	require '../../libs/PayPal-PHP-SDK/autoload.php';
	$_POST = array_map('trim', $_POST);
	$ea = array();
	
	$payment = paypal::execute($_POST);
	if ($payment->getState() == 'approved')
		paypal::insert_order($payment);
	else
		$ea[] = array('main', 'payment');
	
	if (!count($ea))
	{
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