<?php
	require '../../inc/global.inc.php';
?>
<div>
	<div>
		<h1>Password reset<a href="#"><i class="fa fa-close"></i></a></h1>
		<form id="xdfrm" action="#" method="post">
			<div class="lcont">
				<div id="xm_main" class="msgc"></div>
				<div class="fc">
					<b>Email</b>
					<input type="text" class="txt" name="<?=$t='s_email'?>" value="" maxlength="64" />
					<div class="err" id="xe_<?=$t?>"></div>
				</div>
				<button class="btn1 big" id="rs_btn">Reset<i class="fa fa-key"></i></button>
			</div>
		</form>
	</div>
</div>