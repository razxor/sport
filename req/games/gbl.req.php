<?php
	require '../../inc/global.inc.php';
	$year = 0;
	$week = 0;
	if (count($a = explode('.', @$_GET['wk'])) == 2 && is_numeric($a[0]) && is_numeric($a[1]))
		list($year, $week) = $a;
	
	$recs = $db->query("SELECT * FROM games WHERE year = %u AND week = %u ORDER BY game_id ASC", $year, $week);
	pp::games($recs);
	
	require '../../pages/resources/frag/gbl1.inc.php';
?>