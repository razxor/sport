<table class="data1 w100">
	<thead>
		<tr>
			<th></th>
			<th colspan="3"><?=hsc($usr->p['name'])?></th>
			<th></th>
			<th></th>
			<th class="spc"></th>
			<th colspan="3">BestChanceToWin</th>
			<th></th>
			<th class="spc"></th>
			<th colspan="3">Head to head</th>
			<th></th>
		</tr>
		<tr>
			<th></th>
			<th colspan="3"><?php if ($stats_us['pct'] !== '') { ?><?=$stats_us['pct']?>%<?php } ?></th>
			<th></th>
			<th></th>
			<th class="spc"></th>
			<th colspan="3"><?php if ($stats_bc['pct'] !== '') { ?><?=$stats_bc['pct']?>%<?php } ?></th>
			<th></th>
			<th class="spc"></th>
			<th colspan="3"><?php if ($stats_hh['pct'] !== '') { ?><?=$stats_hh['pct']?>%<?php } ?></th>
			<th></th>
		</tr>
		<tr>
			<th>Totals</td>
			<th><?=$stats_us[1]?></th>
			<th><?=$stats_us[-1]?></th>
			<th><?=$stats_us[0]?></th>
			<th><?=P2($stats_us['w'])?></th>
			<th></th>
			<th class="spc"></th>
			<th><?=$stats_bc[1]?></th>
			<th><?=$stats_bc[-1]?></th>
			<th><?=$stats_bc[0]?></th>
			<th></th>
			<th class="spc"></th>
			<th><?=$stats_hh[1]?></th>
			<th><?=$stats_hh[-1]?></th>
			<th><?=$stats_hh[0]?></th>
			<th></th>
		</tr>
		<tr>
			<th class="cta">Week</th>
			<th class="cta">Wins</th>
			<th class="cta">Loss</th>
			<th class="cta">Push</th>
			<th class="cta">Winnings</th>
			<th></th>
			<th class="spc"></th>
			<th class="cta">Wins</th>
			<th class="cta">Loss</th>
			<th class="cta">Push</th>
			<th></th>
			<th class="spc"></th>
			<th class="cta">Wins</th>
			<th class="cta">Loss</th>
			<th class="cta">Push</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php for ($i = 1; $i <= 22; $i++) if ($i != 21) { $week = $i; $r = @$recs_bc[$week]; $ru = @$recs_us[$week]; $rh = @$recs_hh[$week]; ?>
		<tr>
			<td class="cta"><?=bc::wk_name($week)?></td>
			<?php if (!$ru) { ?>
			<td class="cta" colspan="4"></td>
			<td></td>
			<?php } else { ?>
			<td class="cta"><?=$ru[1]?></td>
			<td class="cta"><?=$ru[-1]?></td>
			<td class="cta"><?=$ru[0]?></td>
			<td class="cta"><?=P2($ru['w'])?></td>
			<td class="cta"><?php if ($ru) { ?><a href="#" class="fao" act="uwstat" y="<?=$year?>" w="<?=$week?>"><i class="fa fa-eye"></i></a><?php } ?></td>
			<?php } ?>
			<td class="spc"></td>
			<?php if (!$r) { ?>
			<td class="cta" colspan="3"></td>
			<td class="spc"></td>
			<?php } else { ?>
			<td class="cta"><?=$r[1]?></td>
			<td class="cta"><?=$r[-1]?></td>
			<td class="cta"><?=$r[0]?></td>
			<td class="cta"><a href="#" class="fao" act="wstat" y="<?=$year?>" w="<?=$week?>"><i class="fa fa-eye"></i></a></td>
			<?php } ?>
			<td class="spc"></td>
			<?php if (!$rh) { ?>
			<td class="cta" colspan="3"></td>
			<td></td>
			<?php } else { ?>
			<td class="cta"><?=$rh[1]?></td>
			<td class="cta"><?=$rh[-1]?></td>
			<td class="cta"><?=$rh[0]?></td>
			<td class="cta"><a href="#" class="fao" act="hstat" y="<?=$year?>" w="<?=$week?>"><i class="fa fa-eye"></i></a></td>
			<?php } ?>
		</tr>
		<?php } ?>
	</tbody>
</table>