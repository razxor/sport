<?php require dirname(__FILE__).'/style.inc.php'; ?>
<body style="<?=$style['body']?>">
	<?php require dirname(__FILE__).'/header.inc.php'; ?>
	<div style="<?=$style['box1']?>">
		<span style="<?=$style['normal']?>">
			<?php if ($r['name']) { ?>
			Greetings <strong><?=hsc($r['name'])?></strong>.
			<?php } else { ?>
			Greetings!
			<?php } ?>
			<br /><br />
			We are leaning towards making the following picks this week:<br /><br />
			<?php foreach ($r['picks'] as $p) { ?>
			<?=$p['v_team']['name2']?> <?php if ($p['spread_f'] == 'a') { ?>(<?=$p['spread_dec']?>)<?php } ?>
			@
			<?=$p['h_team']['name2']?> <?php if ($p['spread_f'] == 'h') { ?>(<?=$p['spread_dec']?>)<?php } ?>;
			<b>PROBABLE PICK: <?=strtoupper($p['pick'] == 'a' ? $p['v_team']['name2'] : $p['h_team']['name2'])?></b><br />
			<?php } ?>
			<br /><br />
			Annoying? <a href="<?=$url_proto?>://<?=$maindw?>/index.php?page=unsub2&amp;email=<?=urlencode($r['email'])?>&amp;x=<?=$r['c_ts']?>">Unsubscribe here</a>.
		</span>
	</div>
	<?php require dirname(__FILE__).'/footer.inc.php'; ?>
</body>