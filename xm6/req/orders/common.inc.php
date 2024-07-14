<?php
	$tbl = 'orders';
	$pk = 'order_id';
	
	$order_statuses = array('C' => 'Complete', 'V' => 'Voided');
	$order_opts = array('y' => 'Season', 'w' => 'Week');
	
	if ($usr->p['role_id'] != 1)
		die('NLI');
?>