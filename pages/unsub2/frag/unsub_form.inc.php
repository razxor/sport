<form action="#" method="post" id="dfrm">
	<input type="hidden" name="email" value="<?=hsc($email)?>" />
	<input type="hidden" name="x" value="<?=hsc($x)?>" />
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