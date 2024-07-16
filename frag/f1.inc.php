<?php
	$ss = bc::get_season('N');
	$year = $ss['year'];
	$week = bc::get_week($year, 'P');
?>
<div class="f1">
	<form class="cw clrf" action="/purchases/" method="get">
		<div class="s1 fl clrf">
			<i class="fa fa-envelope-o fa-4x"></i>
			<div class="fl">
				<h3>Purchase</h3>
				NFL Picks by email
			</div>
		</div>
		<div class="s2 fl">
			<select name="opt">
				<option value="w">Week <?=bc::wk_name($week)?> Picks - <?=P($week_price)?></option>
 				<option value="y">
 					<?php if ($week <= 3) { ?><?=$year?> season package<?php } else { ?>Remainder of the <?=$year?> season<?php } ?> - <?=P(bc::season_price($week))?>
 				</option>
 			</select> 
		</div>
		<div class="s3 fl">
			<input type="text" class="txt" placeholder="Your email address" name="email" />
			<button><i class="fa fa-chevron-right"></i></button>
		</div>
	</form>
</div>