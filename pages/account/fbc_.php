<?php
	$bt = '/account/';
	if (@$_SERVER['HTTP_REFERRER'])
	{
		$pu = parse_url($_SERVER['HTTP_REFERRER']);
		$bt = @$pu['path'];
	}
	if (@$_GET['bt'])
	{
		$pu = parse_url($_GET['bt']);
		$bt = @$pu['path'];
	}

	$_SESSION['bt'] = $bt;
	require 'libs/facebook/php-graph-sdk/src/Facebook/autoload.php';
	
	$fb = new Facebook\Facebook(['app_id' => $fb_app_id, 'app_secret' => $fb_secret, 'default_graph_version' => 'v2.5']);
	
	$helper = $fb->getRedirectLoginHelper();
	$permissions = ['email'];
	$login_url = $helper->getLoginUrl("{$url_proto}://{$maindw}/index.php?page={$page}&sub=fb2", $permissions);
	
	header("Location: {$login_url}");
	die();
?>