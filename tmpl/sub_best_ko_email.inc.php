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
			Our best Pick of the Week is in the following game:<br /><br />
			<?php foreach ($r['picks'] as $p) { ?>
			<?=$p['v_team']['name2']?> <?php if ($p['spread_f'] == 'a') { ?>(<?=$p['spread_dec']?>)<?php } ?>
			@
			<?=$p['h_team']['name2']?> <?php if ($p['spread_f'] == 'h') { ?>(<?=$p['spread_dec']?>)<?php } ?>;
			<b>PICK: <?=strtoupper($p['pick'] == 'a' ? $p['v_team']['name2'] : $p['h_team']['name2'])?></b><br />
			<?php } ?>
			<br /><br />
			Bothersome? <a href="<?=$url_proto?>://<?=$maindw?>/index.php?page=unsub&amp;email=<?=urlencode($r['email'])?>">Unsubscribe here</a>.
		</span>
	</div>
	<?php require dirname(__FILE__).'/footer.inc.php'; ?>
</body>