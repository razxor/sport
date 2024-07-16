<?php
	$ru = strtolower(trim($_SERVER['REQUEST_URI'], '/ '));
	$b = explode('?', $ru);
	$a = explode('/', $b[0]);

	if ($a[0] == 'account' && in_array($a[1], array('edit', 'access', 'logout', 'mailing')))
	{
		$page = $a[0];
		$sub = $a[1];
	}
	else if ($a[0] == 'my-picks' && in_array($a[1], array('results', 'scores')))
	{
		$page = $a[0];
		$sub = $a[1];
	}
	else if ($a[0] == 'purchases' && in_array($a[1], array('complete')))
	{
		$page = $a[0];
		$sub = $a[1];
	}
	else
	{
		header("HTTP/1.0 404 Not Found");
	}
?>