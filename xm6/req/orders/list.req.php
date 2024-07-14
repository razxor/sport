<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';

	$head = array(
		$pk => array('ID', 'rt'),
		'c_ts' => array('Date', 'lt'),
		'name' => array('Name', 'lt'),
		'email' => array('Email', 'lt'),
		'opt' => array('Type', 'ct'),
		'year' => array('Season', 'ct'),
		'week' => array('Week', 'ct'),
		'price' => array('Price', 'rt'),
		'txn_id' => array('TXN ID', 'lt'),
		'status' => array('Status', 'ct'),
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
	
	$fq = '1';
	if (strlen(@$_POST[$t='q']))
		$fq .= " AND (".$db->split_condition($_POST[$t], 'M.name', 'M.email', 'M.txn_id').")";
	
	$jq = '';
	
	$recs = $db->query("SELECT SQL_CALC_FOUND_ROWS M.* FROM `%s` M {$jq} WHERE {$fq} ORDER BY %s %s LIMIT %u, %u", $tbl, $sf2, $so, $start, $pp);
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
	<tr>
		<td class="rt"><?=$r[$pk]?></td>
		<td><?=D($r['c_ts'])?></td>
		<td><?=hsc($r['name'])?></td>
		<td><?=hsc($r['email'])?></td>
		<td class="ct"><?=$order_opts[$r['opt']]?></td>
		<td class="ct"><?=hsc($r['year'])?></td>
		<td class="ct">
			<?php if ($r['opt'] == 'w') { ?>
			<?=$r['week']?>
			<?php } else { ?>
			<span class="ina">All</span>
			<?php } ?>
		</td>
		<td class="rt"><?=P($r['price'])?></td>
		<td><?=hsc($r['txn_id'])?></td>
		<td class="ct">
			<?=$order_statuses[$r['status']]?>
			<?php if ($r['status'] == 'C') { ?>
			<i class="fa fa-check"></i>
			<?php } else { ?>
			<i class="fa fa-close"></i>
			<?php } ?>
		</td>
		<td class="ct"><a class="btn1 small alt2" href="#" act="edit" eid="<?=$r[$pk]?>"><i class="fa fa-pencil"></i>Edit</a></td>
	</tr>
	<?php } ?>
</table>
<?php require '../../frag/paging.inc.php'; ?>