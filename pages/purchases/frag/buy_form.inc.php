<form action="#" method="post" id="dfrm">
	<input type="hidden" name="env" value="<?=$paypal_live ? 'production' : 'sandbox'?>" />
	<div class="fc">
		<table class="data3">
			<tr>
				<td><input type="radio" name="<?=$t='opt'?>" value="<?=$k='w'?>" id="ra_<?=$k?>"<?php if ($week >= 17 || @$D[$t] == $k) { ?> checked="checked"<?php } ?> /></td>
				<td><label for="ra_<?=$k?>">Week <?=bc::wk_name($week)?> Picks</label></td>
				<td class="rta"><?=P($week_price)?></td>
			</tr>
			<?php if ($week < 17) { ?>
			<tr>
				<td><input type="radio" name="<?=$t?>" value="<?=$k='y'?>" id="ra_<?=$k?>"<?php if ($week >= 17 || @$D[$t] == $k) { ?> checked="checked"<?php } ?> /></td>
				<td>
					<label for="ra_<?=$k?>">
						<?php if ($week <= 3) { ?>
						<?=$year?> season package
						<?php } else { ?>
						Remainder of the <?=$year?> season
						<?php } ?>
						<div class="note">(Including playoffs)</div>
					</label>
				</td>
				<td class="rta"><?=P(bc::season_price($week))?></td>
			</tr>
			<?php } ?>
		</table>
		<div id="e_<?=$t?>" class="err"></div>
	</div>
	<div class="fc">
		<div class="fn">Email address</div>
		<input type="text" name="<?=$t='email'?>" value="<?=hsc(@$D[$t])?>" class="txt" maxlength="64" />
		<div id="e_<?=$t?>" class="err"></div>
	</div>
</form>
<div id="paypal-button"></div>