<?php if ($mobile_user) { ?>
<table class="data1 w100">
	<thead>
		<tr>
			<th class="lta">Date</th>
			<th class="lta">Away</th>
			<th class="rta">Home</th>
			<th>Gamebook</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($recs as $r) { ?>
		<tr>
			<td><?=D3($r['g_ts'])?></td>
			<td><?=hsc($r['v_team']['name2'])?></td>
			<td class="rta"><?=hsc($r['h_team']['name2'])?></td>
			<td class="cta"><a class="btn1" target="_blank" href="<?=$r['gb_link']?>">Download<i class="fa fa-cloud-download-alt"></i></a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } else { ?>
<table class="data1 w100">
	<thead>
		<tr>
			<th class="lta">Date</th>
			<th class="lta" colspan="3">Away team</th>
			<th class="rta" colspan="3">Home team</th>
			<th>Gamebook</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($recs as $r) { ?>
		<tr>
			<td><?=DT($r['g_ts'])?></td>
			<td><img src="<?=$r['v_team_img']?>" class="team_img" /></td>
			<td><?=hsc($r['v_team']['name2'])?></td>
			<td class="rta"><b><?=$r['v_score']?></b></td>
			<td><b><?=$r['h_score']?></b></td>
			<td class="rta"><?=hsc($r['h_team']['name2'])?></td>
			<td><img src="<?=$r['h_team_img']?>" class="team_img" /></td>
			<td class="cta"><a class="btn1" target="_blank" href="<?=$r['gb_link']?>">Download<i class="fa fa-cloud-download-alt"></i></a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php } ?>