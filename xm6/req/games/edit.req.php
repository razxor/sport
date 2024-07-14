<?php
	require '../../inc/global.inc.php';
	require '../../inc/req_auth.inc.php';
	require 'common.inc.php';

	$id = (int)@$_POST['id'];
	$r = db::first($db->query("SELECT * FROM `%s` WHERE `%s` = %u", $tbl, $pk, $id));
	if (!$r)
		die('Item not found');
	
	$h_team = db::first($db->query("SELECT * FROM teams WHERE team_id = %u", $r['h_team_id']));
	$v_team = db::first($db->query("SELECT * FROM teams WHERE team_id = %u", $r['v_team_id']));
?>
<form action="#" method="post" class="modal0">
	<input type="hidden" name="id" value="<?=$id?>" />
	<div class="box1">
		<h2><a href="#" class="fr" act="close" reql="reql1"><i class="fa fa-close"></i></a><?php if ($id) { ?>Edit game<?php } else { ?>New game<?php } ?></h2>
		<div class="msgc" id="m_main"></div>
		<div class="spl padr">
			<div class="fc half">
				<div class="fn">Pick</div>
				<select name="<?=$t='pick'?>">
					<option value=""></option>
					<?php foreach ($pick_opt as $k=>$v) { ?>
					<option value="<?=$k?>"<?php if (@$r[$t] == $k) { ?> selected="selected"<?php } ?>><?=hsc($v)?> (<?php if ($k == 'a') { ?><?=hsc($v_team['name2'])?><?php } else if ($k == 'h') { ?><?=hsc($h_team['name2'])?><?php } ?>)</option>
					<?php } ?>
				</select>
				<div class="err" assoc="<?=$t?>"></div>
			</div>
			<div class="fc half">
				<div class="fn">Mod</div>
				<select name="<?=$t='pick_mod'?>">
					<option value=""></option>
					<?php foreach ($pick_mod as $k=>$v) { ?>
					<option value="<?=$k?>"<?php if (@$r[$t] == $k) { ?> selected="selected"<?php } ?>><?=hsc($v)?></option>
					<?php } ?>
				</select>
				<div class="err" assoc="<?=$t?>"></div>
			</div>
		</div>
		<div class="spl padr">
			<div class="fc half">
				<div class="fn">Spread</div>
				<select name="<?=$t='spread'?>">
					<option value=""></option>
					<?php for ($i = 0; $i <= 255; $i+=5) { ?>
					<option value="<?=$i?>"<?php if ($r[$t] == $i) { ?> selected="selected"<?php } ?>><?php if ($i) { ?>-<?=$i / 10?><?php } else { ?>h<?php } ?></option>
					<?php } ?>
				</select>
				<div class="err" assoc="<?=$t?>"></div>
			</div>
			<div class="fc half">
				<div class="fn">Favoring</div>
				<select name="<?=$t='spread_f'?>">
					<option value=""></option>
					<?php foreach ($pick_opt as $k=>$v) { ?>
					<option value="<?=$k?>"<?php if (@$r[$t] == $k) { ?> selected="selected"<?php } ?>><?=hsc($v)?> (<?php if ($k == 'a') { ?><?=hsc($v_team['name2'])?><?php } else if ($k == 'h') { ?><?=hsc($h_team['name2'])?><?php } ?>)</option>
					<?php } ?>
				</select>
				<div class="err" assoc="<?=$t?>"></div>
			</div>
		</div>
		<footer>
			<table>
				<tr>
					<td><a href="#" act="close" reql="reql1">Close</a></td>
					<td>
						<?php if (0) { ?>
						<a class="btn1 alt2" act="del" eid="<?=$r[$pk]?>"><i class="fa fa-trash"></i>Delete</a>
						<?php } ?>
						<button type="submit" class="btn1" name="btn1"><i class="fa fa-save"></i>Save</button>
					</td>
				</tr>
			</table>
		</footer>
	</div>
</form>