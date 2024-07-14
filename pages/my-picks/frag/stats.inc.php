<h2>Pick stats</h2>
<?php if ($mobile_user) { ?>
<div class="d1cont">
<table class="data3 w100">
	<thead>
		<tr>
			<th></th>
			<th colspan="2">Picks</th>
			<th colspan="2">Favorite</th>
			<th colspan="2">Underdog</th>
		</tr>
		<tr>
			<th></th>
			<th>Total</th>
			<th>Wins</th>
			<th>Total</th>
			<th>Wins</th>
			<th>Total</th>
			<th>Wins</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>Away</th>
			<td class="cta"><?=$st['picks']['a']['t']?></td>
			<td class="cta"><?=$st['picks']['a']['w']?></td>
			<td class="cta"><?=$st['f']['a']['t']?></td>
			<td class="cta"><?=$st['f']['a']['w']?></td>
			<td class="cta"><?=$st['u']['a']['t']?></td>
			<td class="cta"><?=$st['u']['a']['w']?></td>
		</tr>
		<tr>
			<th>Home</th>
			<td class="cta"><?=$st['picks']['h']['t']?></td>
			<td class="cta"><?=$st['picks']['h']['w']?></td>
			<td class="cta"><?=$st['f']['h']['t']?></td>
			<td class="cta"><?=$st['f']['h']['w']?></td>
			<td class="cta"><?=$st['u']['h']['t']?></td>
			<td class="cta"><?=$st['u']['h']['w']?></td>
		</tr>
	</tbody>
</table>
</div>
<table class="data3 w100">
	<thead>
		<tr>
			<th>Won</th>
			<th>Lost</th>
			<th>Push</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="cta"><?=$st['won']?></td>
			<td class="cta"><?=$st['lost']?></td>
			<td class="cta"><?=$st['push']?></td>
		</tr>
	</tbody>
</table>
<div class="d1cont">
	<table class="data3 w100">
		<thead>
			<tr>
				<th colspan="5">Wagers</th>
			</tr>
			<tr>
				<th>Total</th>
				<th>To win</th>
				<th>Pending</th>
				<th>Won</th>
				<th>ROI</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="cta" rowspan="2"><?=P2($st['wagers']['total'])?></td>
				<td class="cta" rowspan="2"><?=P2($st['wagers']['to_win'])?></td>
				<td class="cta" rowspan="2"><?=P2($st['wagers']['pending'])?></td>
				<td class="cta" rowspan="2"><?=P2($st['wagers']['won'] - $st['wagers']['lost'])?></td>
				<td class="cta" rowspan="2">
					<?=$st['wagers']['roi']?>%
				</td>
			</tr>
		</tbody>
	</table>
</div>
<?php } else { ?>
<table class="data3 w100">
	<thead>
		<tr>
			<th></th>
			<th colspan="2">Picks</th>
			<th colspan="2">Favourite</th>
			<th colspan="2">Underdog</th>
			<th colspan="5">Wagers</th>
			<th rowspan="2">Won</th>
			<th rowspan="2">Lost</th>
			<th rowspan="2">Push</th>
		</tr>
		<tr>
			<th></th>
			<th>Total</th>
			<th>Wins</th>
			<th>Total</th>
			<th>Wins</th>
			<th>Total</th>
			<th>Wins</th>
			<th>Total</th>
			<th>To win</th>
			<th>Pending</th>
			<th>Won</th>
			<th>ROI</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>Away</th>
			<td class="cta"><?=$st['picks']['a']['t']?></td>
			<td class="cta"><?=$st['picks']['a']['w']?></td>
			<td class="cta"><?=$st['f']['a']['t']?></td>
			<td class="cta"><?=$st['f']['a']['w']?></td>
			<td class="cta"><?=$st['u']['a']['t']?></td>
			<td class="cta"><?=$st['u']['a']['w']?></td>
			<td class="cta" rowspan="2"><?=P2($st['wagers']['total'])?></td>
			<td class="cta" rowspan="2"><?=P2($st['wagers']['to_win'])?></td>
			<td class="cta" rowspan="2"><?=P2($st['wagers']['pending'])?></td>
			<td class="cta" rowspan="2"><?=P2($st['wagers']['won'] - $st['wagers']['lost'])?></td>
			<td class="cta" rowspan="2">
				<?=$st['wagers']['roi']?>%
			</td>
			<td class="cta" rowspan="2"><?=$st['won']?></td>
			<td class="cta" rowspan="2"><?=$st['lost']?></td>
			<td class="cta" rowspan="2"><?=$st['push']?></td>
		</tr>
		<tr>
			<th>Home</th>
			<td class="cta"><?=$st['picks']['h']['t']?></td>
			<td class="cta"><?=$st['picks']['h']['w']?></td>
			<td class="cta"><?=$st['f']['h']['t']?></td>
			<td class="cta"><?=$st['f']['h']['w']?></td>
			<td class="cta"><?=$st['u']['h']['t']?></td>
			<td class="cta"><?=$st['u']['h']['w']?></td>
		</tr>
	</tbody>
</table>
<?php } ?>