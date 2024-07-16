<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';
	require '../../../classes/class.bc.php';

	$head = array(
		$pk => array('ID', 'rt'),
		'code' => array('Code', 'lt'),
		'g_ts' => array('Date', 'lt'),
		'year' => array('Season', 'ct'),
		'week' => array('Week', 'ct'),
		'v_team' => array('Away team', 'lt'),
		'v_score' => array('AS', 'ct'),
		'spread' => array('Spread', 'ct'),
		'h_score' => array('HS', 'ct'),
		'h_team' => array('Home team', 'lt'),
		'pick' => array('Pick', 'ct'),
		'status' => array('Status', 'ct'),
		'result' => array('Result', 'ct'),
		'gb_link' => array('<i class="fa fa-book"></i>', 'ct'),
	);
	
	$page_num = @$_POST['p'] ? $_POST['p'] : 1;
	$pp = 20;
	$start = ($page_num - 1) * $pp;

	$sf = $pk;
	$so = 'DESC';
	if (in_array($_POST[$t='so'], array('DESC', 'ASC')))
		$so = $_POST[$t];
	if (in_array($_POST[$t='sf'], array_keys($head)))
		$sf = $_POST[$t];

	$sf2 = "M.{$sf}";
	if ($sf == 'v_team')
		$sf2 = 'VT.city';
	if ($sf == 'h_team')
		$sf2 = 'HT.city';
	if ($sf == 'result')
		$sf2 = 'status';
	
	$ss = bc::get_season('A');
	$week = bc::get_week($ss['year'], 'G');
		
	if (!isset($_POST[$t='year']))
		$_POST[$t] = $ss[$t];
	if (!isset($_POST[$t='week']))
		$_POST[$t] = $$t;
		
	$fq = '1';
	
	if (is_numeric(@$_POST['q']) && strlen($_POST['q']) >= 3)
	{
		$vv = (int)$_POST['q'];
		unset($_POST['year'], $_POST['week'], $_POST['q']);
		$fq .= " AND (M.code = {$vv} OR `{$pk}` = {$vv})";
	}
	
	if (strlen(@$_POST[$t='year']))
	{
		$fq .= " AND {$t} = ".$db->escape($_POST[$t]);
		unset($head[$t]);
	}
	if (strlen(@$_POST[$t='week']))
	{
		$fq .= " AND {$t} = ".$db->escape($_POST[$t]);
		unset($head[$t]);
	}
	if (strlen(@$_POST[$t='q']))
		$fq .= " AND (".$db->split_condition($_POST[$t], 'M.code', 'VT.name2', 'HT.name2', 'VT.full_name', 'HT.full_name', 'VT.code', 'HT.code', 'VT.code2', 'HT.code2').")";
	
	$jq = '';
	$jq .= " JOIN teams VT ON (M.v_team_id = VT.team_id)";
	$jq .= " JOIN teams HT ON (M.h_team_id = HT.team_id)";
	
	$recs = $db->query("SELECT SQL_CALC_FOUND_ROWS M.*, VT.name2 v_team, HT.name2 h_team FROM `%s` M {$jq} WHERE {$fq} ORDER BY %s %s LIMIT %u, %u", $tbl, $sf2, $so, $start, $pp);
	$found_rows = $db->found_rows();
	$pages_total = ceil($found_rows / $pp);
?>
<table class="data1">
	<tr>
		<?php foreach ($head as $k=>$v) { ?>
		<th class="<?=$v[1]?><?php if ($sf == $k) { ?> so_<?=strtolower($so)?><?php } ?>"><a href="#" act="sort" sf="<?=$k?>"><?=$v[0]?></a></th>
		<?php } ?>
		<th>Edit</th>
	</tr>
	<?php foreach ($recs as $r) { ?>
	<tr>
		<td class="rt"><?=$r[$pk]?></td>
		<td><?=hsc($r['code'])?></td>
		<td><?=DT($r['g_ts'])?></td>
		<?php if (isset($head[$t='year'])) { ?><td class="ct"><?=$r[$t]?></td><?php } ?>
		<?php if (isset($head[$t='week'])) { ?><td class="ct"><?=$r[$t]?></td><?php } ?>
		<td><?=hsc($r['v_team'])?></td>
		<td class="ct"><?=hsc($r['v_score'])?></td>
		<?php
			$s_al = 'ct';
			if ($r['spread_f'])
				$s_al = $r['spread_f'] == 'a' ? 'lt' : 'rt';
		?>
		<td class="<?=$s_al?>">
			<?php if ($r['spread_f']) { ?>
			<?=-$r['spread']/10?>
			<?php } else { ?>
			-
			<?php } ?>
		</td>
		<td class="ct"><?=hsc($r['h_score'])?></td>
		<td><?=hsc($r['h_team'])?></td>
		<td class="ct"><?=strtoupper("{$r['pick']}{$r['pick_mod']}")?></td>
		<td class="ct"><?=hsc($r['status'])?></td>
		<td class="ct">
			<?php if ($r['status'] == 'F' && $r['pick']) { $res = bc::pick_result($r); ?>
			<?php if ($res == 0) { ?>
			P
			<?php } else if ($res == -1) { ?>
			L
			<?php } else { ?>
			W
			<?php } ?>
			<?php } ?>
		</td>
		<td class="ct">
			<?php if ($r['gb_link']) { ?>
			<a href="req/<?=$tbl?>/gb.req.php?id=<?=$r[$pk]?>" target="_blank"><i class="fa fa-download"></i></a>
			<?php } else if ($r['gb_ts']) { ?>
			<i class="fa fa-exclamation-triangle"></i>
			<?php } else { ?>
			<i class="fa fa-close"></i>
			<?php } ?>
		</td>
		<td class="ct"><a class="btn1 small alt2" href="#" act="edit" eid="<?=$r[$pk]?>"><i class="fa fa-pencil"></i>Edit</a></td>
	</tr>
	<?php } ?>
</table>
<?php require '../../frag/paging.inc.php'; ?>