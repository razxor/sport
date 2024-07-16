<?php
	require dirname(__FILE__).'/style.inc.php';
?>
<body style="<?=$style['body']?>">
	<?php require dirname(__FILE__).'/header.inc.php'; ?>
	<div style="<?=$style['box1']?>">
		<span style="<?=$style['normal']?>">
			A payment verification failure has occured. Something unexpected happened while trying to validate the payment.
			This could mean that someone is trying to be smart, but could be several reasons.<br />
			See the relevant data below and process the order manually.<br />
			<br />
			Error: <?=$r['err']?>
		</span>
		<pre><?=print_r($r['data'], 1)?></pre>
	</div>
	<?php require dirname(__FILE__).'/footer.inc.php'; ?>
</body>