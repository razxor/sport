<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';

	$head = array(
		'code2' => array('Logo', 'ct'),
		$pk => array('ID', 'rt'),
		'code' => array('Code', 'ct'),
		//'city' => array('City', 'lt'),
		'name2' => array('Name', 'lt'),
		//'full_name' => array('Full name', 'lt'),
	);
	
	$page_num = @$_POST['p'] ? $_POST['p'] : 1;
	$pp = 50;
	$start = ($page_num - 1) * $pp;

	$sf = 'city';
	$so = 'ASC';
	if (in_array($_POST[$t='so'], array('DESC', 'ASC')))
		$so = $_POST[$t];
	if (in_array($_POST[$t='sf'], array_keys($head)))
		$sf = $_POST[$t];

	$sf2 = "M.{$sf}";
	if ($sf == 'code2')
		$sf2 = 'M.code';
	
	$fq = '1';
	if (strlen(@$_POST[$t='q']))
		$fq .= " AND (".$db->split_condition($_POST[$t], 'city', 'name', 'full_name', 'code').")";
	
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
	</tr>
	<?php foreach ($recs as $r) { ?>
	<tr>
		<td class="ct"><img src="/md/<?=$tbl?>/<?=strtolower($r['code'])?>.svg" style="width:64px;" /></td>
		<td class="rt"><?=$r[$pk]?></td>
		<td class="ct"><?=hsc(trim("{$r['code']} {$r['code2']}"))?></td>
		<?php if (0) { ?><td><?=hsc($r['city'])?></td><?php } ?>
		<td><?=hsc($r['name2'])?></td>
		<?php if (0) { ?><td><?=hsc($r['full_name'])?></td><?php } ?>
	</tr>
	<?php } ?>
</table>
<?php require '../../frag/paging.inc.php'; ?>