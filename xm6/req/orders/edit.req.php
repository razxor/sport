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
		
		$r['date'] = date('Y-m-d', $r['c_ts']);
	}
	else
	{
		$r = array();
		$r['date'] = date('Y-m-d');
	}
	
	$seasons = $db->query("SELECT year FROM seasons ORDER BY year ASC");
?>
<form action="#" method="post" class="modal0">
	<input type="hidden" name="id" value="<?=$id?>" />
	<div class="box1">
		<h2><a href="#" class="fr" act="close" reql="reql1"><i class="fa fa-close"></i></a><?php if ($id) { ?>Edit order<?php } else { ?>New order<?php } ?></h2>
		<div class="msgc" id="m_main"></div>
		<div class="fc">
			<div class="fn">Date</div>
			<input type="date" class="txt" name="<?=$t='date'?>" value="<?=hsc(@$r[$t])?>" />
			<div class="err" assoc="<?=$t?>"></div>
		</div>
		<div class="spl fc padr">
			<div class="half">
				<div class="fn">Name</div>
				<input type="text" class="txt" name="<?=$t='name'?>" value="<?=hsc(@$r[$t])?>" maxlength="64" />
				<div class="err" assoc="<?=$t?>"></div>
			</div>
			<div class="half">
				<div class="fn">Email</div>
				<input type="text" class="txt" name="<?=$t='email'?>" value="<?=hsc(@$r[$t])?>" maxlength="64" />
				<div class="err" assoc="<?=$t?>"></div>
			</div>
		</div>
		<div class="spl fc padr">
			<div class="third">
				<div class="fn">Type</div>
				<select name="<?=$t='opt'?>">
					<?php foreach ($order_opts as $k=>$v) { ?>
					<option value="<?=$k?>"<?php if (@$r[$t] == $k) { ?> selected="selected"<?php } ?>><?=hsc($v)?></option>
					<?php } ?>
				</select>
			</div>
			<div class="third">
				<div class="fn">Season</div>
				<select name="<?=$t='year'?>">
					<?php foreach ($seasons as $p) { ?>
					<option value="<?=$p[$t]?>"<?php if (@$r[$t] == $p[$t]) { ?> selected="selected"<?php } ?>><?=$p[$t]?></option>
					<?php } ?>
				</select>
				<div class="err" assoc="<?=$t?>"></div>
			</div>
			<div class="third">
				<div class="fn">Week</div>
				<select name="<?=$t='week'?>">
					<option value=""></option>
					<?php for ($i = 3; $i <= 22; $i++) { ?>
					<option value="<?=$i?>"<?php if (@$r[$t] == $i) { ?> selected="selected"<?php } ?>><?=$i?></option>
					<?php } ?>
				</select>
				<div class="err" assoc="<?=$t?>"></div>
			</div>
		</div>
		<div class="fc spl padr">
			<div class="third">
				<div class="fn">Price</div>
				<input type="text" class="txt num1" name="<?=$t='price'?>" value="<?=hsc(@$r[$t])?>" /> $
				<div class="err" assoc="<?=$t?>"></div>
			</div>
			<div class="third">
				<div class="fn">Status</div>
				<select name="<?=$t='status'?>">
					<?php foreach ($order_statuses as $k=>$v) { ?>
					<option value="<?=$k?>"<?php if (@$r[$t] == $k) { ?> selected="selected"<?php } ?>><?=hsc($v)?></option>
					<?php } ?>
				</select>
				<div class="err" assoc="<?=$t?>"></div>
			</div>
			<div class="third">
				<div class="fn">Transaction ID</div>
				<input type="text" class="txt" name="<?=$t='txn_id'?>" value="<?=hsc(@$r[$t])?>" maxlength="20" />
				<div class="err" assoc="<?=$t?>"></div>
			</div>
		</div>
		<footer>
			<table>
				<tr>
					<td><a href="#" act="close" reql="reql1">Close</a></td>
					<td>
						<?php if (0 && $id) { ?>
						<a class="btn1 alt2" act="del" eid="<?=$r[$pk]?>"><i class="fa fa-trash"></i>Delete</a>
						<?php } ?>
						<button type="submit" class="btn1" name="btn1"><i class="fa fa-save"></i>Save</button>
					</td>
				</tr>
			</table>
		</footer>
	</div>
</form>