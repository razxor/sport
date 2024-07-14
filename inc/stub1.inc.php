<?php
	$ru = strtolower(trim($_SERVER['REQUEST_URI'], '/ '));
	$b = explode('?', $ru);
	$a = explode('/', $b[0]);

	if (in_array($a[0], array('resources', 'season-results', 'disclaimer', 'privacy', 'terms', 'refunds', 'live-demo', 'account', 'my-picks', 'contact', 'purchases', 'free-stuff', 'unsub3')))
	{
		$page = $a[0];
	}
	else if ($a[0] == 'fb-connect')
	{
		$page = 'account';
		$sub = 'fbc';
	}
	else if ($a[0] == 'gp-connect')
	{
		$page = 'account';
		$sub = 'gpc';
	}
	else
	{
		header("HTTP/1.0 404 Not Found");
	}
?>