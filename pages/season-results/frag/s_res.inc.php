<table class="data1<?php if ($mobile_user) { ?> w100<?php } ?>">
	<thead>
		<tr>
			<th><?php if ($stats_bc['pct'] !== '') { ?><?=$stats_bc['pct']?>%<?php } ?></td>
			<th><?=$stats_bc[1]?></th>
			<th><?=$stats_bc[-1]?></th>
			<th><?=$stats_bc[0]?></th>
		</tr>
		<tr>
			<th class="cta">Week</th>
			<th class="cta">Wins</th>
			<th class="cta">Loss</th>
			<th class="cta">Push</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($recs as $week=>$r) if ($week != 21) { ?>
		<tr>
			<?php if (!$r) { ?>
			<td class="cta"><?=bc::wk_name($week)?></td>
			<td class="cta" colspan="3"><i class="fa fa-hourglass-o"></i></td>
			<?php } else { ?>
			<td class="cta"><?=bc::wk_name($week)?><a href="#" act="wstat" y="<?=$year?>" w="<?=$week?>"><i class="fa fa-eye"></i></a></td>
			<td class="cta"><?=$r[1]?></td>
			<td class="cta"><?=$r[-1]?></td>
			<td class="cta"><?=$r[0]?></td>
			<?php } ?>
		</tr>
		<?php } ?>
	</tbody>
</table>