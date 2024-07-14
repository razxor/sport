<?php
	$tbl = 'subs';
	$pk = 'sub_id';
	
	$sub_opts = array('a' => 'All picks', 'b' => 'Best pick', 'y' => 'Season', 'w' => 'Week');
	
	if ($usr->p['role_id'] != 1)
		die('NLI');
?>