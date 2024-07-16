<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';

	$_POST = trim_r($_POST);
	$ea = array();

	if (!strlen(@$_POST[$t='txt']))
		$ea[] = array($t, $t);
	
	if (!count($ea))
	{
		$ret = process_pick_data($_POST['txt'], $ea2);
		if (!$ret)
			$ea[] = array('main', 'proc');
	}
		
	if (!count($ea))
	{
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