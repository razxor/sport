<?php
	$ss = bc::get_season('A');
	$subo = db::first($db->query("SELECT * FROM subs WHERE (email = '%s' OR user_id = %u) AND year = '%s' AND (wknd != 0 OR pow != 0 OR opt != '')", $usr->p['email'], $usr->p['user_id'], $ss['year']));
?>
<form id="dfrm" method="post"<?php if (!$mobile_user) { ?> class="half"<?php } ?> action="#">
	<div id="m_main" class="msgc"></div>
	<div class="fc">
		<table class="data3">
			<tr>
				<td><input type="checkbox" name="<?=$t='wknd'?>" id="cb_<?=$t?>"<?php if (@$subo[$t]) { ?> checked="checked"<?php } ?> /></td>
				<td><label for="cb_<?=$t?>">Weekend Preview</label></td>
			</tr>
			<tr>
				<td><input type="checkbox" name="<?=$t='pow'?>" id="cb_<?=$t?>"<?php if (@$subo[$t]) { ?> checked="checked"<?php } ?> /></td>
				<td><label for="cb_<?=$t?>">Free Pick of the Week</label></td>
			</tr>
			<tr>
				<td><input type="radio" name="<?=$t='opt'?>" value="a" id="ra_<?=$t?>_a"<?php if (@$subo[$t] == 'a') { ?> checked="checked"<?php } ?> /></td>
				<td><label for="ra_<?=$t?>_a">All picks at kickoff</label></td>
			</tr>
			<tr>
				<td><input type="radio" name="<?=$t='opt'?>" value="b" id="ra_<?=$t?>_b"<?php if (@$subo[$t] == 'b') { ?> checked="checked"<?php } ?> /></td>
				<td><label for="ra_<?=$t?>_b">Best pick at kickoff</label></td>
			</tr>
			<tr>
				<td><input type="radio" name="<?=$t='opt'?>" value="" id="ra_<?=$t?>_n"<?php if (@$subo[$t] == '') { ?> checked="checked"<?php } ?> /></td>
				<td><label for="ra_<?=$t?>_n">None</label></td>
			</tr>
		</table>
		<div id="e_<?=$t?>" class="err"></div>
	</div>
	<button class="btn1" id="sbtn">Save</button>
</form>