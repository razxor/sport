<?php
	$ss = bc::get_season('A');
	$wk = bc::get_week($ss['year'], 'G');
	$subo = db::first($db->query("SELECT * FROM subs WHERE (email = '%s' OR user_id = %u) AND year = '%s' AND (wknd != 0 OR pow != 0 OR opt != '')", $usr->p['email'], $usr->p['user_id'], $ss['year']));
	$subo2 = db::first($db->query("SELECT * FROM orders WHERE (email = '%s' OR user_id = %u) AND year = %u AND status = 'C' AND (opt = 'y' OR week = %u)", $usr->p['email'], $usr->p['user_id'], $ss['year'], $wk));
	$orders = $db->query("SELECT * FROM orders WHERE (email = '%s' OR user_id = %u) ORDER BY order_id DESC", $usr->p['email'], $usr->p['user_id']);
?>
<div class="box3">
	<div class="spl">
		<div class="quat3"><h2>Contact info</h2></div>
		<div class="quat rta"><a class="btn1" href="/account/edit/">Edit <i class="fa fa-pencil-alt"></i></a></div>
	</div>
	<table class="data2">
		<tr>
			<th>Name:</th>
			<td><?=hsc($usr->p['name'])?></td>
		</tr>
		<tr>
			<th>Email:</th>
			<td><?=hsc($usr->p['email'])?></td>
		</tr>
		<tr>
			<th>Phone:</th>
			<td>
				<?=hsc($usr->p['phone'])?>
			</td>
		</tr>
	</table>
	<hr />
	<div class="spl">
		<div class="quat3"><h2>Access data</h2></div>
		<div class="quat rta"><a class="btn1" href="/account/access/">Edit <i class="fa fa-pencil-alt"></i></a></div>
	</div>
	<table class="data2">
		<tr>
			<th>Login:</th>
			<td><?=hsc($usr->p['user'])?></td>
		</tr>
		<tr>
			<th>Password:</th>
			<td>Changed <?=D($usr->p['p_ts'] ? $usr->p['p_ts'] : $usr->p['c_ts'])?></td>
		</tr>
		<tr>
			<th>Last login:</th>
			<td><?=D($usr->p['last_login'])?></td>
		</tr>
	</table>
	<hr />
	<div class="spl">
		<div class="quat3"><h2>Mailing</h2></div>
		<div class="quat rta"><a class="btn1" href="/account/mailing/">Edit <i class="fa fa-pencil-alt"></i></a></div>
	</div>
	<?php if ($subo && $subo2) { ?>
	<div class="infoc">Since you have purchased a package, you will receive the final picks instead of the free ones this week.</div>
	<?php } ?>
	<?php if (!$subo) { ?>
	<div class="infoc">You are not subscribed to free emails</div>
	<?php } else { ?>
	<table class="data2">
		<tr>
			<th>Weekend Preview:</th>
			<td><?php if ($subo['wknd']) { ?><i class="fa fa-check"></i><?php } else { ?><i class="fa fa-close"></i><?php } ?></td>
		</tr>
		<tr>
			<th>Free Pick of the Week:</th>
			<td><?php if ($subo['pow']) { ?><i class="fa fa-check"></i><?php } else { ?><i class="fa fa-close"></i><?php } ?></td>
		</tr>
		<tr>
			<th>All picks at kickoff:</th>
			<td><?php if ($subo['opt'] == 'a') { ?><i class="fa fa-check"></i><?php } else { ?><i class="fa fa-close"></i><?php } ?></td>
		</tr>
		<tr>
			<th>Best pick at kickoff:</th>
			<td><?php if ($subo['opt'] == 'b') { ?><i class="fa fa-check"></i><?php } else { ?><i class="fa fa-close"></i><?php } ?></td>
		</tr>
	</table>
	<?php } ?>
	
	<?php if (count($orders)) { ?>
	<hr />
	<h2>Purchase history</h2>
	<table class="data1">
		<thead>
		<tr>
			<th class="lta">Date</th>
			<th class="rta">Amount</th>
			<th class="lta">Item</th>
			<th>Status</th>
		</tr>
		</thead>
		<?php foreach ($orders as $r) { ?>
		<tr>
			<td><?=D($r['c_ts'])?></td>
			<td class="rta"><?=P($r['price'])?></td>
			<td>
				<?php if ($r['opt'] == 'y') { ?>
				<?=$r['year']?> Season Package
				<?php } else { ?>
				<?=$r['year']?> Week <?=$r['week']?> Picks
				<?php } ?>
			</td>
			<td class="cta">
				<?php if ($r['status'] == 'C') { ?>
				<i class="fa fa-check"></i>
				<?php } else { ?>
				<i class="fa fa-close"></i>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
	</table>
	<?php } ?>
</div>