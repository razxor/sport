<div<?php if (!$mobile_user) { ?> class="half"<?php } ?>>
	<ul class="tabh">
		<li id="th_0_0" class="active"><a href="#">Log in</a></li>
		<li id="th_0_1"><a href="#">Register</a></li>
	</ul>
	<div class="tabc" id="tc_0_0">
		<form id="lfrm" method="post" action="#">
			<div class="fc">
				<b>User or email</b>
				<input type="text" class="txt" name="<?=$t='l_user'?>" maxlength="64" />
				<div class="err" id="e_<?=$t?>"></div>
			</div>
			<div class="fc">
				<b>Password</b>
				<input type="password" class="txt" name="<?=$t='l_pass'?>" />
				<div class="err" id="e_<?=$t?>"></div>
			</div>
			<div class="spl spl1m">
				<div class="half"><button class="btn1 big" id="lbtn">Log in</button></div>
				<div class="half rta"><a href="#" id="forgot_btn" class="btn3">Forgot your password?</a></div>
			</div>
			<br />
			<div class="spl spl1m">
				<div class="half"><a href="/fb-connect/" class="btn1 fb">Connect<?php if (!$mobile_user) { ?> with Facebook<?php } ?><i class="fab fa-facebook-square"></i></a></div>
				<div class="half rta"><a href="/gp-connect/" class="btn1 gp">Connect<?php if (!$mobile_user) { ?> with Google+<?php } ?> <i class="fab fa-google-plus-square"></i></a></div>
			</div>
		</form>
	</div>
	<div class="tabc hide" id="tc_0_1">
		<form id="rfrm" method="post" action="#">
			<div class="fc">
				<b>Name</b>
				<input type="text" class="txt" name="<?=$t='r_name'?>" />
				<div class="err" id="e_<?=$t?>"></div>
			</div>
			<div class="fc">
				<b>Email</b>
				<input type="text" class="txt" name="<?=$t='r_email'?>" />
				<div class="err" id="e_<?=$t?>"></div>
			</div>
			<div class="fc">
				<b>Phone</b>
				<input type="text" class="txt" name="<?=$t='r_phone'?>" />
				<div class="err" id="e_<?=$t?>"></div>
			</div>
			<div class="fc">
				<b>User</b>
				<input type="text" class="txt" name="<?=$t='r_user'?>" />
				<div class="err" id="e_<?=$t?>"></div>
			</div>
			<div class="fc">
				<b>Password</b>
				<input type="password" class="txt" name="<?=$t='r_pass'?>" />
				<div class="err" id="e_<?=$t?>"></div>
			</div>
			<div class="fc">
				<input type="checkbox" name="<?=$t='terms'?>" id="cb_<?=$t?>" />
				<label for="cb_<?=$t?>">I accept the <a href="#" id="terms_btn">Terms &amp; conditions</a> of this site</label>
				<div class="err" id="e_<?=$t?>"></div>
			</div>
			<button class="btn1 big" id="rbtn">Register</button>
		</form>
	</div>
</div>