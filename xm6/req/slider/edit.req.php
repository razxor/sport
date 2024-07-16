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
	}
	else
	{
		$r = array('active' => 1);
		$p = db::first($db->query("SELECT d_o FROM `%s` ORDER BY `%s` DESC LIMIT 1", $tbl, $pk));
		$r['d_o'] = $p['d_o'] + 10;
	}
?>
<form action="#" method="post" class="modal0">
	<input type="hidden" name="id" value="<?=$id?>" />
	<div class="box1">
		<h2><a href="#" class="fr" act="close" reql="reql1"><i class="fa fa-close"></i></a><?php if ($id) { ?>Edit item<?php } else { ?>New item<?php } ?></h2>
		<div class="msgc" id="m_main"></div>
		<div class="fc">
			<div class="fn">Title</div>
			<input type="text" class="txt" name="<?=$t='title'?>" value="<?=hsc(@$r[$t])?>" maxlength="255" />
			<div class="err" assoc="<?=$t?>"></div>
		</div>
		<div class="fc">
			<div class="fn">Link</div>
			<input type="text" class="txt" name="<?=$t='link'?>" value="<?=hsc(@$r[$t])?>" maxlength="255" />
			<div class="err" assoc="<?=$t?>"></div>
		</div>
		<div class="fc">
			<div class="fn">Order</div>
			<input type="text" class="txt num1" name="<?=$t='d_o'?>" value="<?=hsc(@$r[$t])?>" maxlength="6" />
			<div class="err" assoc="<?=$t?>"></div>
		</div>
		<div>
			<label><input type="checkbox" name="<?=$t='active'?>"<?php if (@$r[$t]) { ?> checked="checked"<?php } ?>> Active</label>
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