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
	
	$picks = sub::get_picks($ss['year'], $week, $type, 1);
	pp::games($picks);
	
	$subs = sub::get_subs($ss['year'], $week, $type, 1);
	$max = 10;
	$cnt_more = 0;
	if (count($subs) > $max)
	{
		$cnt_more = count($subs) - $max;
		$subs = array_slice($subs, 0, $max);
	}
	
	$sids = db::choose($subs, 'sub_id');
	if ($type == 'all_ko')
		$qa = db::assoc($db->query("SELECT CONCAT_WS('_', sub_id, gids) k, status FROM m_q WHERE sub_id IN (%s) AND year = %u AND week = %u AND type = '%s'", $sids, $ss['year'], $week, $type));
	else
		$qa = db::assoc($db->query("SELECT CONCAT_WS('_', sub_id, '') k, status FROM m_q WHERE sub_id IN (%s) AND year = %u AND week = %u AND type = '%s'", $sids, $ss['year'], $week, $type));
?>
<div class="box1">
	<h2><?=hsc(sub::$type_map[$type])?></h2>
	<a class="btn1" href="#" act="send" mode="T" t="<?=$type?>"><i class="fa fa-send"></i>Test</a>
	<?php if (!in_array($type, array('all_ko', 'best_ko'))) { ?>
	<a class="btn1 alt2" href="#" act="send" mode="L" t="<?=$type?>"><i class="fa fa-send"></i>Live</a>
	<?php }?>
	<a class="btn1" href="#" act="e_tmpl" fn="sub_<?=$type?>_email.inc.php"><i class="fa fa-pencil"></i>Edit</a>
	<div class="err" id="e_picks_<?=$type?>"></div>
	<br />
	Sending:
	<?php if (!$picks) { ?>Nothing<?php } ?>
	<br />
	<?php foreach ($picks as $k=>$r) { ?>
	<?php if ($r['pick'] == 'a') { ?><b><?=$r['v_team']['name2']?></b><?php } else { ?><?=$r['v_team']['name2']?><?php } ?>
	<?php if ($r['spread_f'] == 'a') { ?>(-<?=$r['spread'] / 10?>)<?php } ?>
	@
	<?php if ($r['pick'] == 'h') { ?><b><?=$r['h_team']['name2']?></b><?php } else { ?><?=$r['h_team']['name2']?><?php } ?>
	<?php if ($r['spread_f'] == 'h') { ?>(-<?=$r['spread'] / 10?>)<?php } ?>
	<br /> 
	<?php } ?>
	<br />
	<table class="data1">
		<tr>
			<th class="lt">Email</th>
			<th class="lt">Name</th>
			<?php if ($type == 'all_ko') { ?>
			<th class="lt">Game ids</th>
			<?php } ?>
			<th>Status</th>
		</tr>
		<?php foreach ($subs as $r) { ?>
		<?php
			if (!@$r['gids']) $r['gids'] = '';
			$status = @$qa["{$r['sub_id']}_{$r['gids']}"];
		?>
		<tr>
			<td><?=hsc($r['email'])?></td>
			<td><?=hsc($r['name'])?></td>
			<?php if ($type == 'all_ko') { ?>
			<td><?=$r['gids']?></td>
			<?php } ?>
			<td class="ct">
				<?php if ($status == 'Q') { ?>
				<i class="fa fa-hourglass-o"></i>
				<?php } else if ($status == 'S') { ?>
				<i class="fa fa-check"></i>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
	</table>
	<?php if ($cnt_more) { ?>
	<br /><a href="#" act="vgrp" t="<?=$type?>">and <?=$cnt_more?> more</a>
	<?php } ?>
</div>