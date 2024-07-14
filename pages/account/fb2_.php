<?php
	$bt = '/account/';
	if (@$_SESSION['bt'])
	{
		$pu = parse_url($_SESSION['bt']);
		$bt = @$pu['path'];
	}

	require 'classes/class.user.php';
	require 'libs/facebook/php-graph-sdk/src/Facebook/autoload.php';
	
	$fb = new Facebook\Facebook(['app_id' => $fb_app_id, 'app_secret' => $fb_secret, 'default_graph_version' => 'v2.5']);
	
	$helper = $fb->getRedirectLoginHelper();
	
	try
	{
		$accessToken = $helper->getAccessToken();
	}
	catch (Facebook\Exceptions\FacebookResponseException $e)
	{
		echo "<PRE>";var_dump($e);die();
		user::die_login("err={$sub}");
	}
	catch (Facebook\Exceptions\FacebookSDKException $e)
	{
		//echo "<PRE>";var_dump($e);die();
		user::die_login("err={$sub}");
	}
	
	try
	{
		$response = $fb->get('/me?fields=id,name,verified,email', $accessToken);
	}
	catch (Facebook\Exceptions\FacebookResponseException $e)
	{
		//echo "<PRE>";var_dump($e);die();
		user::die_login("err={$sub}");
	}
	catch (Facebook\Exceptions\FacebookSDKException $e)
	{
		//echo "<PRE>";var_dump($e);die();
		user::die_login("err={$sub}");
	}
	
	$fb_info = $response->getGraphUser();
	if (!$fb_info['id'] || !$fb_info['email'] || !$fb_info['name'])
	{
		//echo "<PRE>";var_dump($e);die();
		user::die_login("err={$sub}");
	}
	
	$usr = new user();
	
	$t_usr = db::first($db->query("SELECT * FROM users WHERE fb_id = '%s'", $fb_info['id']));
	if (!$t_usr)
		$t_usr = db::first($db->query("SELECT * FROM users WHERE email = '%s'", $fb_info['email']));
	
	if ($t_usr)
	{
		if (!$usr->login_raw($t_usr['user'], $t_usr['pass'], 1))
		{
			user::die_login("err={$sub}");
		}
		else
		{
			if ($t_usr['fb_id'] != $fb_info['id'])
				$db->query("UPDATE users SET fb_id = '%s' WHERE user_id = %u", $fb_info['id'], $t_usr['user_id']);

			header("Location: {$url_proto}://{$maindw}{$bt}");
			die();
		}
	}
	else
	{
		srand(time());
		$password = rand(100,999).rand(100,999).rand(100,999).rand(100,999).rand(1,999);
		$name = $fb_info['name'];
		$email = $fb_info['email'];
		
		$login = preg_replace("/[^\w]+/", '', $fb_info['name']);
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
						(c_ts, user, email, pass, name, fb_id, active, u_ch)
						VALUES (%u, '%s', '%s', '%s', '%s', '%s', %u, %u)",
						time(), $login, $email, phash($password), $name, $fb_info['id'], 1, 1);
		$user_id = $db->insert_id();
		$usr->login($login, $password, 1);
		
		header("Location: {$url_proto}://{$maindw}{$bt}");
		die();
	}
?>