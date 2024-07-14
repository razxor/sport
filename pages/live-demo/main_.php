<?php
	$meta['title'] = "Live Demo";
	$meta['canonical'] = '/live-demo/';
	$meta['description'] = "Verify our winning NFL picks against the spread by viewing our picks free of charge at kickoff for as many weeks as desired";
	
	$ss = bc::get_season('P');
	$last_week = db::one($db->query("SELECT week FROM games WHERE year = %u AND pick != '' AND pick_mod != 'p' ORDER BY year DESC, week DESC LIMIT 1", $ss['year']));
	$sel_week = bc::get_week($ss['year'], 'G');
	$recs = $db->query("SELECT * FROM games WHERE year = %u AND week = %u ORDER BY game_id ASC", $ss['year'], $sel_week);
	pp::games($recs);
	
	$JS[] = '/js/live-demo.js';
?>