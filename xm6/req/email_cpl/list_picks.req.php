<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';
	require '../../../classes/class.bc.php';
	require '../../../classes/class.sub.php';
	
	$ss = bc::get_season('A');
	$week = bc::get_week($ss['year'], 'G');
	
	$pr_p = count(sub::get_picks($ss['year'], $week, 'probable'));
	$fi_p = count(sub::get_picks($ss['year'], $week, 'final'));
	$wk_p = count(sub::get_picks($ss['year'], $week, 'weekend'));
	$pow = count(sub::get_picks($ss['year'], $week, 'pow'));
	$best_p = count(sub::get_picks($ss['year'], $week, 'best_ko'));
?>
<table class="data1">
	<tr>
		<th class="lt">Probable picks</th>
		<td><?=$pr_p?></td>
		<th class="lt">Free POW</th>
		<td><?=$pow?></td>
	</th>
	<tr>
		<th class="lt">Final picks</th>
		<td><?=$fi_p?></td>
		<th class="lt">All @KO</th>
		<td><?=$fi_p?></td>
	</th>
	<tr>
		<th class="lt">Weekend preview</th>
		<td><?=$fi_p?></td>
		<th class="lt">Best @KO</th>
		<td><?=$best_p?></td>
	</th>
</tr>