<?php
	$ss = bc::get_season('P');
	$meta['title'] = "{$ss['year']} Season results";
	$meta['canonical'] = '/season-results/';
	$meta['description'] = "Check out our overall record and all of our winning picks against the spread for the {$ss['year']} NFL season.";
	$JS[] = '/js/season-results.js';
	
	$recs_bc = bc::season_results_bc($ss['year']);
	$stats_bc = bc::season_result_stats($recs_bc);
?>