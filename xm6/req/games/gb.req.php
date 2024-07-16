<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';
	
	$id = @$_GET['id'];
	
	$recs = $db->query("SELECT * FROM `%s` WHERE `%s` = %u", $tbl, $pk, $id);
	pp::games($recs);
	
	if (!count($recs))
		die('Item not found');
	
	$r = $recs[0];
	if (!$r['gb_link'])
		die('No gamebook');
	
	if (!is_file($r['gb_f']))
		die('No gamebook file');
	
	$fn = "{$r['year']}-wk{$r['week']}-{$r['v_team']['code']}-{$r['h_team']['code']}-{$r['code']}-{$r['game_id']}.pdf";
		
	header("Content-Type: application/pdf");
	header("Content-Disposition: attachment; filename=\"{$fn}\"");
	readfile($r['gb_f']);
?>