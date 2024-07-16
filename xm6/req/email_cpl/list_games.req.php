<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';
	require '../../../classes/class.bc.php';
	require '../../../classes/class.sub.php';
	
	$ss = bc::get_season('A');
	$week = bc::get_week($ss['year'], 'G');
	
	$recs = $db->query("SELECT * FROM games WHERE year = %u AND week = %u AND pick != ''", $ss['year'], $week);
	pp::games($recs);
	
	$pr_p = sub::get_picks($ss['year'], $week, 'probable');
	$fi_p = sub::get_picks($ss['year'], $week, 'final');
	$wk_p = sub::get_picks($ss['year'], $week, 'weekend');
	$pow = sub::get_picks($ss['year'], $week, 'pow');
	$best_p = sub::get_picks($ss['year'], $week, 'best_ko');
?>
<table class="data1">
	<?php foreach ($recs as $r) { ?>
	<tr>
		<td><?=DT($r['g_ts'])?></td>
		<td><?=hsc($r['v_team']['name2'])?><?php if ($r['spread_f'] == 'a') { ?> (<?=-$r['spread']/10?>)<?php } ?></td>
		<td class="rt"><?=$r['v_score']?></td>
		<td><?=$r['h_score']?></td>
		<td><?php if ($r['spread_f'] == 'h') { ?>(<?=-$r['spread']/10?>) <?php } ?> <?=hsc($r['h_team']['name2'])?></td>
		<td class="ct"><?=$r['pick']?><?=$r['pick_mod']?></td>
		<td>
			<?php if (in_array($r['game_id'], db::choose($pr_p, 'game_id'))) { ?><span class="btn1 small">Probable</span><?php } ?>
			<?php if (in_array($r['game_id'], db::choose($fi_p, 'game_id'))) { ?><span class="btn1 small">Final</span><?php } ?>
			<?php if (in_array($r['game_id'], db::choose($wk_p, 'game_id'))) { ?><span class="btn1 small">Weekend preview</span><?php } ?>
			<?php if (in_array($r['game_id'], db::choose($pow, 'game_id'))) { ?><span class="btn1 small">Free POW</span><?php } ?>
			<?php if (in_array($r['game_id'], db::choose($fi_p, 'game_id'))) { ?><span class="btn1 small">All @KO</span><?php } ?>
			<?php if (in_array($r['game_id'], db::choose($best_p, 'game_id'))) { ?><span class="btn1 small">Best @KO</span><?php } ?>
		</td>
	</tr>
	<?php } ?>
</table>