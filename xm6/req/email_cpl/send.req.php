<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require '../../../classes/class.bc.php';
	require '../../../classes/class.sub.php';
	require 'common.inc.php';
	
	$_POST = trim_r($_POST);
	$mode = @$_POST['mode'];
	$t = @$_POST['t'];
	$ea = array();
	
	$type = @$_POST['t'];
	if (!in_array($type, array_keys(sub::$type_map)))
		die("Invalid type {$type}"); 
	
	if (!count($ea))
	{
		$ss = bc::get_season('A');
		$week = bc::get_week($ss['year'], 'G');
		$picks = sub::get_picks($ss['year'], $week, $type);
		pp::games($picks);
		if (!count($picks))
			$ea[] = array('picks', 'picks');
	}
		
	if (!count($ea))
	{
		require dirname(__FILE__).'/../../../libs/phpmailer/PHPMailerAutoload.php';
		
		$data = $usr->p;
		
		$data['year'] = $ss['year'];
		$data['week'] = $week;
		$data['picks'] = $picks;
		
		if ($mode == 'T')
			sub::send_one($t, $data);
		if ($mode == 'L')
			sub::queue_all($t);
		
		$ret = array('ea' => array());
		header('Content-Type: application/json');
		echo json_encode($ret);
	}
	else
	{
		$ret = array('ea' => $ea);
		header('Content-Type: application/json');
		echo json_encode($ret);
	}
?>