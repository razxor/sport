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
			This week we are making <?=count($r['picks'])?> <?=count($r['picks']) == 1 ? 'pick' : 'picks'?> in the following games:<br /><br />
			<?php foreach ($r['picks'] as $p) { ?>
			<?=$p['v_team']['name2']?> <?php if ($p['spread_f'] == 'a') { ?>(<?=$p['spread_dec']?>)<?php } ?>
			@
			<?=$p['h_team']['name2']?> <?php if ($p['spread_f'] == 'h') { ?>(<?=$p['spread_dec']?>)<?php } ?>
			<br />
			<?php } ?>
			<br />
			Our picks are now available for purchase, please visit <a href="<?=$url_proto?>://<?=$maindw?>/purchases/"><?=$maind?>/purchases</a>.
			<br /><br />
			Bothersome? <a href="<?=$url_proto?>://<?=$maindw?>/index.php?page=unsub&amp;email=<?=urlencode($r['email'])?>">Unsubscribe here</a>.
		</span>
	</div>
	<?php require dirname(__FILE__).'/footer.inc.php'; ?>
</body>