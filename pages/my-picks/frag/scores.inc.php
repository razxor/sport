<?php
	$t_now = time() + $time_offset;
?>
<?php if (!count($recs)) { ?>
<div class="infoc">You don't have any picks for the selected week</div>
<?php } else { ?>
<table class="data1<?php if ($mobile_user) { ?> w100<?php } ?>">
	<thead>
		<tr>
			<th class="lta">Away<?php if (!$mobile_user) { ?> team<?php } ?></th>
			<th class="rta">Home<?php if (!$mobile_user) { ?> team<?php } ?></th>
			<th class="cta" colspan="2">Score</th>
			<th class="cta">Result</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($recs as $k=>$r) { ?>
		<?php
			$p_res = false;
			if ($r['pick'] && $r['status'] == 'F')
				$p_res = bc::pick_result($r);
			
		?>
		<?php if (!$k || (DT($r['g_ts']) != DT($recs[$k-1]['g_ts']))) { ?>
		<tr>
			<td colspan="5" class="note"><?=DT($r['g_ts'])?></td>
		</tr>
		<?php } ?>
		<tr>
			<td<?php if ($r['pick'] == 'a') { ?> class="picked"<?php } ?>>
				<?=hsc($mobile_user ? $r['v_team']['code'] : $r['v_team']['name2'])?>
				<?php if ($r['spread_f'] == 'a') { ?>(<?=$r['spread'] ? -$r['spread']/10 : 'even'?>)<?php } ?>
			</td>
			<td class="rta<?php if ($r['pick'] == 'h') { ?> picked<?php } ?>">
				<?php if ($r['spread_f'] == 'h') { ?>(<?=$r['spread'] ? -$r['spread']/10 : 'even'?>)<?php } ?>
				<?=hsc($mobile_user ? $r['h_team']['code'] : $r['h_team']['name2'])?>
			</td>
			<td class="rta" id="vs_<?=$r['game_id']?>"><?php if ($r['g_ts'] < $t_now) { ?><span class="score"><?=$r['v_score']?><?php } else { ?><i class="fa fa-clock-o"></i><?php } ?></span></td>
			<td id="hs_<?=$r['game_id']?>"><?php if ($r['g_ts'] < $t_now) { ?><span class="score"><?=$r['h_score']?><?php } else { ?><i class="fa fa-clock-o"></i><?php } ?></span></td>
			<td id="rr_<?=$r['game_id']?>">
				<?php if ($p_res === 0) { ?>
				<i class="fa fa-fw fa-refresh"></i> Push
				<?php } else if ($p_res == -1) { ?>
				<i class="fa fa-fw fa-close"></i> Loss
				<?php } else if ($p_res === 1) { ?>
				<i class="fa fa-fw fa-check"></i> Win
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>