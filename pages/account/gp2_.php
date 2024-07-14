<?php
	$bt = '/account/';
	if (@$_SESSION['bt'])
	{
		$pu = parse_url($_SESSION['bt']);
		$bt = @$pu['path'];
	}
	
	require 'classes/class.user.php';
	require dirname(__FILE__).'/../../libs/google-api-php-client-master/src/Google/autoload.php';
	
	$client = new Google_Client();
	$client->setApplicationName('DepozitAuto');
	$client->setClientId($gg_client_id);
	$client->setClientSecret($gg_secret);
	$client->setRedirectUri("{$url_proto}://{$maindw}/index.php?page={$page}&sub=gp2");
	$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile'));
	$plus = new Google_Service_Oauth2($client);
	
	try
	{
		$client->authenticate(@$_GET['code']);
	}
	catch (Google_Auth_Exception $e)
	{
		//echo "<PRE>";var_dump($e);die();
		user::die_login("err={$sub}");
	}
	
	try
	{
		$token_data = $client->verifyIdToken()->getAttributes();
	}
	catch (Exception $e)
	{
		//echo "<PRE>";var_dump($e);die();
		user::die_login("err={$sub}");
	}
	
	$email = $token_data['payload']['email'];
	$gp_id = $token_data['payload']['sub'];
	
	try
	{
		$userinfo = $plus->userinfo->get();
	}
	catch (Exception $e)
	{
		//echo "<PRE>";var_dump($e);die();
		user::die_login("err={$sub}");
	}
	
	$name = $userinfo['name'];
	
	if (!$gp_id || !$email || !$name)
	{
		//echo "<PRE>";var_dump($e);die();
		user::die_login("err={$sub}");
	}
	
	$usr = new user();
	
	$t_usr = db::first($db->query("SELECT * FROM users WHERE gp_id = '%s'", $gp_id));
	if (!$t_usr)
		$t_usr = db::first($db->query("SELECT * FROM users WHERE email = '%s'", $email));
	
	if ($t_usr)
	{
		if (!$usr->login_raw($t_usr['user'], $t_usr['pass'], 1))
		{
			user::die_login("err={$sub}");
		}
		else
		{
			if ($t_usr['gp_id'] != $gp_id)
				$db->query("UPDATE users SET gp_id = '%s' WHERE user_id = %u", $gp_id, $t_usr['user_id']);

			header("Location: {$url_proto}://{$maindw}{$bt}");
			die();
		}
	}
	else
	{
		srand(time());
		$password = rand(100,999).rand(100,999).rand(100,999).rand(100,999).rand(1,999);
		
		$login = preg_replace("/[^\w]+/", '', $name);
		if (!$login)
		{
			$a = explode('@', $email);
			$login = $a[0];
		}

		$k = 0;

		while (count($db->query("SELECT user_id FROM users WHERE user = '%s' LIMIT 1", $login.($k ? $k : ''))))
			$k++;

		$login = $login.($k ? $k : '');
		
		$db->query("INSERT INTO users
						(c_ts, user, email, pass, name, gp_id, active, u_ch)
						VALUES (%u, '%s', '%s', '%s', '%s', '%s', %u, %u)",
						time(), $login, $email, phash($password), $name, $gp_id, 1, 1);
		$user_id = $db->insert_id();
		$usr->login($login, $password, 1);
		
		header("Location: {$url_proto}://{$maindw}{$bt}");
		die();
	}
?>