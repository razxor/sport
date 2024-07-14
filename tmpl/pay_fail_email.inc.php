<?php
	require dirname(__FILE__).'/style.inc.php';
?>
<body style="<?=$style['body']?>">
	<?php require dirname(__FILE__).'/header.inc.php'; ?>
	<div style="<?=$style['box1']?>">
		<span style="<?=$style['normal']?>">
			Greetings <?=hsc("{$r['data']['first_name']} {$r['data']['last_name']}")?>.
			Sorry to inform you, but your paypal payment failed.<br />
			Payment status: <?=hsc($r['data']['payment_status'])?><br />
		</span>
	</div>
	<?php require dirname(__FILE__).'/footer.inc.php'; ?>
</body>