<?php
	$ss = bc::get_season('P');
	$recg = $db->query("SELECT * FROM games WHERE year = %u AND status = 'F' ORDER BY g_ts DESC LIMIT 8", $ss['year']);
	pp::games($recg);
?>
<h2 class="alt1">Scoreboard</h2>
<div class="box2">
	<table class="lst2">
		<tbody>
			<?php foreach ($recg as $k=>$r) { ?>
			<?php if (!$k || D2($r['g_ts']) != D2($recg[$k - 1]['g_ts'])) { ?>
			<tr>
				<th colspan="7">
					<div class="fr"><?=D2($r['g_ts'])?></div>
					<?php if (0) { ?>
					<?=hsc($r['v_team']['name2'])?> at <?=hsc($r['h_team']['name2'])?>
					<?php } ?>
				</th>
			</tr>
			<?php } ?>
			<tr>
				<td><img src="<?=$r['v_team_img']?>" /></td>
				<td><?=hsc($r['v_team']['code2'] ? $r['v_team']['code2'] : $r['v_team']['code'])?></td>
				<td class="rta"><b><?=$r['v_score']?></b></td>
				<td class="cta">-</td>
				<td><b><?=$r['h_score']?></b></td>
				<td class="rta"><?=hsc($r['h_team']['code2'] ? $r['h_team']['code2'] : $r['h_team']['code'])?></td>
				<td class="rta"><img src="<?=$r['h_team_img']?>" /></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>