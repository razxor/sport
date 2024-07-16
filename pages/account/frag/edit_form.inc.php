<form id="dfrm" method="post" action="#"<?php if (!$mobile_user) { ?> class="half"<?php } ?>>
	<div id="m_main" class="msgc"></div>
	<div class="fc">
		<div class="fn">Name</div>
		<input type="text" class="txt" name="<?=$t='name'?>" value="<?=hsc($usr->p[$t])?>" maxlength="64" />
		<div class="err" id="e_<?=$t?>"></div>
	</div>
	<div class="fc">
		<div class="fn">Email</div>
		<input type="text" class="txt" name="<?=$t='email'?>" value="<?=hsc($usr->p[$t])?>" maxlength="64" />
		<div class="err" id="e_<?=$t?>"></div>
	</div>
	<div class="fc">
		<div class="fn">Phone</div>
		<input type="text" class="txt" name="<?=$t='phone'?>" value="<?=hsc($usr->p[$t])?>" maxlength="64" />
		<div class="err" id="e_<?=$t?>"></div>
	</div>
	<button class="btn1" id="sbtn">Save<i class="fa fa-save"></i></button>
</form>