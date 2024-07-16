<?php
	require '../../inc/global.inc.php';
	
	$ss = bc::get_season('P');
	$game_week = bc::get_week($ss['year'], 'G');
	$week = (int)@$_GET['w'];
	
	$needs_refresh = (int)($game_week == $week);
	
	$recs = $db->query("SELECT * FROM games WHERE year = %u AND week = %u ORDER BY game_id ASC", $ss['year'], $week);
	pp::games($recs);
	
	require '../../pages/season-results/frag/gl1.inc.php';
?>
<div id="x_wk" class="hide"><?=bc::wk_name($week)?></div>