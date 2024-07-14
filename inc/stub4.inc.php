<?php
	$ru = strtolower(trim($_SERVER['REQUEST_URI'], '/ '));
	$b = explode('?', $ru);
	$a = explode('/', $b[0]);

	if ($a[0] == 'reset' && is_numeric($a[2]) && is_numeric($a[3]))
	{
		$page = $a[0];
	}
	else if (count($res = $db->query("SELECT * FROM redirects WHERE from_url = '%s'", rtrim($b[0], '/'))))
	{
		$rd = $res[0];
		header("Location: {$url_proto}://{$maindw}{$rd['to_url']}", true, $rd['http_code']);
		die();
	}
	else
	{
		header("HTTP/1.0 404 Not Found");
	}
?>