<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';
	require '../../../classes/class.bc.php';
	require '../../../classes/class.sub.php';
	
	$type = @$_POST['t'];
	if (!in_array($type, array_keys(sub::$type_map)))
		die("Invalid type {$type}"); 
	$ss = bc::get_season('A');
	$week = bc::get_week($ss['year'], 'G');
	
	$picks = sub::get_picks($ss['year'], $week, $type);
	pp::games($picks);
	
	$subs = sub::get_subs($ss['year'], $week, $type, 1);
	
	$sids = db::choose($subs, 'sub_id');
	$qa = db::assoc($db->query("SELECT CONCAT_WS('_', sub_id, gids) k, status FROM m_q WHERE sub_id IN (%s) AND year = %u AND week = %u AND type = '%s'", $sids, $ss['year'], $week, $type));
?>
<div class="modal0">
	<div class="box1">
		<h2><a href="#" class="fr" act="close" reql="reql1"><i class="fa fa-close"></i></a><?=hsc(sub::$type_map[$type])?></h2>
		<table class="data1">
			<tr>
				<th class="lt">Email</th>
				<th class="lt">Name</th>
				<?php if ($type == 'all_ko') { ?>
				<th class="lt">Game ids</th>
				<?php } ?>
				<th>Status</th>
			</tr>
			<?php foreach ($subs as $r) { if (!@$r['gids']) $r['gids'] = ''; ?>
			<tr>
				<td><?=hsc($r['email'])?></td>
				<td><?=hsc($r['name'])?></td>
				<?php if ($type == 'all_ko') { ?>
				<td><?=$r['gids']?></td>
				<?php } ?>
				<td>
					<?php if (@$qa["{$r['sub_id']}_{$r['gids']}"] == 'Q') { ?>
					<i class="fa fa-hourglass-o"></i>
					<?php } else if (@$qa["{$r['sub_id']}_{$r['gids']}"] == 'S') { ?>
					<i class="fa fa-check"></i>
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>
</div>