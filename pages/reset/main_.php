<?php
	$meta['title'] = 'Password reset';
	$meta['robots'] = 'noindex,nofollow';
	
	$EMSG[10] = 'Invalid password reset link';
	$EMSG[20] = 'Invalid password reset link';
	
	$em = 0;
	$rec = db::first($db->query("SELECT * FROM reset_r WHERE MD5(entry_id) = '%s'", $a[1]));
	if (!$rec)
		$em = 10;
	
	if (!$em)
	{
		$us = db::first($db->query("SELECT user_id, user FROM users WHERE user_id = %u", $rec['user_id']));
		if (!$us)
			$em = 10;
	}
	
	if (!$em)
	{
		if ($rec['x1'] != $a[2] || $rec['x2'] != $a[3])
			$em = 20;
	}
	
	if (!$em)
		$JS[] = '/js/reset.js';
?>