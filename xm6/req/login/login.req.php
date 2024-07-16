<?php
	require '../../inc/global.inc.php';

	$_POST = trim_r($_POST);

	$ea = array();

	if (!strlen(@$_POST[$t='user']))
		$ea[] = array($t, $t);
	if (!strlen(@$_POST[$t='pass']))
		$ea[] = array($t, $t);
	if (!$usr->login($_POST[$t='user'], $_POST['pass'], $_POST['keep']) || !in_array($usr->p['role_id'], array(1)))
		$ea[] = array($t, 'fail');

	if (!count($ea))
	{
		$ret = array('ea' => array());
		echo json_encode($ret);
	}
	else
	{
		$ret = array('ea' => $ea);
		echo json_encode($ret);
	}
?>