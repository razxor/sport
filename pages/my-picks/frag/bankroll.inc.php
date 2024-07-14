<h2>Bankroll</h2>
<?php if ($mobile_user) { ?>
<div class="d1cont">
<table class="data3 w100">
	<tr>
		<th>Starting</th>
		<th>Wagered</th>
		<th>Won</th>
		<th>Final</th>
		<th>Gain</th>
	</tr>
	<tr>
		<td class="cta"><?=P2($ud['bankroll'])?></td>
		<td class="cta"><?=P2(-$st['wagers']['total'])?></td>
		<td class="cta"><?=P2($st['wagers']['won'] - $st['wagers']['lost'])?></td>
		<td class="cta"><?=P2($ud['bankroll'] + $st['bankroll'])?></td>
		<td class="cta"><?=$ud['bankroll'] ? number_format($st['bankroll'] / $ud['bankroll'] * 100) : 0?>%</td>
	</tr>
</table>
</div>
<table class="data3 w100">
	<tr>
		<th<?php if ($st['bankroll']) { ?> colspan="2"<?php } ?>><?php if ($week < 22) { ?>Next week<?php } else { ?><?=$year + 1?> Week 1<?php } ?></th>
	</tr>
	<tr>
		<td class="cta"><a class="btn1 small" href="#" act="brpush" v="<?=$ud['bankroll'] + $st['bankroll']?>">Set to <?=P2($ud['bankroll'] + $st['bankroll'])?></a></td>
		<?php if ($st['bankroll']) { ?>
		<td class="cta"><a class="btn1 small" href="#" act="brpush" v="<?=$ud['bankroll']?>">Set to <?=P2($ud['bankroll'])?></a></td>
		<?php } ?>
	</tr>
</table>
<?php } else { ?>
<table class="data3">
	<tr>
		<th>Starting</th>
		<th>Wagered</th>
		<th>Won</th>
		<th>Final</th>
		<th>Gain</th>
		<th<?php if ($st['bankroll']) { ?> colspan="2"<?php } ?>><?php if ($week < 22) { ?>Next week<?php } else { ?><?=$year + 1?> Week 1<?php } ?></th>
	</tr>
	<tr>
		<td class="cta"><?=P2($ud['bankroll'])?></td>
		<td class="cta"><?=P2(-$st['wagers']['total'])?></td>
		<td class="cta"><?=P2($st['wagers']['won'] - $st['wagers']['lost'])?></td>
		<td class="cta"><?=P2($ud['bankroll'] + $st['bankroll'])?></td>
		<td class="cta"><?=$ud['bankroll'] ? number_format($st['bankroll'] / $ud['bankroll'] * 100) : 0?>%</td>
		<td><a class="btn1 small" href="#" act="brpush" v="<?=$ud['bankroll'] + $st['bankroll']?>">Set to <?=P2($ud['bankroll'] + $st['bankroll'])?></a></td>
		<?php if ($st['bankroll']) { ?>
		<td><a class="btn1 small" href="#" act="brpush" v="<?=$ud['bankroll']?>">Set to <?=P2($ud['bankroll'])?></a></td>
		<?php } ?>
	</tr>
</table>
<?php }?>