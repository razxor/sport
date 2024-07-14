<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';

	$head = array(
		$pk => array('ID', 'rt'),
		'c_ts' => array('Date', 'lt'),
		'team' => array('Team', 'lt'),
		'title' => array('Title', 'lt'),
		'des' => array('Description', 'lt'),
		'link' => array('Link', 'ct'),
	);
	
	$page_num = @$_POST['p'] ? $_POST['p'] : 1;
	$pp = 50;
	$start = ($page_num - 1) * $pp;

	$sf = $pk;
	$so = 'DESC';
	if (in_array($_POST[$t='so'], array('DESC', 'ASC')))
		$so = $_POST[$t];
	if (in_array($_POST[$t='sf'], array_keys($head)))
		$sf = $_POST[$t];

	$sf2 = "M.{$sf}";
	if ($sf == 'team')
		$sf2 = 'T.name';
	
	$fq = '1';
	if (strlen(@$_POST[$t='q']))
		$fq .= " AND (".$db->split_condition($_POST[$t], 'M.title', 'M.des', 'T.name').")";
	
	$jq = ' LEFT JOIN teams T ON (M.team_id = T.team_id)';
	
	$recs = $db->query("SELECT SQL_CALC_FOUND_ROWS M.*, T.name2 team FROM `%s` M {$jq} WHERE {$fq} ORDER BY %s %s LIMIT %u, %u", $tbl, $sf2, $so, $start, $pp);
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
		<td class="rt"><?=$r[$pk]?></td>
		<td class="lt"><?=D($r['c_ts'])?></td>
		<td><?=hsc($r['team'])?></td>
		<td><?=hsc($r['title'])?></td>
		<td><?=hsc($r['des'])?></td>
		<td class="ct"><a href="<?=$r['link']?>" target="_blank"><i class="fa fa-external-link"></i></a></td>
	</tr>
	<?php } ?>
</table>
<?php require '../../frag/paging.inc.php'; ?>