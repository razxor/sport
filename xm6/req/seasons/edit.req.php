<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';

	$id = (int)@$_POST['id'];
	if ($id)
	{
		$r = db::first($db->query("SELECT * FROM `%s` WHERE `%s` = %u", $tbl, $pk, $id));
		if (!$r)
			die('Item not found');
		
		$r['s_date'] = date('Y-m-d', $r['s_ts']);
		$r['e_date'] = date('Y-m-d', $r['e_ts']);
	}
	else
	{
		$r = array();
	}
?>
<form action="#" method="post" class="modal0">
	<input type="hidden" name="id" value="<?=$id?>" />
	<div class="box1">
		<h2><a href="#" class="fr" act="close" reql="reql1"><i class="fa fa-close"></i></a><?php if ($id) { ?>Edit season<?php } else { ?>New season<?php } ?></h2>
		<div class="msgc" id="m_main"></div>
		<div class="fc">
			<div class="fn">Start date</div>
			<input type="date" class="txt" name="<?=$t='s_date'?>" value="<?=hsc(@$r[$t])?>" />
			<div class="err" assoc="<?=$t?>"></div>
		</div>
		<div class="fc">
			<div class="fn">End date</div>
			<input type="date" class="txt" name="<?=$t='e_date'?>" value="<?=hsc(@$r[$t])?>" />
			<div class="err" assoc="<?=$t?>"></div>
		</div>
		<footer>
			<table>
				<tr>
					<td><a href="#" act="close" reql="reql1">Close</a></td>
					<td>
						<?php if ($id) { ?>
						<a class="btn1 alt2" act="del" eid="<?=$r[$pk]?>"><i class="fa fa-trash"></i>Delete</a>
						<?php } ?>
						<button type="submit" class="btn1" name="btn1"><i class="fa fa-save"></i>Save</button>
					</td>
				</tr>
			</table>
		</footer>
	</div>
</form>