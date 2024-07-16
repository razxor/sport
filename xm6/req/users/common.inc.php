<?php
	$tbl = 'users';
	$pk = 'user_id';
	
	$_ROLES = array(
		1 => array('name' => 'Administrator'),
	);
	
	if ($usr->p['role_id'] != 1)
		die('NLI');
?>