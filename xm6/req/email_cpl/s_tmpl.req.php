<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';

	$_POST = trim_r($_POST);
	$fn = @$_POST['fn'];
	$ea = array();

	$of = realpath(dirname(__FILE__).'/../../../tmpl/'.basename($fn));
	if (!is_file($of))
		die("File {$of} not found");
	
	$cont = file_get_contents($of);
		
	if (!count($ea))
	{
		$changed = $cont != $_POST['cont'];
		if ($changed)
		{
			$bf = dirname(__FILE__).'/../../../tmpl/bk_'.basename($fn);
			copy($of, $bf);
			file_put_contents($of, $_POST['cont']);
		}
		
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