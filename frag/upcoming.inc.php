<?php
	$season = bc::get_season('A');
	$ngr = $db->query("SELECT * FROM games WHERE year = %u AND status = 'P' AND g_ts >= %u ORDER BY g_ts ASC LIMIT 1", @$season['year'], time() + $time_offset);
	pp::games($ngr);
	$r = @$ngr[0];
?>
<?php if ($r) { ?>
<div class="cw">
	<div class="upc">
		<div class="itm lt"><img src="<?=$r['v_team_img']?>" /> <?=$r['v_team']['code']?></div>
		<div class="itm rt"><img src="<?=$r['h_team_img']?>" /> <?=$r['h_team']['code']?></div>
		<div class="cd">
			<ul class="clrf" id="cd1" ts="<?=$r['g_ts']-$time_offset?>">
				<li><b></b><span>Days</span></li>
				<li><b></b><span>Hours</span></li>
				<li><b></b><span>Minutes</span></li>
				<li><b></b><span>Seconds</span></li>
			</ul>
		</div>
		<div class="clr"></div>
	</div>
</div>
<?php } ?>