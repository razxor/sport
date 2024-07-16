<form id="dfrm" method="post" action="#">
	<input type="hidden" name="h" value="<?=$a[1]?>" />
	<input type="hidden" name="x1" value="<?=$a[2]?>" />
	<input type="hidden" name="x2" value="<?=$a[3]?>" />
	<div id="m_main" class="msgc"></div>
	<div class="fc">
		<b>Login</b>
		<input type="text" class="txt" name="<?=$t='user'?>" value="<?=hsc($us[$t])?>" disabled="disabled" maxlength="64" onblur="this.value=this.value.trim();" />
		<div class="err" id="e_<?=$t?>"></div>
		<div class="note">Cannot be changed</div>
	</div>
	<div class="fc">
		<b>New password</b>
		<input type="password" class="txt" name="<?=$t='pass1'?>" value="" maxlength="64" onblur="this.value=this.value.trim();" />
		<div class="err" id="e_<?=$t?>"></div>
	</div>
	<div class="fc">
		<b>Confirm password</b>
		<input type="password" class="txt" name="<?=$t='pass2'?>" value="" maxlength="64" onblur="this.value=this.value.trim();" />
		<div class="err" id="e_<?=$t?>"></div>
	</div>
	<a href="/account/" class="btn1 far fr">Access account<i class="fa fa-chevron-right"></i></a>
	<button class="btn1" id="sbtn">Save</button>
</form>