<h2>Overall stats</h2>
<?php if ($mobile_user) { ?>
<div class="d1cont">
<table class="data3 w100">
	<thead>
		<tr>
			<th rowspan="2"></th>
			<th rowspan="2">S-U</th>
			<th colspan="3">Favored teams</th>
			<th rowspan="2">Med. spr.</th>
		</tr>
		<tr>
			<th>Total</th>
			<th>Wins</th>
			<th>Covers</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>Away</th>
			<td class="cta"><?=$st['su']['a']?></td>
			<td class="cta"><?=$st['fav']['a']['t']?></td>
			<td class="cta"><?=$st['fav']['a']['w']?></td>
			<td class="cta"><?=$st['cover']['a']?></td>
			<td class="cta"><?=$st['median']['a']?></td>
		</tr>
		<tr>
			<th>Home</th>
			<td class="cta"><?=$st['su']['h']?></td>
			<td class="cta"><?=$st['fav']['h']['t']?></td>
			<td class="cta"><?=$st['fav']['h']['w']?></td>
			<td class="cta"><?=$st['cover']['h']?></td>
			<td class="cta"><?=$st['median']['h']?></td>
		</tr>
	</tbody>
</table>
</div>
<?php } else { ?>
<table class="data3">
	<thead>
		<tr>
			<th rowspan="2"></th>
			<th rowspan="2">Straight-up</th>
			<th colspan="3">Favored teams</th>
			<th rowspan="2">Median spread</th>
		</tr>
		<tr>
			<th>Total</th>
			<th>Wins</th>
			<th>Covers</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>Away</th>
			<td class="cta"><?=$st['su']['a']?></td>
			<td class="cta"><?=$st['fav']['a']['t']?></td>
			<td class="cta"><?=$st['fav']['a']['w']?></td>
			<td class="cta"><?=$st['cover']['a']?></td>
			<td class="cta"><?=round($st['median']['a'], 1)?></td>
		</tr>
		<tr>
			<th>Home</th>
			<td class="cta"><?=$st['su']['h']?></td>
			<td class="cta"><?=$st['fav']['h']['t']?></td>
			<td class="cta"><?=$st['fav']['h']['w']?></td>
			<td class="cta"><?=$st['cover']['h']?></td>
			<td class="cta"><?=round($st['median']['h'], 1)?></td>
		</tr>
	</tbody>
</table>
<?php } ?>