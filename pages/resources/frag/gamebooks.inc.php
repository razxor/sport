<?php
	$opts = $db->query("SELECT DISTINCT year, week FROM games WHERE gb_link != '' ORDER BY year DESC, week ASC");
	$seld = db::first($db->query("SELECT year, week FROM games WHERE gb_link != '' ORDER BY year DESC, week DESC LIMIT 1"));
	
	$recs = $db->query("SELECT * FROM games WHERE year = %u AND week = %u ORDER BY game_id ASC", $seld['year'], $seld['week']);
	pp::games($recs);
?>
<?php if (!$mobile_user) { ?>
<div class="spl">
	<div class="quat3"><h2>NFL Gamebook Links</h2></div>
	<div class="quat rta">
		<select id="wk_sel">
			<?php foreach ($opts as $p) { ?>
			<option value="<?=$p['year']?>.<?=$p['week']?>"<?php if ("{$seld['year']}.{$seld['week']}" == "{$p['year']}.{$p['week']}") { ?> selected="selected"<?php } ?>><?=$p['year']?> season, Week <?=bc::wk_name($p['week'])?></option>
			<?php } ?>
		</select>
	</div>
</div>
<?php } else { ?>
<h2 class="nomb">NFL Gamebook Links</h2>
<div>
<select id="wk_sel">
	<?php foreach ($opts as $p) { ?>
	<option value="<?=$p['year']?>.<?=$p['week']?>"<?php if ("{$seld['year']}.{$seld['week']}" == "{$p['year']}.{$p['week']}") { ?> selected="selected"<?php } ?>><?=$p['year']?> season, Week <?=bc::wk_name($p['week'])?></option>
	<?php } ?>
</select>
</div>
<br />
<?php } ?>
<div id="games" class="d1cont">
	<?php require 'gbl1.inc.php'; ?>
</div>