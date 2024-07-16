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
	
	require dirname(__FILE__).'/../../libs/google-api-php-client-master/src/Google/autoload.php';
	
	$client = new Google_Client();
	$client->setClientId($gg_client_id);
	$client->setClientSecret($gg_secret);
	$client->setRedirectUri("{$url_proto}://{$maindw}/index.php?page={$page}&sub=gp2");
	$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile', 'https://www.googleapis.com/auth/user.phonenumbers.read'));
	$login_url = $client->createAuthUrl();
	
	header("Location: {$login_url}");
	die();
?>