<?php
	require dirname(__FILE__).'/style.inc.php';
?>
<body style="<?=$style['body']?>">
	<?php require dirname(__FILE__).'/header.inc.php'; ?>
	<div style="<?=$style['box1']?>">
		<span style="<?=$style['normal']?>">
			Greetings <strong><?=hsc($r['cli_name'])?></strong>.
			Your payment is successful and your order has been saved.<br />
			<?php if (!count($r['picks'])) { ?>
			Picks will be emailed to you when available.<br />
			<?php } else if (@$r['picks'][0]['pick_mod'] == 'p') { ?>
			Picks will be emailed to you when available.<br />
			<br />We are leaning towards making the following picks this week:<br />
			<?php foreach ($r['picks'] as $p) { ?>
			<?=$p['v_team']['name2']?> <?php if ($p['spread_f'] == 'a') { ?>(-<?=$p['spread'] / 10?>)<?php } ?>
			@
			<?=$p['h_team']['name2']?> <?php if ($p['spread_f'] == 'h') { ?>(-<?=$p['spread'] / 10?>)<?php } ?>;
			<b>PROBABLE PICK: <?=strtoupper($p['pick'] == 'a' ? $p['v_team']['name2'] : $p['h_team']['name2'])?></b><br />
			<?php } ?>
			<?php } else { ?>
			<br />Our picks this week are in the following games:<br />
			<?php foreach ($r['picks'] as $p) { ?>
			<?=$p['v_team']['name2']?> <?php if ($p['spread_f'] == 'a') { ?>(-<?=$p['spread'] / 10?>)<?php } ?>
			@
			<?=$p['h_team']['name2']?> <?php if ($p['spread_f'] == 'h') { ?>(-<?=$p['spread'] / 10?>)<?php } ?>;
			<b>PICK: <?=strtoupper($p['pick'] == 'a' ? $p['v_team']['name2'] : $p['h_team']['name2'])?></b><br />
			<?php } ?>
			<?php } ?>
			<br />
			<table border="0" cellpadding="5" cellspacing="0" style="<?=$style['split_tb2']?>">
				<tr>
					<td style="<?=$style['th']?>" nowrap="nowrap"><strong>Order ID</strong></td>
					<td style="<?=$style['td0']?>"><?=$r['order_id']?></td>
				</tr>
				<tr>
					<td style="<?=$style['th']?>" nowrap="nowrap"><strong>Date</strong></td>
					<td style="<?=$style['td0']?>"><?=D($r['c_ts'])?></td>
				</tr>
				<tr>
					<td style="<?=$style['th']?>" nowrap="nowrap"><strong>Transaction ID</strong></td>
					<td style="<?=$style['td0']?>"><?=hsc($r['txn_id'])?></td>
				</tr>
				<tr>
					<td style="<?=$style['th']?>" nowrap="nowrap"><strong>Item name</strong></td>
					<td style="<?=$style['td0']?>"><?=hsc($r['item_name'])?></td>
				</tr>
				<tr>
					<td style="<?=$style['th']?>" nowrap="nowrap"><strong>Price</strong></td>
					<td style="<?=$style['td0']?>"><?=P($r['price'])?></td>
				</tr>
			</table>
			<br />
		</span>
	</div>
	<?php require dirname(__FILE__).'/footer.inc.php'; ?>
</body>