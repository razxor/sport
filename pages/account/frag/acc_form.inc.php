<form id="dfrm" method="post"<?php if (!$mobile_user) { ?> class="half"<?php } ?> action="#">
	<div id="m_main" class="msgc"></div>
	<div class="fc">
		<b>Username</b>
		<input type="text" class="txt" name="<?=$t='user'?>" value="<?=hsc($usr->p[$t])?>"<?php if (!$usr->p['u_ch']) { ?> disabled="disabled"<?php } ?> maxlength="64" />
		<div class="err" id="e_<?=$t?>"></div>
		<?php if (!$usr->p['u_ch']) { ?>
		<div class="note">Can't be changed</div>
		<?php } ?>
	</div>
	<div class="fc">
		<b>Current password</b>
		<input type="password" class="txt" name="<?=$t='pass0'?>" value="" maxlength="64" />
		<div class="err" id="e_<?=$t?>"></div>
	</div>
	<div class="fc">
		<b>New password</b>
		<input type="password" class="txt" name="<?=$t='pass1'?>" value="" maxlength="64" />
		<div class="err" id="e_<?=$t?>"></div>
	</div>
	<div class="fc">
		<b>Confirm password</b>
		<input type="password" class="txt" name="<?=$t='pass2'?>" value="" maxlength="64" />
		<div class="err" id="e_<?=$t?>"></div>
	</div>
	<button class="btn1" id="sbtn">Save</button>
</form>