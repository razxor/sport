<?php
	$t_now = time() + $time_offset;
	$all_fin = 1;
	foreach ($recs as $r)
		if ($r['status'] != 'F')
			$all_fin = 0;
?>
<div id="af" class="hide"><?=$all_fin?></div>
<?php if ($mobile_user) { ?>
<table class="data1">
	<thead>
		<tr>
			<th class="lta">Date</th>
			<th class="lta">Away</th>
			<th colspan="2">Score</th>
			<th class="rta">Home</th>
			<th class="lta">Pick</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($recs as $r) { ?>
		<tr>
			<td><?=D3($r['g_ts'])?></td>
			<td>
				<?php if ($r['pick'] == 'a' && $r['g_ts'] < $t_now) { ?>
				<b><?=hsc($r['v_team']['name2'])?></b>
				<?php } else { ?>
				<?=hsc($r['v_team']['name2'])?>
				<?php } ?>
				<?php if ($r['spread_f'] == 'a') { ?>(<?=$r['spread'] ? -$r['spread']/10 : 'even'?>)<?php } ?>
			</td>
			<td class="rta"><?php if ($r['g_ts'] < $t_now) { ?><span class="score"><?=$r['v_score']?></span><?php } else { ?><i class="fa fa-clock-o"></i><?php } ?></td>
			<td><?php if ($r['g_ts'] < $t_now) { ?><span class="score"><?=$r['h_score']?></span><?php } else { ?><i class="fa fa-clock-o"></i><?php } ?></td>
			<td class="rta">
				<?php if ($r['spread_f'] == 'h') { ?>(<?=$r['spread'] ? -$r['spread']/10 : 'even'?>)<?php } ?>
				<?php if ($r['pick'] == 'h' && $r['g_ts'] < $t_now) { ?>
				<b><?=hsc($r['h_team']['name2'])?></b>
				<?php } else { ?>
				<?=hsc($r['h_team']['name2'])?>
				<?php } ?>
			</td>
			<td>
				<?php if (!$r['pick']) { ?>
				<span class="note">Toss-up</span>
				<?php } else if ($r['g_ts'] > $t_now) { ?>
				<span class="note">Waiting for kick-off to reveal this game's pick</span>
				<?php } else if ($r['status'] == 'F') { $res = bc::pick_result($r); ?>
				<?php if ($res == 0) { ?>
				<i class="fa fa-fw fa-refresh"></i> Push
				<?php } else if ($res == -1) { ?>
				<i class="fa fa-fw fa-close"></i> Pick lost
				<?php } else { ?>
				<i class="fa fa-fw fa-check"></i> Pick won
				<?php } ?>
				<?php } else { ?>
				<?=hsc($r['pick'] == 'a' ? $r['v_team']['name2'] : $r['h_team']['name2'])?>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } else { ?>
<table class="data1">
	<thead>
		<tr>
			<th class="lta">Date</th>
			<th class="lta">Away team</th>
			<th colspan="2">Score</th>
			<th class="rta">Home team</th>
			<th class="lta">Pick</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($recs as $r) { ?>
		<tr>
			<td><?=DT($r['g_ts'])?></td>
			<td>
				<?php if ($r['pick'] == 'a' && $r['g_ts'] < $t_now) { ?>
				<b><?=hsc($r['v_team']['name2'])?></b>
				<?php } else { ?>
				<?=hsc($r['v_team']['name2'])?>
				<?php } ?>
				<?php if ($r['spread_f'] == 'a') { ?>(<?=$r['spread'] ? -$r['spread']/10 : 'even'?>)<?php } ?>
			</td>
			<td class="rta"><?php if ($r['g_ts'] < $t_now) { ?><span class="score"><?=$r['v_score']?></span><?php } else { ?><i class="fa fa-clock-o"></i><?php } ?></td>
			<td><?php if ($r['g_ts'] < $t_now) { ?><span class="score"><?=$r['h_score']?></span><?php } else { ?><i class="fa fa-clock-o"></i><?php } ?></td>
			<td class="rta">
				<?php if ($r['spread_f'] == 'h') { ?>(<?=$r['spread'] ? -$r['spread']/10 : 'even'?>)<?php } ?>
				<?php if ($r['pick'] == 'h' && $r['g_ts'] < $t_now) { ?>
				<b><?=hsc($r['h_team']['name2'])?></b>
				<?php } else { ?>
				<?=hsc($r['h_team']['name2'])?>
				<?php } ?>
			</td>
			<td>
				<?php if (!$r['pick']) { ?>
				<span class="note">Toss-up</span>
				<?php } else if ($r['g_ts'] > $t_now) { ?>
				<span class="note">Waiting for kick-off to reveal this game's pick</span>
				<?php } else if ($r['status'] == 'F') { $res = bc::pick_result($r); ?>
				<?php if ($res == 0) { ?>
				<i class="fa fa-fw fa-refresh"></i> Push
				<?php } else if ($res == -1) { ?>
				<i class="fa fa-fw fa-close"></i> Pick lost
				<?php } else { ?>
				<i class="fa fa-fw fa-check"></i> Pick won
				<?php } ?>
				<?php } else { ?>
				<?=hsc($r['pick'] == 'a' ? $r['v_team']['name2'] : $r['h_team']['name2'])?>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>
