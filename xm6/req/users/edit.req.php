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
	}
?>
<form action="#" method="post" class="modal0">
	<input type="hidden" name="id" value="<?=$id?>" />
	<div class="box1">
		<h2><a href="#" class="fr" act="close" reql="reql1"><i class="fa fa-close"></i></a><?php if ($id) { ?>Edit user<?php } else { ?>New user<?php } ?></h2>
		<div class="msgc" id="m_main"></div>
		<?php if ($usr->p['user_id'] != $id) { ?>
		<div class="fc">
			<div class="fn">Username</div>
			<input type="text" class="txt" name="<?=$t='user'?>" value="<?=hsc(@$r[$t])?>" maxlength="64" />
			<div class="err" assoc="<?=$t?>"></div>
		</div>
		<div class="fc">
			<div class="fn">Password</div>
			<input type="password" class="txt" name="<?=$t='pass'?>" value="" maxlength="64" />
			<div class="err" assoc="<?=$t?>"></div>
		</div>
		<?php } ?>
		<div class="fc">
			<div class="fn">Full name</div>
			<input type="text" class="txt" name="<?=$t='name'?>" value="<?=hsc(@$r[$t])?>" maxlength="64" />
			<div class="err" assoc="<?=$t?>"></div>
		</div>
		<div class="fc">
			<div class="fn">Email</div>
			<input type="text" class="txt" name="<?=$t='email'?>" value="<?=hsc(@$r[$t])?>" maxlength="64" />
			<div class="err" assoc="<?=$t?>"></div>
		</div>
		<div class="fc">
			<div class="fn">Phone</div>
			<input type="text" class="txt" name="<?=$t='phone'?>" value="<?=hsc(@$r[$t])?>" maxlength="32" />
			<div class="err" assoc="<?=$t?>"></div>
		</div>
		<?php if ($usr->p['user_id'] != $id) { ?>
		<div class="fc">
			<div class="fn">Role</div>
			<select name="<?=$t='role_id'?>">
				<option value=""></option>
				<?php foreach ($_ROLES as $k=>$p) { ?>
				<option value="<?=$k?>"<?php if (@$r[$t] == $k) { ?> selected="selected"<?php } ?>><?=hsc($p['name'])?></option>
				<?php } ?>
			</select>
			<div class="err" assoc="<?=$t?>"></div>
		</div>
		<div>
			<label><input type="checkbox" name="<?=$t='active'?>"<?php if (@$r[$t]) { ?> checked="checked"<?php } ?>> Active</label>
		</div>
		<?php } ?>
		<footer>
			<table>
				<tr>
					<td><a href="#" act="close" reql="reql1">Close</a></td>
					<td>
						<?php if ($id && $usr->p[$pk] != $id) { ?>
						<a class="btn1 alt2" act="del" eid="<?=$r[$pk]?>"><i class="fa fa-trash"></i>Delete</a>
						<?php } ?>
						<button type="submit" class="btn1" name="btn1"><i class="fa fa-save"></i>Save</button>
					</td>
				</tr>
			</table>
		</footer>
	</div>
</form>