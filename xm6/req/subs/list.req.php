<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';
	require '../../../classes/class.bc.php';

	$head = array(
		$pk => array('ID', 'rt'),
		'c_ts' => array('Date', 'lt'),
		'wknd' => array('Weekend', 'ct'),
		'pow' => array('POW', 'ct'),
		'opt' => array('Type', 'ct'),
		'year' => array('Season', 'ct'),
		'week' => array('Week', 'ct'),
		'name' => array('Name', 'lt'),
		'email' => array('Email', 'lt'),
		'bounced' => array('Bounced', 'ct'),
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
	
	$ss = bc::get_season('A');
	$week = bc::get_week($ss['year'], 'G');
	
	if (!isset($_POST[$t='year']))
		$_POST[$t] = $ss[$t];
	if (!isset($_POST[$t='week']))
		$_POST[$t] = $$t;
	
	$fq = '1';
	
	$jq = 'LEFT JOIN orders O ON (M.order_id = O.order_id)';
	
	if (strlen(@$_POST['year']) && strlen(@$_POST[$t='week']))
	{
		$jq = "LEFT JOIN orders O ON (M.order_id = O.order_id AND ((O.opt = 'y' AND O.year = ".$db->escape($_POST['year']).") OR (O.opt = 'w' AND O.year = ".$db->escape($_POST['year'])." AND O.week = ".$db->escape($_POST['week']).")))";
		$fq .= " AND IF(O.order_id IS NOT NULL, O.year, M.year) = ".$db->escape($_POST['year'])." AND (M.opt != '' OR O.order_id IS NOT NULL)";
		unset($head['year']);
		unset($head[$t]);
	}
	else if (strlen(@$_POST[$t='year']))
	{
		$jq = "LEFT JOIN orders O ON (M.order_id = O.order_id AND O.year = ".$db->escape($_POST[$t]).")";
		$fq .= " AND IF(O.order_id IS NOT NULL, O.year, M.year) = ".$db->escape($_POST[$t]);
		unset($head[$t]);
	}
	if (strlen(@$_POST[$t='q']))
		$fq .= " AND (".$db->split_condition($_POST[$t], 'M.name', 'M.email').")";
	
	$recs = $db->query("SELECT SQL_CALC_FOUND_ROWS M.*,
						IF(O.order_id IS NOT NULL, O.year, M.year) year,
						IF(O.order_id IS NOT NULL, O.opt, M.opt) opt,
						IF(O.order_id IS NOT NULL, O.week, 0) week
						FROM `%s` M {$jq} WHERE {$fq} ORDER BY %s %s LIMIT %u, %u", $tbl, $sf2, $so, $start, $pp);
	$found_rows = $db->found_rows();
	$pages_total = ceil($found_rows / $pp);
?>
<table class="data1">
	<tr>
		<?php foreach ($head as $k=>$v) { ?>
		<th class="<?=$v[1]?><?php if ($sf == $k) { ?> so_<?=strtolower($so)?><?php } ?>"><a href="#" act="sort" sf="<?=$k?>"><?=hsc($v[0])?></a></th>
		<?php } ?>
		<th>Edit</th>
	</tr>
	<?php foreach ($recs as $r) { ?>
	<tr<?php if ($r['bounced']) { ?> class="ina"<?php } ?>>
		<td class="rt"><?=$r[$pk]?></td>
		<td><?=D($r['c_ts'])?></td>
		<td class="ct"><?php if ($r['wknd']) { ?><i class="fa fa-check"></i><?php } ?></td>
		<td class="ct"><?php if ($r['pow']) { ?><i class="fa fa-check"></i><?php } ?></td>
		<td class="ct">
			<?=@$sub_opts[$r['opt']]?>
		</td>
		<?php if (isset($head[$t='year'])) { ?><td class="ct"><?=$r[$t]?></td><?php } ?>
		<?php if (isset($head[$t='week'])) { ?>
		<td class="ct">
			<?php if ($r[$t]) { ?>
			<?=$r[$t]?>
			<?php } else { ?>
			<span class="ina">All</span>
			<?php } ?>
		</td>
		<?php } ?>
		<td><?=hsc($r['name'])?></td>
		<td><?=hsc($r['email'])?></td>
		<td class="ct"><?=$yn[$r['bounced']]?></td>
		<td class="ct"><a class="btn1 small alt2" href="#" act="edit" eid="<?=$r[$pk]?>"><i class="fa fa-pencil"></i>Edit</a></td>
	</tr>
	<?php } ?>
</table>
<?php require '../../frag/paging.inc.php'; ?>