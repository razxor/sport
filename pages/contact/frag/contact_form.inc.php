<form action="#" method="post" id="dfrm">
	<div class="fc">
		<div class="fn">Your name</div>
		<input type="text" name="<?=$t='name'?>" value="<?=hsc(@$D[$t])?>" class="txt" maxlength="64" />
		<div id="e_<?=$t?>" class="err"></div>
	</div>
	<div class="fc">
		<div class="fn">Phone number</div>
		<input type="text" name="<?=$t='phone'?>" value="<?=hsc(@$D[$t])?>" class="txt" maxlength="32" />
		<div id="e_<?=$t?>" class="err"></div>
	</div>
	<div class="fc">
		<div class="fn">Email address</div>
		<input type="text" name="<?=$t='email'?>" value="<?=hsc(@$D[$t])?>" class="txt" maxlength="64" />
		<div id="e_<?=$t?>" class="err"></div>
	</div>
	<div class="fc">
		<div class="fn">Subject</div>
		<input type="text" name="<?=$t='subject'?>" value="<?=hsc(@$D[$t])?>" class="txt" />
		<div id="e_<?=$t?>" class="err"></div>
	</div>
	<div class="fc">
		<div class="fn">Message</div>
		<textarea name="<?=$t='message'?>" cols="32" rows="10"><?=hsc(@$D[$t])?></textarea>
		<div id="e_<?=$t?>" class="err"></div>
	</div>
	<div id="m_main" class="msgc"></div>
	<div id="e_main" class="errc"></div>
	<button class="btn1" id="sbtn">Send message<i class="fa fa-send"></i></button>
</form>