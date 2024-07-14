<form action="#" method="post" id="dfrm">
	<div class="fc">
		<div class="fn">Your email address</div>
		<input type="text" class="txt" name="<?=$t='email'?>" value="" />
		<div id="e_<?=$t?>" class="err"></div>
	</div>
	<div id="m_main" class="msgc"></div>
	<div id="e_main" class="errc"></div>
	<div class="spl">
		<div class="half">
			<button class="btn1" id="sbtn">Unsubscribe<i class="fa fa-trash"></i></button>
		</div>
		<div class="half rta">
			<a class="btn1" href="/">Nevermind</a>
		</div>
	</div>
</form>