<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';
	require '../../../classes/class.bc.php';
	
	$ss = bc::get_season('A');
	$p_week = bc::get_week($ss['year'], 'P');
	$g_week = bc::get_week($ss['year'], 'G');
?>
<table class="data1">
	<tr>
		<th class="lt">Date / time</th>
		<td><?=DT(time() + $time_offset)?></td>
	</tr>
	<tr>
		<th class="lt">Season</th>
		<td><?=$ss['year']?></td>
	</tr>
	<tr>
		<th class="lt">Purchase week</th>
		<td><?=$p_week?></td>
	</tr>
	<tr>
		<th class="lt">Game week</th>
		<td><?=$g_week?></td>
	</tr>
</table>