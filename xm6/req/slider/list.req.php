<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';

	$head = array(
		$pk => array('ID', 'rt'),
		'title' => array('Title', 'lt'),
		'link' => array('Link', 'lt'),
		'd_o' => array('Order', 'rt'),
		'active' => array('Active', 'ct'),
	);
	
	$page_num = @$_POST['p'] ? $_POST['p'] : 1;
	$pp = 20;
	$start = ($page_num - 1) * $pp;

	$sf = 'd_o';
	$so = 'ASC';
	if (in_array($_POST[$t='so'], array('DESC', 'ASC')))
		$so = $_POST[$t];
	if (in_array($_POST[$t='sf'], array_keys($head)))
		$sf = $_POST[$t];

	$sf2 = "M.{$sf}";
	
	$fq = '1';
	if (strlen(@$_POST[$t='q']))
		$fq .= " AND (".$db->split_condition($_POST[$t], 'M.title', 'M.link').")";
	
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
	<tr<?php if (!$r['active']) { ?> class="ina"<?php } ?>>
		<td class="rt"><?=$r[$pk]?></td>
		<td><?=hsc($r['title'])?></td>
		<td><?=hsc($r['link'])?></td>
		<td class="rt">
			<a href="#" act="move" eid="<?=$r[$pk]?>" mode="up"><i class="fa fa-angle-up"></i></a>
			<a href="#" act="move" eid="<?=$r[$pk]?>" mode="dn"><i class="fa fa-angle-down"></i></a>
			<?=$r['d_o']?>
		</td>
		<td class="ct"><input type="checkbox"<?php if ($r[$t='active']) { ?> checked="checked"<?php } ?> act="set" k="<?=$t?>" eid="<?=$r[$pk]?>" /></td>
		<td class="ct"><a class="btn1 small alt2" href="#" act="edit" eid="<?=$r[$pk]?>"><i class="fa fa-pencil"></i>Edit</a></td>
	</tr>
	<?php } ?>
</table>
<?php require '../../frag/paging.inc.php'; ?>