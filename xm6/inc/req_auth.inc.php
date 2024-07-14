<?php
	if (!$usr->logged_in() || !in_array($usr->p['role_id'], array(1)))
	{
		$u = @$_SERVER['PHP_AUTH_USER'];
		$p = @$_SERVER['PHP_AUTH_PW'];
		if (!$usr->login($u, $p))
		{
			header('WWW-Authenticate: Basic realm="BCW"');
			header('HTTP/1.0 401 Unauthorized');
			die('NLI');
		}
		header('WWW-Authenticate: Basic realm="BCW"');
		header('HTTP/1.0 401 Unauthorized');
		die('NLI');
	}
?>