<?php
	$t_now = time();
?>
<table class="data1">
	<thead>
		<tr>
			<th class="lta">Date</th>
			<th class="lta">Away team</th>
			<th colspan="2">Score</th>
			<th class="rta">Home team</th>
			<th class="lta">Your Pick</th>
			<th class="lta">BCW Pick</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($recs as $k=>$r) { $or = $o_recs[$k]; ?>
		<?php
			if (!$r['pick'] || !$or['pick'] || $r['pick'] == $or['pick'])
				continue;
		?>
		<tr>
			<td><?=DT($r['g_ts'])?></td>
			<td>
				<?=hsc($r['v_team']['name2'])?>
				<?php if ($or['spread_f'] == 'a' && $r['spread_f'] == $or['spread_f'] && $r['spread'] == $or['spread']) { ?>(<?=$or['spread'] ? -$or['spread']/10 : 'even'?>)<?php } ?>
			</td>
			<td class="rta"><?php if ($r['g_ts'] < $t_now) { ?><span class="score"><?=$r['v_score']?></span><?php } ?></td>
			<td><?php if ($r['g_ts'] < $t_now) { ?><span class="score"><?=$r['h_score']?></span><?php } ?></td>
			<td class="rta">
				<?php if ($or['spread_f'] == 'h' && $r['spread_f'] == $or['spread_f'] && $r['spread'] == $or['spread']) { ?>(<?=$or['spread'] ? -$or['spread']/10 : 'even'?>)<?php } ?>
				<?=hsc($r['h_team']['name2'])?>
			</td>
			<td>
				<?=hsc($r['pick'] == 'a' ? $r['v_team']['name2'] : $r['h_team']['name2'])?>
				
				<?php if ($r['spread_f'] != $or['spread_f'] || $r['spread'] != $or['spread']) { ?>
				(<?=$r['spread'] ? (($r['spread_f'] == $r['pick'] ? '-' : '+').($r['spread']/10)) : 'even'?>)
				<?php } ?>
				
				<?php if ($r['status'] != 'F') { ?>
				<i class="fa fa-clock"></i>
				<?php } else if ($r['status'] == 'F') { $res = bc::pick_result($r); ?>
				<?php if ($res == 0) { ?>
				<i class="fa fa-fw fa-refresh"></i>
				<?php } else if ($res == -1) { ?>
				<i class="fa fa-fw fa-close"></i>
				<?php } else { ?>
				<i class="fa fa-fw fa-check"></i>
				<?php } ?>
				<?php } ?>
			</td>
			<td>
				<?=hsc($or['pick'] == 'a' ? $r['v_team']['name2'] : $r['h_team']['name2'])?>
				
				<?php if ($r['spread_f'] != $or['spread_f'] || $r['spread'] != $or['spread']) { ?>
				(<?=$or['spread'] ? (($or['spread_f'] == $or['pick'] ? '-' : '+').($or['spread']/10)) : 'even'?>)
				<?php } ?>
				
				<?php if ($r['status'] != 'F') { ?>
				<i class="fa fa-clock"></i>
				<?php } else if ($r['status'] == 'F') { $res = bc::pick_result($or); ?>
				<?php if ($res == 0) { ?>
				<i class="fa fa-fw fa-refresh"></i>
				<?php } else if ($res == -1) { ?>
				<i class="fa fa-fw fa-close"></i>
				<?php } else { ?>
				<i class="fa fa-fw fa-check"></i>
				<?php } ?>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>